<div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
    <h3 class="text-lg font-semibold text-slate-900 mb-6">Avis des participants</h3>
    
    {{-- Statistiques --}}
    <div class="grid gap-6 lg:grid-cols-2 mb-8">
        <div class="flex items-center gap-4">
            <div class="text-center">
                <div class="text-5xl font-bold text-slate-900">{{ number_format($averageRating ?? 0, 1) }}</div>
                <div class="flex text-orange-500 text-xl mt-1">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($averageRating ?? 0))
                            ★
                        @else
                            <span class="text-slate-300">★</span>
                        @endif
                    @endfor
                </div>
                <div class="text-sm text-slate-500 mt-1">{{ $evaluations->count() }} avis</div>
            </div>
            
            <div class="flex-1 space-y-2">
                @for($i = 5; $i >= 1; $i--)
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-600 w-3">{{ $i }}</span>
                        <span class="text-orange-500">★</span>
                        <div class="flex-1 h-2 bg-slate-200 rounded-full overflow-hidden">
                            <div class="h-full bg-orange-500 rounded-full" style="width: {{ $evaluations->count() > 0 ? ($ratingDistribution[$i] / $evaluations->count() * 100) : 0 }}%"></div>
                        </div>
                        <span class="text-sm text-slate-500 w-8">{{ $ratingDistribution[$i] }}</span>
                    </div>
                @endfor
            </div>
        </div>
        
        <div class="bg-slate-50 rounded-xl p-4">
            <div class="text-sm text-slate-600">
                <div class="font-semibold text-slate-900 mb-2">Répartition des avis</div>
                @if($evaluations->count() > 0)
                    @foreach($ratingDistribution as $stars => $count)
                        @if($count > 0)
                            <div class="flex items-center justify-between py-1">
                                <span>{{ $stars }} étoile{{ $stars > 1 ? 's' : '' }}</span>
                                <span class="font-medium">{{ $count }} ({{ round($count / $evaluations->count() * 100) }}%)</span>
                            </div>
                        @endif
                    @endforeach
                @else
                    <p class="text-slate-500">Aucun avis pour le moment</p>
                @endif
            </div>
        </div>
    </div>
    
    {{-- Liste des évaluations --}}
    @if($evaluations->count() > 0)
        <div class="space-y-4">
            @foreach($evaluations as $evaluation)
                <div class="border-b border-slate-100 pb-4 last:border-0 last:pb-0">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex items-start gap-3">
                            <div class="h-10 w-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($evaluation->author_name ?? 'A', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-medium text-slate-900">{{ $evaluation->author_name }}</span>
                                    <div class="flex text-orange-500 text-sm">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $evaluation->rating)
                                                ★
                                            @else
                                                <span class="text-slate-300">★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                @if($evaluation->comment)
                                    <p class="text-sm text-slate-600">{{ $evaluation->comment }}</p>
                                @endif
                                <div class="text-xs text-slate-400 mt-2">
                                    {{ $evaluation->created_at->format('d/m/Y') }}
                                </div>
                            </div>
                        </div>
                        
                        @if(auth()->check() && (auth()->id() === $evaluation->user_id || auth()->id() === $formation->user_id))
                            <form action="{{ route('evaluations.destroy', $evaluation->id) }}" method="POST" class="flex-shrink-0">
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
            <p class="text-slate-500">Aucun avis pour le moment</p>
            <p class="text-sm text-slate-400 mt-1">Soyez le premier à donner votre avis !</p>
        </div>
    @endif
</div>