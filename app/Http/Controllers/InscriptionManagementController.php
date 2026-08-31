<?php

namespace App\Http\Controllers;

use App\Models\Inscription;
use App\Models\Formation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscriptionManagementController extends Controller
{
    /**
     * Afficher les inscriptions d'une formation
     */
    public function index($formationId)
    {
        $formation = Formation::with('inscriptions.validatedBy', 'inscriptions.rejectedBy')
            ->where('id', $formationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $inscriptions = $formation->inscriptions()->orderBy('created_at', 'desc')->get();

        return view('admin.inscriptions.index', compact('formation', 'inscriptions'));
    }

    /**
     * Valider une inscription
     */
    public function accept(Request $request, $inscriptionId)
    {
        $inscription = Inscription::with('formation')->findOrFail($inscriptionId);
        
        // Vérifier que l'utilisateur est bien le propriétaire de la formation
        if ($inscription->formation->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de valider cette inscription.');
        }

        $inscription->update([
            'statut_inscription' => 'valide',
            'statut_paiement' => 'confirme', // Le paiement est aussi confirmé quand l'inscription est validée
            'valide_par' => Auth::id(),
            'date_validation' => now(),
        ]);

        // Envoyer message WhatsApp de confirmation
        $whatsappUrl = $this->sendWhatsAppMessage($inscription, 'confirmation');

        return back()->with('success', 'Inscription validée avec succès. Le paiement est également confirmé.')->with('whatsapp_url', $whatsappUrl);
    }

    /**
     * Rejeter une inscription
     */
    public function reject(Request $request, $inscriptionId)
    {
        $request->validate([
            'motif_rejet' => 'required|string|max:500'
        ]);

        $inscription = Inscription::with('formation')->findOrFail($inscriptionId);
        
        // Vérifier que l'utilisateur est bien le propriétaire de la formation
        if ($inscription->formation->user_id !== Auth::id()) {
            return back()->with('error', 'Vous n\'avez pas le droit de rejeter cette inscription.');
        }

        $inscription->update([
            'statut_inscription' => 'rejete',
            'motif_rejet' => $request->motif_rejet,
            'rejet_par' => Auth::id(),
            'date_rejet' => now(),
        ]);

        // Envoyer message WhatsApp de rejet
        $whatsappUrl = $this->sendWhatsAppMessage($inscription, 'rejet');

        return back()->with('success', 'Inscription rejetée.')->with('whatsapp_url', $whatsappUrl);
    }

    /**
     * Envoyer un message WhatsApp
     */
    private function sendWhatsAppMessage(Inscription $inscription, $type)
    {
        $formation = $inscription->formation;
        $telephone = $inscription->telephone;
        
        // Formater le numéro pour WhatsApp (format international sans le +)
        $whatsappNumber = preg_replace('/[^0-9]/', '', $telephone);
        
        if ($type === 'confirmation') {
            $message = "🎉 *FÉLICITATIONS !*\n\n";
            $message .= "Votre inscription à la formation *{$formation->title}* a été validée !\n\n";
            $message .= "📅 Date : " . ($formation->start_date ? \Carbon\Carbon::parse($formation->start_date)->format('d/m/Y') : 'À planifier') . "\n";
            $message .= "💰 Prix : " . ($formation->price ? number_format($formation->price) . ' ' . $formation->currency : 'Gratuit') . "\n";
            $message .= "📍 Lieu : " . ($formation->delivery_link ?? 'Communicé ultérieurement') . "\n\n";
            $message .= "Merci pour votre confiance ! 🙏";
        } else {
            $message = "⚠️ *INSCRIPTION REJETÉE*\n\n";
            $message .= "Votre inscription à la formation *{$formation->title}* n'a pas été retenue.\n\n";
            $message .= "📋 Motif : " . $inscription->motif_rejet . "\n\n";
            $message .= "N'hésitez pas à nous contacter pour plus d'informations. 📞";
        }

        return "https://wa.me/{$whatsappNumber}?text=" . urlencode($message);
    }

    /**
     * Obtenir les statistiques des inscriptions
     */
    public function stats($formationId)
    {
        $formation = Formation::where('id', $formationId)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $stats = [
            'total' => $formation->inscriptions()->count(),
            'en_attente' => $formation->inscriptions()->where('statut_inscription', 'en_attente')->count(),
            'validees' => $formation->inscriptions()->where('statut_inscription', 'valide')->count(),
            'rejetes' => $formation->inscriptions()->where('statut_inscription', 'rejete')->count(),
        ];

        return response()->json($stats);
    }
}