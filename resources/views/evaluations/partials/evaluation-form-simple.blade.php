<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-900 mb-4">
        @if(auth()->check())
            Évaluer cette formation
        @else
            Partagez votre avis (sans inscription)
        @endif
    </h3>
    
    @if(auth()->check())
        {{-- Vérifier si l'utilisateur a déjà évalué --}}
        @php
            $userEvaluation = $formation->evaluations()->where('user_id', auth()->id())->first();
        @endphp

        @if($userEvaluation)
            <div class="bg-green-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-green-700">Vous avez déjà évalué cette formation avec une note de {{ $userEvaluation->rating }}/5.</p>
            </div>
        @else
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
        @endif
    @else
        <form action="{{ route('evaluations.store', $formation->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Votre nom <span class="text-red-500">*</span></label>
                <input type="text" name="guest_name" placeholder="Votre nom complet" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Votre note <span class="text-red-500">*</span></label>
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
                <label class="block text-sm font-medium text-slate-700 mb-2">Votre message <span class="text-red-500">*</span></label>
                <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience..." required></textarea>
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                Publier mon évaluation
            </button>
        </form>
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
</div>