@props(['status' => 'info', 'dismissible' => true])

@php
    $colors = [
        'success' => 'bg-emerald-500/10 text-emerald-600 border-emerald-500/20',
        'error' => 'bg-rose-500/10 text-rose-600 border-rose-500/20',
        'warning' => 'bg-amber-500/10 text-amber-600 border-amber-500/20',
        'info' => 'bg-sky-500/10 text-sky-600 border-sky-500/20'
    ];
    $colorClasses = $colors[$status] ?? $colors['info'];
@endphp

<div class="rounded-lg border {{ $colorClasses }} p-4 mb-4" 
     x-data="{ show: true }" 
     x-show="show" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 transform -translate-y-2"
     x-transition:enter-end="opacity-100 transform translate-y-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 transform translate-y-0"
     x-transition:leave-end="opacity-0 transform -translate-y-2">
    <div class="flex">
        <!-- Icône -->
        <div class="flex-shrink-0">
            @if($status === 'success')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($status === 'error')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @elseif($status === 'warning')
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            @else
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            @endif
        </div>

        <!-- Contenu -->
        <div class="ml-3 flex-1">
            <div class="text-sm">
                {{ $slot }}
            </div>
        </div>

        <!-- Bouton fermer -->
        @if($dismissible)
            <div class="ml-auto pl-3">
                <div class="-mx-1.5 -my-1.5">
                    <button @click="show = false" 
                            type="button"
                            class="inline-flex rounded-md p-1.5 focus:outline-none focus:ring-2 focus:ring-offset-2 {{ str_replace('border-', 'focus:ring-', explode(' ', $colorClasses)[2]) }} transition-colors">
                        <span class="sr-only">Fermer</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
            </div>
        @endif
    </div>
</div>