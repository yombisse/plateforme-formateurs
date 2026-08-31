@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-slate-50 px-4 py-8 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-4xl">
        {{-- En-tête --}}
        <div class="flex items-center justify-between mb-8">
            <div class="flex items-center gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center h-10 w-10 rounded-full bg-white shadow-sm border border-slate-200 text-slate-700 hover:bg-slate-50 transition">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Mon profil formateur</h1>
                    <p class="text-sm text-slate-500 mt-1">Gérez vos informations personnelles</p>
                </div>
            </div>
        </div>

        @if(session('success'))
            <div class="rounded-[16px] border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-900 shadow-sm mb-8">{{ session('success') }}</div>
        @endif

        <form action="{{ route('trainer-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            {{-- Informations de base --}}
            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-6">Informations de base</h2>
                
                <div class="grid gap-6 lg:grid-cols-2">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Nom complet</label>
                        <input type="text" name="name" value="{{ $user->name }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" required class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Spécialité</label>
                        <input type="text" name="specialty" value="{{ $user->specialty }}" placeholder="Ex: Marketing Digital, Leadership..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Localisation</label>
                        <input type="text" name="location" value="{{ $user->location }}" placeholder="Ex: Dakar, Sénégal" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Téléphone / WhatsApp</label>
                        <input type="text" name="phone" value="{{ $user->phone }}" placeholder="+221 77 000 00 00" class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
                
                <div class="mt-6">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Bio</label>
                    <textarea name="bio" rows="4" placeholder="Décrivez votre parcours et votre expertise..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">{{ $user->bio }}</textarea>
                    <p class="text-xs text-slate-500 mt-1">Maximum 2000 caractères</p>
                </div>
            </div>

            {{-- Photos --}}
            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-6">Photos</h2>
                
                <div class="grid gap-6 lg:grid-cols-2">
                    {{-- Photo de profil --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Photo de profil</label>
                        <div class="flex items-start gap-4">
                            @if($user->profile_photo)
                                <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="Photo de profil" class="h-20 w-20 rounded-full object-cover">
                            @else
                                <div class="h-20 w-20 rounded-full bg-slate-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="profile_photo" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                <p class="text-xs text-slate-500 mt-1">JPG, PNG, GIF. Max 2MB.</p>
                                @if($user->profile_photo)
                                    <form action="{{ route('trainer-profile.destroy-profile-photo') }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700">Supprimer la photo</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    {{-- Image hero --}}
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Image de couverture</label>
                        <div class="flex items-start gap-4">
                            @if($user->hero_image)
                                <img src="{{ asset('storage/' . $user->hero_image) }}" alt="Image hero" class="h-20 w-32 object-cover rounded-lg">
                            @else
                                <div class="h-20 w-32 rounded-lg bg-slate-200 flex items-center justify-center">
                                    <svg class="w-8 h-8 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" name="hero_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                                <p class="text-xs text-slate-500 mt-1">JPG, PNG, GIF. Max 4MB.</p>
                                @if($user->hero_image)
                                    <form action="{{ route('trainer-profile.destroy-hero-image') }}" method="POST" class="mt-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs text-red-600 hover:text-red-700">Supprimer l'image</button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Réseaux sociaux --}}
            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-6">Réseaux sociaux</h2>
                
                <div class="grid gap-6 lg:grid-cols-3">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Instagram</label>
                        <input type="url" name="instagram_url" value="{{ $user->instagram_url }}" placeholder="https://instagram.com/..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">LinkedIn</label>
                        <input type="url" name="linkedin_url" value="{{ $user->linkedin_url }}" placeholder="https://linkedin.com/in/..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-2">Site web</label>
                        <input type="url" name="website_url" value="{{ $user->website_url }}" placeholder="https://..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    </div>
                </div>
            </div>

            {{-- Tags/Compétences --}}
            <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-slate-900 mb-6">Compétences</h2>
                
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Tags (séparés par des virgules)</label>
                    <input type="text" name="tags" value="{{ old('tags', $user->tags ? implode(', ', $user->tags) : '') }}" placeholder="Marketing, Leadership, Communication..." class="w-full rounded-lg border border-slate-300 px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500">
                    <p class="text-xs text-slate-500 mt-1">Séparez les compétences par des virgules</p>
                </div>
                
                @if($user->tags)
                    <div class="mt-4 flex flex-wrap gap-2">
                        @foreach($user->tags as $tag)
                            <span class="inline-flex items-center rounded-full bg-orange-50 px-3 py-1 text-sm font-medium text-orange-600">{{ $tag }}</span>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Boutons d'action --}}
            <div class="flex items-center justify-end gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Annuler
                </a>
                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-3 text-sm font-semibold text-white transition hover:bg-orange-700">
                    Enregistrer les modifications
                </button>
            </div>
        </form>
    </div>
</div>
@endsection