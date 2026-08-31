<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInscriptionRequest;
use App\Models\Formation;
use Illuminate\Http\Request;

class InscriptionController extends Controller
{
    public function store(StoreInscriptionRequest $request, Formation $formation)
    {
        // Vérifier qu'il reste des places
        if ($formation->remaining_places <= 0) {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Cette formation est complète.',
                ], 400);
            }
            
            return back()->withInput()->with('error', 'Cette formation est complète.');
        }

        // Créer l'inscription avec les statuts par défaut
        $inscription = $formation->inscriptions()->create([
            'nom_complet' => $request->validated('nom_complet'),
            'telephone' => $request->validated('telephone'),
            'email' => $request->validated('email'),
            'statut_inscription' => 'en_attente',
            'statut_paiement' => 'en_attente',
        ]);

        // Réponse selon le type de requête
        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Votre inscription a bien été enregistrée. Nous reviendrons vers vous pour le paiement.',
                'inscription' => $inscription,
            ]);
        }

        return back()->with('success', 'Votre inscription a bien été enregistrée. Nous reviendrons vers vous pour le paiement.');
    }
}
