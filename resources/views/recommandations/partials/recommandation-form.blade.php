@if(auth()->check())
    {{-- Vérifier si l'utilisateur a déjà recommandé --}}
    @php
        $userRecommandation = $trainer->recommandations()->where('user_id', auth()->id())->first();
    @endphp

    @if($userRecommandation)
        {{-- Afficher que l'utilisateur a déjà recommandé --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="h-10 w-10 rounded-full bg-green-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Vous avez déjà recommandé ce formateur</h3>
                    <p class="text-sm text-slate-500">Votre recommandation a été publiée le {{ $userRecommandation->created_at->format('d/m/Y') }}</p>
                </div>
            </div>
            
            @if($userRecommandation->comment)
                <div class="bg-slate-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-slate-600">{{ $userRecommandation->comment }}</p>
                </div>
            @endif
            
            <div class="flex gap-3">
                <button type="button" onclick="openEditModal()" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Modifier
                </button>
                <form action="{{ route('recommandations.destroy', $userRecommandation->id) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center justify-center rounded-full border border-red-200 bg-white px-4 py-2 text-sm font-semibold text-red-700 transition hover:bg-red-50">
                        Retirer
                    </button>
                </form>
            </div>
        </div>

        {{-- Modal de modification --}}
        <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <div class="bg-white rounded-2xl shadow-xl max-w-md w-full mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 mb-4">Modifier votre recommandation</h3>
                    <form action="{{ route('recommandations.update', $userRecommandation->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-slate-700 mb-2">Votre commentaire</label>
                            <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience...">{{ $userRecommandation->comment }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="is_public" {{ $userRecommandation->is_public ? 'checked' : '' }} class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                                <span class="text-sm text-slate-700">Rendre cette recommandation publique</span>
                            </label>
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" onclick="closeEditModal()" class="px-4 py-2 rounded-lg border border-slate-200 text-slate-700 text-sm font-medium hover:bg-slate-50 transition">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 rounded-lg bg-orange-600 text-white text-sm font-medium hover:bg-orange-700 transition">
                                Mettre à jour
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openEditModal() {
                document.getElementById('editModal').classList.remove('hidden');
                document.getElementById('editModal').classList.add('flex');
            }

            function closeEditModal() {
                document.getElementById('editModal').classList.add('hidden');
                document.getElementById('editModal').classList.remove('flex');
            }

            document.getElementById('editModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeEditModal();
                }
            });
        </script>
    @else
        {{-- Formulaire de création --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Recommander ce formateur</h3>
            <form action="{{ route('recommandations.store', $trainer->id) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Votre commentaire</label>
                    <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience avec ce formateur..."></textarea>
                </div>

                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="is_public" checked class="rounded border-slate-300 text-orange-600 focus:ring-orange-500">
                        <span class="text-sm text-slate-700">Rendre cette recommandation publique</span>
                    </label>
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                    </svg>
                    Recommander
                </button>
            </form>
        </div>
    @endif
@else
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm text-center">
        <p class="text-slate-600 mb-4">Connectez-vous pour recommander ce formateur</p>
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
            Se connecter
        </a>
    </div>
@endif