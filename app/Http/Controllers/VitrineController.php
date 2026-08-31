<?php

namespace App\Http\Controllers;

use App\Models\Formation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class VitrineController extends Controller
{
    private function getTrainerData(): array
    {
        // Récupérer le premier utilisateur formateur (pour l'instant)
        // Dans un vrai système, on pourrait avoir un système multi-formateurs
        $trainer = User::whereHas('formations')->first();
        
        if (!$trainer) {
            // Données par défaut si aucun formateur
            return [
                'name' => 'FormatPro',
                'photo' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80',
                'specialty' => 'Plateforme de formation professionnelle',
                'location' => 'Dakar, Sénégal',
                'phone' => '221770000000',
                'socials' => [
                    ['name' => 'Instagram', 'url' => 'https://instagram.com', 'icon' => 'instagram'],
                    ['name' => 'LinkedIn', 'url' => 'https://linkedin.com', 'icon' => 'linkedin'],
                    ['name' => 'Site web', 'url' => 'https://formatpro.dev', 'icon' => 'globe'],
                ],
                'tags' => ['Formation', 'Compétences', 'Professionnalisme'],
                'stats' => [
                    ['value' => '0', 'label' => 'formations'],
                    ['value' => '0', 'label' => 'apprenants'],
                    ['value' => '0.0', 'label' => 'note moyenne'],
                ],
                'bio' => 'Bienvenue sur FormatPro, votre plateforme de formation professionnelle.',
                'hero_image' => 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1600&q=80',
            ];
        }

        // Calculer les statistiques
        $formationsCount = $trainer->formations()->count();
        $studentsCount = $trainer->formations()->withCount('inscriptions')->get()->sum('inscriptions_count');
        
        // Calculer la note moyenne
        $totalRating = 0;
        $totalEvaluations = 0;
        foreach ($trainer->formations as $formation) {
            $formationRating = $formation->averageRating();
            if ($formationRating > 0) {
                $totalRating += $formationRating;
                $totalEvaluations++;
            }
        }
        $averageRating = $totalEvaluations > 0 ? number_format($totalRating / $totalEvaluations, 1) : '0.0';

        return [
            'name' => $trainer->name,
            'photo' => $trainer->profile_photo ? asset('storage/' . $trainer->profile_photo) : 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=400&q=80',
            'specialty' => $trainer->specialty ?? 'Formateur professionnel',
            'location' => $trainer->location ?? 'Non renseigné',
            'phone' => $trainer->phone ?? '',
            'socials' => [
                ['name' => 'Instagram', 'url' => $trainer->instagram_url ?: '#', 'icon' => 'instagram'],
                ['name' => 'LinkedIn', 'url' => $trainer->linkedin_url ?: '#', 'icon' => 'linkedin'],
                ['name' => 'Site web', 'url' => $trainer->website_url ?: '#', 'icon' => 'globe'],
            ],
            'tags' => $trainer->tags ?? ['Formation', 'Compétences'],
            'stats' => [
                ['value' => $formationsCount, 'label' => 'formations'],
                ['value' => $studentsCount > 1000 ? ($studentsCount / 1000) . 'k' : $studentsCount, 'label' => 'apprenants'],
                ['value' => $averageRating, 'label' => 'note moyenne'],
            ],
            'bio' => $trainer->bio ?? 'Aucune description disponible.',
            'hero_image' => $trainer->hero_image ? asset('storage/' . $trainer->hero_image) : 'https://images.unsplash.com/photo-1516321497487-e288fb19713f?auto=format&fit=crop&w=1600&q=80',
        ];
    }

    public function index()
    {
        $formateur = $this->getTrainerData();
        $formations = Formation::where('status', 'Actif')
            ->orderBy('start_date', 'asc')
            ->get();

        return view('vitrine.index', compact('formateur', 'formations'));
    }

    public function dashboard()
    {
        $formateur = $this->getTrainerData();
        $formations = Auth::user()->formations()->orderBy('start_date', 'asc')->get();
        $upcoming = $formations->take(5);
        $totalInscrits = $formations->sum(fn ($formation) => $formation->inscriptions()->count());
        $totalPlaces = $formations->sum('remaining_places');
        $estimatedRevenue = $formations->sum(fn ($formation) => $formation->inscriptions()->count() * $formation->price);

        return view('dashboard', compact('formateur', 'formations', 'upcoming', 'totalInscrits', 'totalPlaces', 'estimatedRevenue'));
    }

    public function createFormation()
    {
        return view('admin.nouvelle-formation', ['formation' => null]);
    }

    public function storeFormation(Request $request)
    {
        \Log::info('=== DEBUT STORE FORMATION ===', [
            'method' => $request->method(),
            'has_file' => $request->hasFile('cover_image'),
            'all_input' => $request->all(),
            'user_id' => Auth::id(),
        ]);

        try {
            $valid = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'short_description' => ['required', 'string', 'max:255'],
                'full_description' => ['required', 'string'],
                'category' => ['required', 'string'],
                'level' => ['required', 'string'],
                'start_date' => ['nullable', 'date'],
                'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
                'mode' => ['required', 'string'],
                'delivery_link' => ['nullable', 'string', 'max:255'],
                'price' => ['required', 'numeric', 'min:0'],
                'currency' => ['required', 'string'],
                'max_places' => ['required', 'integer', 'min:1'],
                'trainer_name' => ['nullable', 'string', 'max:255'],
                'objectives' => ['nullable', 'array'],
                'objectives.*' => ['nullable', 'string'],
                'modules' => ['nullable', 'array'],
                'modules.*' => ['nullable', 'array'],
                'practical_info' => ['nullable', 'array'],
                'practical_info.*' => ['nullable', 'string'],
                'cover_image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:4096'],
            ]);
       
        \Log::info('Validation réussie', ['validated' => $valid]);

        $slug = Str::slug($valid['name']);
        $baseSlug = $slug;
        $counter = 1;
        while (Formation::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        $imageUrl = null;
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $imagePath = $request->file('cover_image')->store('formations', 'public');
            $imageUrl = Storage::url($imagePath);
        }

        \Log::info('Tentative de création de formation', [
            'user_id' => Auth::id(),
            'validated_data' => $valid,
            'has_image' => $request->hasFile('cover_image'),
            'image_url' => $imageUrl,
        ]);
       
        // Process modules data
        $modules = $valid['modules'] ?? [];
        $processedModules = [];
        foreach ($modules as $module) {
            if (is_array($module)) {
                $processedModules[] = [
                    'title' => $module['title'] ?? '',
                    'description' => $module['description'] ?? ''
                ];
            } else {
                $processedModules[] = [
                    'title' => $module,
                    'description' => ''
                ];
            }
        }

        $formation = Formation::create([
            'user_id' => Auth::id(),
            'slug' => $slug,
            'title' => $valid['name'],
            'trainer_name' => $valid['trainer_name'] ?? Auth::user()->name,
            'short_description' => $valid['short_description'],
            'full_description' => $valid['full_description'],
            'category' => $valid['category'],
            'level' => $valid['level'],
            'start_date' => $valid['start_date'],
            'end_date' => $valid['end_date'],
            'mode' => $valid['mode'],
            'location' => $valid['delivery_link'],
            'delivery_link' => $valid['delivery_link'],
            'price' => $valid['price'],
            'currency' => $valid['currency'],
            'max_places' => $valid['max_places'],
            'image' => $imageUrl,
            'objectives' => $valid['objectives'] ?? [],
            'modules' => $processedModules,
            'practical_info' => $valid['practical_info'] ?? [],
            'status' => 'Brouillon',
        ]);

        \Log::info('Formation créée avec succès', ['formation_id' => $formation->id, 'slug' => $formation->slug]);

        return redirect()->route('formations.mes')->with('success', 'Formation créée avec succès !');
        
        } catch (\Exception $e) {
            \Log::error('Erreur lors de la création de formation', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            
            return back()->withInput()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function editFormation(string $slug)
    {
        $formation = Auth::user()->formations()->where('slug', $slug)->firstOrFail();

        // Log pour debug
        \Log::info('Chargement formation pour édition', [
            'slug' => $slug,
            'formation_id' => $formation->id,
            'title' => $formation->title,
            'category' => $formation->category,
            'mode' => $formation->mode,
            'start_date' => $formation->start_date,
            'end_date' => $formation->end_date,
        ]);

        return view('admin.nouvelle-formation', compact('formation'));
    }

    public function updateFormation(Request $request, string $slug)
    {
        $formation = Auth::user()->formations()->where('slug', $slug)->firstOrFail();

        $valid = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_description' => ['required', 'string', 'max:255'],
            'full_description' => ['required', 'string'],
            'category' => ['required', 'string'],
            'level' => ['required', 'string'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date'],
            'mode' => ['required', 'string'],
            'delivery_link' => ['nullable', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'currency' => ['required', 'string'],
            'max_places' => ['required', 'integer', 'min:1'],
            'trainer_name' => ['nullable', 'string', 'max:255'],
            'objectives' => ['nullable', 'array'],
            'modules' => ['nullable', 'array'],
            'practical_info' => ['nullable', 'array'],
        ]);

        $newSlug = Str::slug($valid['name']);
        if ($newSlug !== $formation->slug) {
            $baseSlug = $newSlug;
            $counter = 1;
            while (Formation::where('slug', $newSlug)->where('id', '!=', $formation->id)->exists()) {
                $newSlug = $baseSlug . '-' . $counter;
                $counter++;
            }
        }

        $imageUrl = $formation->image;
        if ($request->hasFile('cover_image') && $request->file('cover_image')->isValid()) {
            $imagePath = $request->file('cover_image')->store('formations', 'public');
            $imageUrl = Storage::url($imagePath);
        }

        $formation->update([
            'slug' => $newSlug,
            'category' => $valid['category'],
            'mode' => $valid['mode'],
            'level' => $valid['level'],
            'title' => $valid['name'],
            'trainer_name' => $valid['trainer_name'] ?? Auth::user()->name,
            'short_description' => $valid['short_description'],
            'full_description' => $valid['full_description'],
            'status' => $valid['status'],
            'start_date' => $valid['start_date'],
            'end_date' => $valid['end_date'],
            'location' => $valid['delivery_link'],
            'max_places' => $valid['max_places'],
            'price' => $valid['price'],
            'currency' => $valid['currency'],
            'delivery_link' => $valid['delivery_link'],
            'image' => $imageUrl,
            'objectives' => $valid['objectives'] ?? [],
            'modules' => $valid['modules'] ?? [],
            'practical_info' => array_filter(array_map('trim', $valid['practical_info'] ?? [])),
            'about' => substr($valid['full_description'], 0, 220),
        ]);

        return redirect()->route('formations.mes')->with('success', 'Formation mise à jour avec succès.');
    }

    public function destroyFormation(string $slug)
    {
        $formation = Auth::user()->formations()->where('slug', $slug)->firstOrFail();
        $formation->delete();

        return redirect()->route('formations.mes')->with('success', 'Formation supprimée avec succès.');
    }

    public function publishFormation(string $slug)
    {
        $formation = Auth::user()->formations()->where('slug', $slug)->firstOrFail();
        $formation->update(['status' => 'Actif']);

        return redirect()->route('formations.mes')->with('success', 'Formation publiée avec succès. Elle est maintenant visible sur la vitrine.');
    }

    public function unpublishFormation(string $slug)
    {
        $formation = Auth::user()->formations()->where('slug', $slug)->firstOrFail();
        $formation->update(['status' => 'Brouillon']);

        return redirect()->route('formations.mes')->with('success', 'Formation retirée de la vitrine.');
    }

    public function mesFormations()
    {
        $formateur = $this->getTrainerData();
        $formations = Auth::user()->formations()->orderBy('start_date', 'asc')->get();

        return view('mes-formations', compact('formateur', 'formations'));
}

    public function show(string $slug)
    {
        $formation = Formation::where('slug', $slug)->firstOrFail();
        $formateur = $this->getTrainerData();

        return view('vitrine.show', compact('formation', 'formateur'));
    }

    public function posterGenerator(string $slug)
    {
        $formation = Formation::where('slug', $slug)->firstOrFail();

        // Log pour debug
        \Log::info('Chargement générateur affiche', [
            'slug' => $slug,
            'formation_id' => $formation->id,
            'title' => $formation->title,
            'has_data' => !empty($formation->title),
        ]);

        return view('generator', compact('formation'));
    }


}
