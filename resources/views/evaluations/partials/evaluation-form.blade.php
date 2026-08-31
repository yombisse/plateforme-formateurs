@if(auth()->check())
    {{-- Vérifier si l'utilisateur a déjà évalué --}}
    @php
        $userEvaluation = $formation->evaluations()->where('user_id', auth()->id())->first();
    @endphp

    @if($userEvaluation)
        {{-- Formulaire de modification --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Modifier votre évaluation</h3>
            <form action="{{ route('evaluations.update', $userEvaluation->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Votre note</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                onclick="setRating({{ $i }})"
                                class="rating-star text-3xl transition {{ $i <= $userEvaluation->rating ? 'text-orange-500' : 'text-slate-300' }} hover:text-orange-400">
                                ★
                            </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating" value="{{ $userEvaluation->rating }}" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Votre commentaire</label>
                    <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience...">{{ $userEvaluation->comment }}</textarea>
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                        Mettre à jour
                    </button>
                    <form action="{{ route('evaluations.destroy', $userEvaluation->id) }}" method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center justify-center rounded-full border border-slate-200 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                            Supprimer
                        </button>
                    </form>
                </div>
            </form>
        </div>
    @else
        {{-- Formulaire de création --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
            <h3 class="text-lg font-semibold text-slate-900 mb-4">Évaluer cette formation</h3>
            <form action="{{ route('evaluations.store', $formation->id) }}" method="POST">
                @csrf
                
                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Votre note</label>
                    <div class="flex items-center gap-2">
                        @for($i = 1; $i <= 5; $i++)
                            <button type="button" 
                                onclick="setRating({{ $i }})"
                                class="rating-star text-3xl transition text-slate-300 hover:text-orange-400">
                                ★
                            </button>
                        @endfor
                        <input type="hidden" name="rating" id="rating" value="" required>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-slate-700 mb-2">Votre commentaire</label>
                    <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience..."></textarea>
                </div>

                <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                    Publier mon évaluation
                </button>
            </form>
        </div>
    @endif

    <script>
        function setRating(rating) {
            document.getElementById('rating').value = rating;
            const stars = document.querySelectorAll('.rating-star');
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.remove('text-slate-300');
                    star.classList.add('text-orange-500');
                } else {
                    star.classList.remove('text-orange-500');
                    star.classList.add('text-slate-300');
                }
            });
        }
    </script>
@else
    <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm text-center">
        <p class="text-slate-600 mb-4">Connectez-vous pour évaluer cette formation</p>
        <a href="{{ route('login') }}" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
            Se connecter
        </a>
    </div>
@endif