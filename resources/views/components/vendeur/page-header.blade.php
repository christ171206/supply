@props(['title', 'subtitle' => '', 'actions' => null])

<div class="mb-8">
    <!-- En-tête avec gradient et ombre portée -->
    <div class="relative bg-gradient-to-r from-slate-800 to-slate-900 rounded-2xl shadow-xl p-6 mb-6">
        <!-- Effet de brillance en arrière-plan -->
        <div class="absolute inset-0 bg-gradient-to-r from-sky-500/10 to-purple-500/10 rounded-2xl"></div>
        
        <div class="relative">
            <!-- Titre et sous-titre -->
            <div class="mb-4">
                <h1 class="text-2xl font-bold text-white mb-1">{{ $title }}</h1>
                @if($subtitle)
                    <p class="text-slate-400">{{ $subtitle }}</p>
                @endif
            </div>

            <!-- Actions -->
            @if($actions)
                <div class="flex items-center space-x-3">
                    {{ $actions }}
                </div>
            @endif
        </div>
    </div>
</div>