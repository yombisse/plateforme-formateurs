<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-900 mb-4">
        @if(auth()->check())
            Recommander ce formateur
        @else
            Recommander ce formateur (sans inscription)
        @endif
    </h3>
    
    @if(auth()->check())
        {{-- Vérifier si l'utilisateur a déjà recommandé --}}
        @php
            $userRecommandation = $trainer->recommandations()->where('user_id', auth()->id())->first();
        @endphp

        @if($userRecommandation)
            <div class="bg-green-50 rounded-lg p-4 mb-4">
                <p class="text-sm text-green-700">Vous avez déjà recommandé ce formateur.</p>
            </div>
        @else
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 0 1 1.789 2A19.79 19.79 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72 12.38 12.38 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L9 10.6a16 16 0 0 0 6.4 6.4l1.96-1.26a2 2 0 0 1 2.11-.45 12.38 12.38 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                    Recommander
                </button>
            </form>
        @endif
    @else
        <form action="{{ route('recommandations.store', $trainer->id) }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Votre nom <span class="text-red-500">*</span></label>
                <input type="text" name="guest_name" placeholder="Votre nom complet" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" required>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-slate-700 mb-2">Votre message <span class="text-red-500">*</span></label>
                <textarea name="comment" rows="4" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="Partagez votre expérience avec ce formateur..." required></textarea>
            </div>

            <button type="submit" class="inline-flex items-center justify-center rounded-full bg-orange-600 px-6 py-2.5 text-sm font-semibold text-white transition hover:bg-orange-700">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 0 1 1.789 2A19.79 19.79 0 0 1 3 5.18 2 2 0 0 1 5 3h3a2 2 0 0 1 2 1.72 12.38 12.38 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L9 10.6a16 16 0 0 0 6.4 6.4l1.96-1.26a2 2 0 0 1 2.11-.45 12.38 12.38 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                </svg>
                Recommander
            </button>
        </form>
    @endif
</div>