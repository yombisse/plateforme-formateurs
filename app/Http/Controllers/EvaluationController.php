<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{
    /**
     * Afficher les évaluations d'une formation
     */
    public function index($formationId)
    {
        $formation = Formation::with('evaluations.user')->findOrFail($formationId);
        $evaluations = $formation->evaluations()->orderBy('created_at', 'desc')->get();
        
        $averageRating = $formation->averageRating();
        $ratingDistribution = $this->getRatingDistribution($formation);
        
        return view('evaluations.index', compact('formation', 'evaluations', 'averageRating', 'ratingDistribution'));
    }

    /**
     * Créer une nouvelle évaluation
     */
    public function store(Request $request, $formationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:1000',
            'guest_name' => 'nullable|string|max:255|required_without:user_id',
        ]);

        $formation = Formation::findOrFail($formationId);

        // Pour les utilisateurs authentifiés
        if (Auth::check()) {
            $existingEvaluation = Evaluation::where('formation_id', $formationId)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingEvaluation) {
                return back()->with('error', 'Vous avez déjà évalué cette formation.');
            }

            Evaluation::create([
                'formation_id' => $formationId,
                'user_id' => Auth::id(),
                'rating' => $request->rating,
                'comment' => $request->comment,
            ]);
        } else {
            // Pour les utilisateurs non authentifiés
            Evaluation::create([
                'formation_id' => $formationId,
                'user_id' => null,
                'rating' => $request->rating,
                'comment' => $request->comment,
                'guest_name' => $request->guest_name,
            ]);
        }

        return back()->with('success', 'Votre évaluation a été enregistrée avec succès.');
    }

    /**
     * Mettre à jour une évaluation
     */
    public function update(Request $request, $evaluationId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $evaluation = Evaluation::findOrFail($evaluationId);

        // Vérifier que l'utilisateur est bien l'auteur de l'évaluation
        if ($evaluation->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de modifier cette évaluation.');
        }

        $evaluation->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Votre évaluation a été mise à jour avec succès.');
    }

    /**
     * Supprimer une évaluation
     */
    public function destroy($evaluationId)
    {
        $evaluation = Evaluation::findOrFail($evaluationId);

        // Vérifier que l'utilisateur est bien l'auteur de l'évaluation ou le propriétaire de la formation
        if ($evaluation->user_id !== Auth::id() && $evaluation->formation->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de supprimer cette évaluation.');
        }

        $evaluation->delete();

        return back()->with('success', 'L\'évaluation a été supprimée avec succès.');
    }

    /**
     * Obtenir la distribution des notes (nombre d'évaluations par étoile)
     */
    private function getRatingDistribution(Formation $formation)
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $formation->evaluations()->where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * API pour obtenir les statistiques d'évaluation
     */
    public function stats($formationId)
    {
        $formation = Formation::findOrFail($formationId);
        
        $stats = [
            'average' => $formation->averageRating(),
            'total' => $formation->evaluations()->count(),
            'distribution' => $this->getRatingDistribution($formation),
        ];

        return response()->json($stats);
    }
}