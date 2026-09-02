@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#FAFAFA] px-4 py-10 sm:px-6 lg:px-8">
    <div class="mx-auto w-full max-w-[620px] space-y-6">
        <div class="rounded-[16px] border border-slate-200 bg-white px-6 py-7 shadow-sm">
            <p class="text-sm font-semibold uppercase tracking-[0.3em] text-orange-600">{{ $formation ? 'Modifier une formation' : 'Nouvelle formation' }}</p>
            <h1 class="mt-4 text-3xl font-semibold tracking-tight text-slate-900">{{ $formation ? 'Modifier la formation' : 'Nouvelle formation' }}</h1>
            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $formation ? 'Mettez à jour les informations et publiez vos changements.' : 'Complétez les informations ci-dessous pour créer une nouvelle formation.' }}</p>
        </div>

        <form x-data="nouvelleFormation(@json($formation ?? null))" x-init="setInitialCover(@json($formation?->image))" @submit="submit($event)" action="{{ $formation ? route('admin.formation.update', $formation->slug) : route('admin.formation.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            @if($formation)
                @method('PUT')
            @endif
            
            <!-- Hidden inputs for fields controlled by buttons -->
            <input type="hidden" x-model="form.mode" name="mode">

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6 flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">Informations générales</h2>
                        <p class="mt-2 text-sm text-slate-500">Donnez un titre, résumez l'essentiel et choisissez les paramètres principaux.</p>
                    </div>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Nom de la formation <span class="text-red-500">*</span></label>
                        <input x-model="form.name" type="text" name="name" placeholder="Ex : Marketing Digital pour Débutants" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required />
                        <p x-text="errors.name" class="mt-2 text-sm text-red-600" x-show="errors.name"></p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Formateur (optionnel)</label>
                        <input x-model="form.trainer_name" type="text" name="trainer_name" placeholder="Laisser vide pour l'utilisateur connecté" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                        <p x-text="errors.trainer_name" class="mt-2 text-sm text-red-600" x-show="errors.trainer_name"></p>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description courte <span class="text-red-500">*</span></label>
                        <textarea x-model="form.short_description" name="short_description" rows="3" placeholder="Résumez votre formation en quelques phrases." class="min-h-[96px] w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required></textarea>
                        <div class="mt-2 flex items-center justify-between text-sm text-slate-500">
                            <p x-text="errors.short_description" class="text-red-600" x-show="errors.short_description"></p>
                            <span x-text="shortDescriptionCount + ' / 180 caractères'">0 / 180 caractères</span>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Description complète <span class="text-red-500">*</span></label>
                        <textarea x-model="form.full_description" name="full_description" rows="5" placeholder="Décrivez votre formation en détail, son objectif, son déroulement et les compétences acquises." class="min-h-[160px] w-full rounded-[8px] border border-slate-300 bg-white px-3 py-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100"></textarea>
                        <p x-text="errors.full_description" class="mt-2 text-sm text-red-600" x-show="errors.full_description"></p>
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Catégorie <span class="text-red-500">*</span></label>
                            <select x-model="form.category" name="category" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                                <option value="">Sélectionnez une catégorie</option>
                                <option>Informatique</option>
                                <option>Marketing</option>
                                <option>Design</option>
                                <option>Comptabilité</option>
                                <option>Langues</option>
                                <option>Développement personnel</option>
                                <option>Cuisine</option>
                                <option>Arts</option>
                            </select>
                            <p x-text="errors.category" class="mt-2 text-sm text-red-600" x-show="errors.category"></p>
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Niveau <span class="text-red-500">*</span></label>
                            <select x-model="form.level" name="level" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                                <option>Débutant</option>
                                <option>Intermédiaire</option>
                                <option>Avancé</option>
                                <option>Tous niveaux</option>
                            </select>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Section Objectifs -->
            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Objectifs pédagogiques</h2>
                    <p class="mt-2 text-sm text-slate-500">Définissez les objectifs que les apprenants atteindront.</p>
                </div>
                <div class="space-y-3 objective-list">
                    <template x-for="(objective, index) in form.objectives" :key="index">
                        <div class="flex gap-2">
                            <textarea x-model="form.objectives[index]" rows="2" class="flex-1 rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" placeholder="Objectif..."></textarea>
                            <button type="button" @click="removeObjective(index)" x-show="form.objectives.length > 1" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addObjective()" class="inline-flex items-center gap-2 text-sm font-medium text-orange-600 hover:text-orange-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter un objectif
                    </button>
                </div>
            </section>

            <!-- Section Modules -->
            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Modules du programme</h2>
                    <p class="mt-2 text-sm text-slate-500">Structurez votre formation en modules avec descriptions.</p>
                </div>
                <div class="space-y-4 module-list">
                    <template x-for="(module, index) in form.modules" :key="index">
                        <div class="border border-slate-200 rounded-lg p-4 space-y-3">
                            <div class="flex gap-2">
                                <input x-model="form.modules[index].title" type="text" class="flex-1 h-10 rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" placeholder="Titre du module..." />
                                <button type="button" @click="removeModule(index)" x-show="form.modules.length > 1" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </div>
                            <textarea x-model="form.modules[index].description" rows="2" class="w-full rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" placeholder="Description du module..."></textarea>
                        </div>
                    </template>
                    <button type="button" @click="addModule()" class="inline-flex items-center gap-2 text-sm font-medium text-orange-600 hover:text-orange-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter un module
                    </button>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Dates et lieu</h2>
                    <p class="mt-2 text-sm text-slate-500">Précisez la période et le format de la formation.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Date de début</label>
                        <input x-model="form.start_date" type="date" name="start_date" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Date de fin</label>
                        <input x-model="form.end_date" type="date" name="end_date" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" />
                    </div>
                </div>

                <div class="mt-6">
                    <p class="mb-3 text-sm font-medium text-slate-700">Mode de formation</p>
                    <div class="flex gap-2 rounded-[8px] border border-slate-200 bg-slate-50 p-2">
                        <button type="button" @click="form.mode = 'En ligne'" :class="form.mode === 'En ligne' ? 'bg-orange-500 text-white' : 'bg-white text-slate-700'" class="inline-flex h-10 items-center rounded-[8px] px-4 text-sm font-semibold transition">En ligne</button>
                        <button type="button" @click="form.mode = 'Présentiel'" :class="form.mode === 'Présentiel' ? 'bg-orange-500 text-white' : 'bg-white text-slate-700'" class="inline-flex h-10 items-center rounded-[8px] px-4 text-sm font-semibold transition">Présentiel</button>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Lieu / Lien plateforme <span class="text-red-500">*</span></label>
                    <input x-model="form.delivery_link" type="text" name="delivery_link" placeholder="Adresse ou lien Zoom/Teams..." class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required />
                    <p x-text="errors.delivery_link" class="mt-2 text-sm text-red-600" x-show="errors.delivery_link"></p>
                </div>
            </section>

            <!-- Section Informations pratiques -->
            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Informations pratiques</h2>
                    <p class="mt-2 text-sm text-slate-500">Détails importants pour les participants.</p>
                </div>
                <div class="space-y-3 practical-info-list">
                    <template x-for="(info, index) in form.practical_info" :key="index">
                        <div class="flex gap-2">
                            <textarea x-model="form.practical_info[index]" rows="2" class="flex-1 rounded-[8px] border border-slate-300 bg-white px-3 py-2 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" placeholder="Information pratique..."></textarea>
                            <button type="button" @click="removePracticalInfo(index)" x-show="form.practical_info.length > 1" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0 1 16.138 21H7.862a2 2 0 0 1-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addPracticalInfo()" class="inline-flex items-center gap-2 text-sm font-medium text-orange-600 hover:text-orange-700 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Ajouter une information
                    </button>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Tarification</h2>
                    <p class="mt-2 text-sm text-slate-500">Définissez le prix et les places disponibles.</p>
                </div>

                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Prix <span class="text-red-500">*</span></label>
                        <input x-model="form.price" type="number" name="price" placeholder="50000" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required min="0" />
                        <p x-text="errors.price" class="mt-2 text-sm text-red-600" x-show="errors.price"></p>
                    </div>
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Devise</label>
                        <select x-model="form.currency" name="currency" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100">
                            <option>FCFA</option>
                            <option>EUR</option>
                            <option>USD</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="mb-2 block text-sm font-medium text-slate-700">Nombre de places <span class="text-red-500">*</span></label>
                    <input x-model="form.max_places" type="number" name="max_places" placeholder="20" class="h-10 w-full rounded-[8px] border border-slate-300 bg-white px-3 text-sm text-slate-900 outline-none transition focus:border-orange-500 focus:ring-2 focus:ring-orange-100" required min="1" />
                    <p x-text="errors.max_places" class="mt-2 text-sm text-red-600" x-show="errors.max_places"></p>
                </div>
            </section>

            <section class="rounded-[16px] border border-slate-200 bg-white p-6 shadow-sm">
                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">Image de couverture</h2>
                    <p class="mt-2 text-sm text-slate-500">Ajoutez une image pour illustrer votre formation.</p>
                </div>

                <div>
                    <div 
                        @dragover.prevent="dragging = true"
                        @dragleave.prevent="dragging = false"
                        @drop="onDrop"
                        :class="dragging ? 'border-orange-500 bg-orange-50' : 'border-slate-300'"
                        class="border-2 border-dashed rounded-2xl p-8 text-center transition"
                    >
                        <input type="file" x-ref="coverInput" @change="onFileChange" name="cover_image" accept="image/*" class="hidden" />
                        
                        <div x-show="!coverPreview">
                            <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 0 1 2.828 0L16 16m-2-2l4.586-4.586a2 2 0 0 1 2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2z"></path>
                            </svg>
                            <p class="mt-4 text-sm text-slate-600">Glissez-déposez une image ici ou</p>
                            <button type="button" @click="$refs.coverInput.click()" class="mt-2 inline-flex items-center justify-center rounded-full bg-orange-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-orange-600">
                                Choisir un fichier
                            </button>
                        </div>
                        
                        <div x-show="coverPreview" class="relative">
                            <img :src="coverPreview" alt="Aperçu" class="max-h-64 mx-auto rounded-lg object-cover" />
                            <button type="button" @click="removeCover()" class="absolute top-2 right-2 p-2 bg-white rounded-full shadow-lg hover:bg-gray-100 transition">
                                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    @if($formation && $formation->image_url)
                        <div class="mt-4">
                            <p class="text-sm text-slate-600 mb-2">Image actuelle :</p>
                            <img src="{{ $formation->image_url }}" alt="Image actuelle" class="h-32 w-full object-cover rounded-lg" />
                        </div>
                    @endif
                </div>
            </section>

            <div class="flex flex-col gap-3 text-right sm:flex-row sm:justify-end sm:gap-4">
                <a href="{{ route('dashboard') }}" class="inline-flex h-10 items-center justify-center rounded-full border border-slate-300 bg-white px-5 text-sm font-semibold text-slate-900 transition hover:border-slate-400 hover:bg-slate-50">Annuler</a>
                <button type="submit" :disabled="isSubmitDisabled" class="inline-flex h-10 items-center justify-center rounded-full bg-[#FF7A1A] px-5 text-sm font-semibold text-white transition hover:bg-orange-600 disabled:opacity-50 disabled:cursor-not-allowed">
                    <span x-show="!submitLoading">{{ $formation ? 'Mettre à jour la formation' : 'Créer la formation' }}</span>
                    <span x-show="submitLoading">Envoi en cours...</span>
                </button>
            </div>
            
            <div x-show="statusMessage" x-text="statusMessage" :class="statusMessage?.includes('erreur') ? 'bg-red-50 text-red-800' : 'bg-green-50 text-green-800'" class="mt-4 rounded-lg p-4 text-sm"></div>
        </form>
    </div>
</div>
@endsection
