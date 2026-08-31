<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TrainerProfileController extends Controller
{
    /**
     * Afficher le formulaire d'édition du profil
     */
    public function edit()
    {
        $user = Auth::user();
        return view('admin.trainer-profile.edit', compact('user'));
    }

    /**
     * Mettre à jour le profil du formateur
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'specialty' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'bio' => 'nullable|string|max:2000',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'website_url' => 'nullable|url|max:255',
            'tags' => 'nullable|string|max:500',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        // Mise à jour des champs texte
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'specialty' => $request->specialty,
            'location' => $request->location,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
            'website_url' => $request->website_url,
            'tags' => $request->tags ? array_map('trim', explode(',', $request->tags)) : null,
        ]);

        // Gestion de la photo de profil
        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $profilePhotoPath = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->update(['profile_photo' => $profilePhotoPath]);
        }

        // Gestion de l'image hero
        if ($request->hasFile('hero_image')) {
            if ($user->hero_image) {
                Storage::disk('public')->delete($user->hero_image);
            }
            $heroImagePath = $request->file('hero_image')->store('hero-images', 'public');
            $user->update(['hero_image' => $heroImagePath]);
        }

        // Mise à jour des statistiques
        $user->update([
            'formations_count' => $user->formations()->count(),
            'students_count' => $user->formations()->withCount('inscriptions')->get()->sum('inscriptions_count'),
        ]);

        return redirect()->route('trainer-profile.edit')->with('success', 'Votre profil a été mis à jour avec succès.');
    }

    /**
     * Supprimer la photo de profil
     */
    public function destroyProfilePhoto()
    {
        $user = Auth::user();
        
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->update(['profile_photo' => null]);
        }

        return back()->with('success', 'Photo de profil supprimée.');
    }

    /**
     * Supprimer l'image hero
     */
    public function destroyHeroImage()
    {
        $user = Auth::user();
        
        if ($user->hero_image) {
            Storage::disk('public')->delete($user->hero_image);
            $user->update(['hero_image' => null]);
        }

        return back()->with('success', 'Image hero supprimée.');
    }

    /**
     * Obtenir les données du formateur pour la vitrine
     */
    public function getTrainerData($userId = null)
    {
        $user = $userId ? \App\Models\User::find($userId) : Auth::user();
        
        if (!$user) {
            return null;
        }

        return [
            'name' => $user->name,
            'photo' => $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80',
            'specialty' => $user->specialty ?? 'Formateur',
            'location' => $user->location ?? 'Non renseigné',
            'phone' => $user->phone ?? '',
            'socials' => [
                ['name' => 'Instagram', 'url' => $user->instagram_url ?: '#', 'icon' => 'instagram'],
                ['name' => 'LinkedIn', 'url' => $user->linkedin_url ?: '#', 'icon' => 'linkedin'],
                ['name' => 'Site web', 'url' => $user->website_url ?: '#', 'icon' => 'globe'],
            ],
            'tags' => $user->tags ?? ['Formation', 'Compétences'],
            'stats' => [
                ['value' => $user->formations_count, 'label' => 'formations'],
                ['value' => $user->students_count > 1000 ? ($user->students_count / 1000) . 'k' : $user->students_count, 'label' => 'apprenants'],
                ['value' => $this->getAverageRating($user), 'label' => 'note moyenne'],
            ],
            'bio' => $user->bio ?? 'Aucune description disponible.',
            'hero_image' => $user->hero_image ? asset('storage/' . $user->hero_image) : 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1600&q=80',
        ];
    }

    /**
     * Calculer la note moyenne du formateur
     */
    private function getAverageRating($user)
    {
        $totalRating = 0;
        $totalEvaluations = 0;

        foreach ($user->formations as $formation) {
            $formationRating = $formation->averageRating();
            if ($formationRating > 0) {
                $totalRating += $formationRating;
                $totalEvaluations++;
            }
        }

        return $totalEvaluations > 0 ? number_format($totalRating / $totalEvaluations, 1) : '0.0';
    }
}