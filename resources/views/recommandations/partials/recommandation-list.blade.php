<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-semibold text-slate-900">Recommandations</h3>
        <span class="inline-flex items-center gap-1 text-sm text-slate-600">
            <svg class="w-4 h-4 text-orange-500" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            {{ $totalRecommandations }} recommandation{{ $totalRecommandations > 1 ? 's' : '' }}
        </span>
    </div>
    
    @if($recommandations->count() > 0)
        <div class="space-y-4">
            @foreach($recommandations as $recommandation)
                <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                    <div class="flex items-start gap-3">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                            {{ strtoupper(substr($recommandation->author_name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="font-medium text-slate-900">{{ $recommandation->author_name }}</span>
                                <span class="inline-flex items-center gap-1 text-xs text-orange-600">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    Recommande
                                </span>
                            </div>
                            @if($recommandation->comment)
                                <p class="text-sm text-slate-600">{{ $recommandation->comment }}</p>
                            @endif
                            <div class="text-xs text-slate-400 mt-2">
                                {{ $recommandation->created_at->format('d/m/Y') }}
                            </div>
                        </div>
                        
                        @if(auth()->check() && (auth()->id() === $recommandation->user_id || auth()->id() === $recommandation->trainer_id))
                            <form action="{{ route('recommandations.destroy', $recommandation->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-slate-400 hover:text-red-600 transition" title="Supprimer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-8">
            <svg class="w-12 h-12 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.176 0l-2.8 2.034c-.784.57-1.838-.197-1.54-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.729c-.783-.57-.38-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292Z"></path>
            </svg>
            <p class="text-slate-500">Aucune recommandation pour le moment</p>
            <p class="text-sm text-slate-400 mt-1">Soyez le premier à recommander ce formateur !</p>
        </div>
    @endif
</div>