<x-dynamic-component 
    :component="$component"
    class="relative inline-flex"
    x-data="{ count: {{ $count }}, sound: new Audio('{{ asset('sounds/notification.mp3') }}') }"
    @message-notification.window="
        count++;
        sound.play();
        $dispatch('notify', { message: $event.detail.message });
    "
>
    <button type="button" 
            @click="$dispatch('open-notifications')"
            class="relative inline-flex items-center p-3 text-gray-600 hover:text-gray-800">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
        </svg>
        
        <span x-show="count > 0"
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-50"
              x-transition:enter-end="opacity-100 scale-100"
              class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"
              x-text="count"></span>
    </button>
</x-dynamic-component>