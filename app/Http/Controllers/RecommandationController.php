<?php

namespace App\Http\Controllers;

use App\Models\Recommandation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecommandationController extends Controller
{
    /**
     * Afficher les recommandations d'un formateur
     */
    public function index($trainerId)
    {
        $trainer = User::with('recommandations.user')->findOrFail($trainerId);
        $recommandations = $trainer->recommandations()->where('is_public', true)->orderBy('created_at', 'desc')->get();
        
        $totalRecommandations = $trainer->recommandations()->where('is_public', true)->count();
        
        return view('recommandations.index', compact('trainer', 'recommandations', 'totalRecommandations'));
    }

    /**
     * Créer une nouvelle recommandation
     */
    public function store(Request $request, $trainerId)
    {
        \Log::info('=== DEBUT STORE RECOMMANDATION ===', [
            'trainer_id' => $trainerId,
            'is_authenticated' => Auth::check(),
            'user_id' => Auth::id(),
            'request_data' => $request->all(),
        ]);

        try {
            $request->validate([
                'comment' => 'required|string|max:1000',
                'is_public' => 'nullable|boolean',
                'guest_name' => 'nullable|string|max:255|required_without:user_id',
            ]);

            $trainer = User::findOrFail($trainerId);
            \Log::info('Trainer trouvé', ['trainer_id' => $trainer->id, 'trainer_name' => $trainer->name]);

            // Pour les utilisateurs authentifiés
            if (Auth::check()) {
                $existingRecommandation = Recommandation::where('user_id', Auth::id())
                    ->where('trainer_id', $trainerId)
                    ->first();

                if ($existingRecommandation) {
                    \Log::info('Recommandation déjà existante pour utilisateur authentifié', ['user_id' => Auth::id()]);
                    return back()->with('error', 'Vous avez déjà recommandé ce formateur.');
                }

                // Empêcher un formateur de se recommander lui-même
                if ($trainerId == Auth::id()) {
                    \Log::info('Tentative d\'auto-recommandation', ['user_id' => Auth::id()]);
                    return back()->with('error', 'Vous ne pouvez pas vous recommander vous-même.');
                }

                $recommandation = Recommandation::create([
                    'user_id' => Auth::id(),
                    'trainer_id' => $trainerId,
                    'comment' => $request->comment,
                    'is_public' => $request->is_public ?? true,
                ]);

                \Log::info('Recommandation créée pour utilisateur authentifié', ['recommandation_id' => $recommandation->id]);
            } else {
                // Pour les utilisateurs non authentifiés
                \Log::info('Création recommandation pour utilisateur non authentifié', [
                    'guest_name' => $request->guest_name,
                ]);

                $recommandation = Recommandation::create([
                    'user_id' => null,
                    'trainer_id' => $trainerId,
                    'comment' => $request->comment,
                    'is_public' => $request->is_public ?? true,
                    'guest_name' => $request->guest_name,
                ]);

                \Log::info('Recommandation créée pour utilisateur non authentifié', ['recommandation_id' => $recommandation->id]);
            }

            return back()->with('success', 'Votre recommandation a été enregistrée avec succès.');
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de recommandation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->withInput()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    /**
     * Mettre à jour une recommandation
     */
    public function update(Request $request, $recommandationId)
    {
        $request->validate([
            'comment' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
        ]);

        $recommandation = Recommandation::findOrFail($recommandationId);

        // Vérifier que l'utilisateur est bien l'auteur de la recommandation
        if ($recommandation->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de modifier cette recommandation.');
        }

        $recommandation->update([
            'comment' => $request->comment,
            'is_public' => $request->is_public ?? $recommandation->is_public,
        ]);

        return back()->with('success', 'Votre recommandation a été mise à jour avec succès.');
    }

    /**
     * Supprimer une recommandation
     */
    public function destroy($recommandationId)
    {
        $recommandation = Recommandation::findOrFail($recommandationId);

        // Vérifier que l'utilisateur est bien l'auteur de la recommandation ou le formateur concerné
        if ($recommandation->user_id !== Auth::id() && $recommandation->trainer_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de supprimer cette recommandation.');
        }

        $recommandation->delete();

        return back()->with('success', 'La recommandation a été supprimée avec succès.');
    }

    /**
     * API pour obtenir les statistiques de recommandation
     */
    public function stats($trainerId)
    {
        $trainer = User::findOrFail($trainerId);
        
        $stats = [
            'total' => $trainer->recommandations()->where('is_public', true)->count(),
            'recent' => $trainer->recommandations()->where('is_public', true)->count(),
        ];

        return response()->json($stats);
    }

    /**
     * Afficher le formulaire de recommandation
     */
    public function create($trainerId)
    {
        $trainer = User::findOrFail($trainerId);
        
        // Vérifier si l'utilisateur a déjà recommandé ce formateur
        $existingRecommandation = Recommandation::where('user_id', Auth::id())
            ->where('trainer_id', $trainerId)
            ->first();

        if ($existingRecommandation) {
            return back()->with('error', 'Vous avez déjà recommandé ce formateur.');
        }

        return view('recommandations.create', compact('trainer'));
    }
}