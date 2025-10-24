@props(['icon', 'title', 'value', 'trend' => 0, 'trendLabel' => '', 'valueColor' => 'text-slate-900'])

<div class="bg-white rounded-xl shadow-sm p-6 hover:shadow-md transition-shadow duration-200">
    <!-- En-tête avec icône -->
    <div class="flex items-center justify-between mb-4">
        <div class="p-2 {{ $trend > 0 ? 'bg-emerald-500/10' : ($trend < 0 ? 'bg-rose-500/10' : 'bg-slate-500/10') }} rounded-lg">
            {{ $icon }}
        </div>
        @if($trend !== 0)
            <div class="flex items-center {{ $trend > 0 ? 'text-emerald-500' : 'text-rose-500' }} text-sm font-medium">
                <span class="mr-1">{{ abs($trend) }}%</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    @if($trend > 0)
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    @else
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0v-8m0 8l-8-8-4 4-6-6"/>
                    @endif
                </svg>
                <span class="ml-1 text-slate-600">{{ $trendLabel }}</span>
            </div>
        @endif
    </div>

    <!-- Contenu -->
    <h3 class="text-slate-600 font-medium mb-1">{{ $title }}</h3>
    <p class="text-2xl font-bold {{ $valueColor }}">{{ $value }}</p>
</div>