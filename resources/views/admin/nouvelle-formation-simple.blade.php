@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FAFAFA] px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[620px] space-y-6">
        <div class="rounded-[16px] border border-slate-200 bg-white px-6 py-7 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-600">{{ $formation ? 'Modifier une formation' : 'Nouvelle formation' }}</p>
            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">{{ $formation ? 'Modifier la formation' : 'Nouvelle formation' }}</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $formation ? 'Mettez à jour les informations et publiez vos changements.' : 'Complétez les informations ci-dessous pour créer une nouvelle formation.' }}</p>
        </div>

        @if($errors->any())
            <div class="rounded-[16px] border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ $formation ? route('admin.formation.update', $formation->slug) : route('admin.formation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($formation)
                @method('PUT')
            @endif

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Informations générales</h2>
                    <p class="mt-2 text-sm text-slate-500">Donnez un titre, résumez l'essentiel et choisissez les paramètres principaux.</p>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nom de la formation <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $formation?->title ?? '') }}" placeholder="Ex : Marketing Digital pour Débutants" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required />
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Formateur (optionnel)</label>
                        <input type="text" name="trainer_name" value="{{ old('trainer_name', $formation?->trainer_name ?? '') }}" placeholder="Laisser vide pour l'utilisateur connecté" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                        @error('trainer_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description courte <span class="text-red-500">*</span></label>
                        <textarea name="short_description" rows="3" placeholder="Résumez votre formation en quelques phrases." class="min-h-[96px] w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required>{{ old('short_description', $formation?->short_description ?? '') }}</textarea>
                        @error('short_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description complète <span class="text-red-500">*</span></label>
                        <textarea name="full_description" rows="6" placeholder="Décrivez en détail le contenu de votre formation..." class="min-h-[144px] w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required>{{ old('full_description', $formation?->full_description ?? '') }}</textarea>
                        @error('full_description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Catégorie <span class="text-red-500">*</span></label>
                            <select name="category" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required>
                                <option value="">Sélectionner une catégorie</option>
                                <option value="Marketing" {{ old('category', $formation?->category ?? '') === 'Marketing' ? 'selected' : '' }}>Marketing</option>
                                <option value="Informatique" {{ old('category', $formation?->category ?? '') === 'Informatique' ? 'selected' : '' }}>Informatique</option>
                                <option value="Design" {{ old('category', $formation?->category ?? '') === 'Design' ? 'selected' : '' }}>Design</option>
                                <option value="Management" {{ old('category', $formation?->category ?? '') === 'Management' ? 'selected' : '' }}>Management</option>
                                <option value="Finance" {{ old('category', $formation?->category ?? '') === 'Finance' ? 'selected' : '' }}>Finance</option>
                                <option value="Communication" {{ old('category', $formation?->category ?? '') === 'Communication' ? 'selected' : '' }}>Communication</option>
                            </select>
                            @error('category')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Niveau <span class="text-red-500">*</span></label>
                            <select name="level" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required>
                                <option value="Débutant" {{ old('level', $formation?->level ?? '') === 'Débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="Intermédiaire" {{ old('level', $formation?->level ?? '') === 'Intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="Avancé" {{ old('level', $formation?->level ?? '') === 'Avancé' ? 'selected' : '' }}>Avancé</option>
                            </select>
                            @error('level')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Date et lieu</h2>
                    <p class="mt-2 text-sm text-slate-500">Indiquez quand et où aura lieu la formation.</p>
                </div>

                <div class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Date de début</label>
                            <input type="date" name="start_date" value="{{ old('start_date', $formation?->start_date?->format('Y-m-d') ?? '') }}" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                            @error('start_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Date de fin</label>
                            <input type="date" name="end_date" value="{{ old('end_date', $formation?->end_date?->format('Y-m-d') ?? '') }}" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                            @error('end_date')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Mode <span class="text-red-500">*</span></label>
                        <div class="flex gap-4">
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="En ligne" {{ old('mode', $formation?->mode ?? '') === 'En ligne' ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500" required />
                                <span class="text-sm text-slate-700">En ligne</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="Présentiel" {{ old('mode', $formation?->mode ?? '') === 'Présentiel' ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500" />
                                <span class="text-sm text-slate-700">Présentiel</span>
                            </label>
                            <label class="flex items-center gap-2">
                                <input type="radio" name="mode" value="Hybride" {{ old('mode', $formation?->mode ?? '') === 'Hybride' ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500" />
                                <span class="text-sm text-slate-700">Hybride</span>
                            </label>
                        </div>
                        @error('mode')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Lieu / Lien plateforme <span class="text-red-500">*</span></label>
                        <input type="text" name="delivery_link" value="{{ old('delivery_link', $formation?->delivery_link ?? $formation?->location ?? '') }}" placeholder="Adresse ou lien Zoom/Teams..." class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required />
                        @error('delivery_link')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Tarification</h2>
                    <p class="mt-2 text-sm text-slate-500">Définissez le prix et les places disponibles.</p>
                </div>

                <div class="space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Prix <span class="text-red-500">*</span></label>
                            <input type="number" name="price" value="{{ old('price', $formation?->price ?? '') }}" placeholder="50000" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required min="0" />
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Devise</label>
                            <select name="currency" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                                <option value="FCFA" {{ old('currency', $formation?->currency ?? '') === 'FCFA' ? 'selected' : '' }}>FCFA</option>
                                <option value="EUR" {{ old('currency', $formation?->currency ?? '') === 'EUR' ? 'selected' : '' }}>EUR</option>
                                <option value="USD" {{ old('currency', $formation?->currency ?? '') === 'USD' ? 'selected' : '' }}>USD</option>
                            </select>
                            @error('currency')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nombre de places <span class="text-red-500">*</span></label>
                        <input type="number" name="max_places" value="{{ old('max_places', $formation?->max_places ?? '') }}" placeholder="20" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required min="1" />
                        @error('max_places')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Image de couverture</h2>
                    <p class="mt-2 text-sm text-slate-500">Ajoutez une image pour illustrer votre formation.</p>
                </div>

                <div>
                    <input type="file" name="cover_image" accept="image/*" class="w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100" />
                    @error('cover_image')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @if($formation && $formation->image)
                        <div class="mt-4">
                            <p class="text-sm text-slate-600 mb-2">Image actuelle :</p>
                            <img src="{{ $formation->image_url }}" alt="Image actuelle" class="h-32 w-full object-cover rounded-lg" />
                        </div>
                    @endif
                </div>
            </section>

            <div class="flex flex-col gap-3 text-right sm:flex-row sm:justify-end sm:gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center justify-center rounded-full border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-900 transition hover:border-slate-400 hover:bg-slate-50">Annuler</a>
                <button type="submit" class="inline-flex h-10 items-center justify-center rounded-full bg-[#FF7A1A] px-5 text-sm font-semibold text-white transition hover:bg-orange-600">
                    {{ $formation ? 'Mettre à jour la formation' : 'Créer la formation' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
