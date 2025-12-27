@extends('layouts.client')

@section('content')
<div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="w-64 bg-[#1a237e] text-white">
        <!-- Logo -->
        <div class="h-16 flex items-center px-4 border-b border-blue-800">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8">
        </div>

        <!-- Navigation -->
        <nav class="py-4">
            <div class="px-4 mb-4">
                <a href="{{ route('client.dashboard') }}" class="flex items-center py-2 text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('client.orders') }}" class="flex items-center py-2 text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                    Commandes
                </a>
                <a href="{{ route('client.products') }}" class="flex items-center py-2 text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Produits
                </a>
                <a href="{{ route('client.categories') }}" class="flex items-center py-2 text-gray-300 hover:text-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    Catégories
                </a>
                <a href="{{ route('client.messages') }}" class="flex items-center py-2 bg-blue-700 text-white rounded-lg px-2">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                    </svg>
                    Messages
                </a>
            </div>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col overflow-hidden">
        <!-- Header -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-6">
            <div class="flex items-center">
                <h1 class="text-2xl font-semibold text-gray-900">Messagerie</h1>
            </div>
            <div class="flex items-center space-x-4">
                <button @click="$dispatch('open-modal', 'new-message')" 
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    Nouveau Message
                </button>
            </div>

            <!-- Modal Nouveau Message -->
            <div x-data="{ open: false }" 
                 @open-modal.window="if ($event.detail === 'new-message') open = true"
                 @close-modal.window="open = false"
                 x-show="open" 
                 class="fixed inset-0 z-50 overflow-y-auto" 
                 style="display: none;">
                <div class="flex items-center justify-center min-h-screen px-4">
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" @click="open = false"></div>

                    <div class="relative bg-white rounded-lg max-w-lg w-full">
                        <div class="px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-medium text-gray-900">Nouveau message</h3>
                        </div>

                        <form action="{{ route('client.conversations.nouvelle') }}" method="POST" class="p-6">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="vendeur_id" class="block text-sm font-medium text-gray-700">Sélectionner un vendeur</label>
                                    <select name="vendeur_id" id="vendeur_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Choisir un vendeur...</option>
                                        @foreach($vendeurs as $vendeur)
                                            <option value="{{ $vendeur->id }}">
                                                {{ $vendeur->nom }} {{ $vendeur->prenom }} - {{ $vendeur->boutique_nom }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
                                    <textarea name="message" id="message" rows="4" required
                                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"></textarea>
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end space-x-3">
                                <button type="button" @click="open = false"
                                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Annuler
                                </button>
                                <button type="submit"
                                        class="px-4 py-2 bg-blue-600 text-white rounded-md text-sm font-medium hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    Envoyer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Messages Container -->
        <div class="flex-1 flex overflow-hidden">
            <!-- Conversations List -->
            <div class="w-1/3 border-r border-gray-200 bg-white overflow-y-auto">
                <div class="p-4 border-b border-gray-200">
                    <div class="relative">
                        <input type="text" placeholder="Rechercher une conversation..." 
                            class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <svg class="absolute left-3 top-2.5 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Conversations -->
                <div class="divide-y divide-gray-200">
                    @foreach($conversations as $conversation)
                        <a href="{{ route('client.messages', ['conversation' => $conversation->id]) }}" 
                           class="block p-4 hover:bg-gray-50 cursor-pointer transition-colors {{ $conversation->unread ? 'bg-blue-50' : '' }} {{ request()->get('conversation') == $conversation->id ? 'bg-blue-100' : '' }}">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0 relative">
                                    <img src="{{ $conversation->vendeur->photo_profil ?? asset('images/default-avatar.png') }}" 
                                         class="h-12 w-12 rounded-full object-cover border-2 {{ $conversation->vendeur->is_online ? 'border-green-400' : 'border-gray-200' }}" 
                                         alt="{{ $conversation->vendeur->nom }}">
                                    @if($conversation->vendeur->is_online)
                                        <div class="absolute bottom-0 right-0 h-3 w-3 rounded-full bg-green-400 border-2 border-white"></div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h2 class="text-sm font-medium text-gray-900">
                                                {{ $conversation->vendeur->nom }} {{ $conversation->vendeur->prenom }}
                                            </h2>
                                            <p class="text-xs text-gray-500">{{ $conversation->vendeur->boutique_nom }}</p>
                                        </div>
                                        <span class="text-xs text-gray-500">
                                            {{ $conversation->lastMessage->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <div class="flex items-center mt-1">
                                        <p class="text-sm text-gray-600 truncate flex-1">
                                            <span class="font-medium {{ $conversation->lastMessage->expediteur_id == auth()->id() ? 'text-blue-600' : '' }}">
                                                {{ $conversation->lastMessage->expediteur_id == auth()->id() ? 'Vous : ' : '' }}
                                            </span>
                                            {{ $conversation->lastMessage->contenu }}
                                        </p>
                                        @if($conversation->unread)
                                            <span class="ml-2 inline-flex items-center justify-center h-5 w-5 rounded-full bg-blue-600 text-white text-xs font-medium">
                                                {{ $conversation->messages->where('lu', false)->where('expediteur_id', '!=', auth()->id())->count() }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Chat Area -->
            <div class="flex-1 flex flex-col bg-gray-50">
                @if(isset($activeConversation))
                    <!-- Chat Header -->
                    <div class="h-16 border-b border-gray-200 bg-white px-6 flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            <img src="{{ $activeConversation->vendeur->photoProfil ?? asset('images/default-avatar.png') }}" 
                                class="h-10 w-10 rounded-full object-cover" 
                                alt="{{ $activeConversation->vendeur->nom }}">
                            <div>
                                <h3 class="text-sm font-medium text-gray-900">{{ $activeConversation->vendeur->nom }}</h3>
                                <p class="text-xs text-gray-500">{{ $activeConversation->vendeur->boutique }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Messages -->
                    <div class="flex-1 overflow-y-auto p-6 space-y-4" data-messages-container>
                        <template data-message-template>
                            <div class="flex message-container">
                                <div class="flex items-end space-x-2">
                                    <img class="message-avatar h-8 w-8 rounded-full object-cover" src="" alt="">
                                    <div class="message-content rounded-lg px-4 py-2 max-w-md shadow-sm">
                                        <p class="text-sm"></p>
                                        <span class="message-time text-xs block mt-1"></span>
                                    </div>
                                </div>
                            </div>
                        </template>

                        @foreach($activeConversation->messages->sortBy('created_at') as $message)
                            <div class="flex {{ $message->isFromCurrentUser() ? 'justify-end' : 'justify-start' }}">
                                <div class="flex items-end {{ $message->isFromCurrentUser() ? 'flex-row-reverse space-x-reverse' : 'flex-row' }} space-x-2">
                                    <div class="flex-shrink-0">
                                        <img src="{{ $message->expediteur->photo_profil ?? asset('images/default-avatar.png') }}" 
                                            class="h-8 w-8 rounded-full object-cover border {{ $message->expediteur->is_online ? 'border-green-400' : 'border-gray-200' }}" 
                                            alt="{{ $message->expediteur->nom }}">
                                    </div>
                                    <div class="relative group">
                                        <div class="{{ $message->isFromCurrentUser() ? 'bg-blue-600 text-white' : 'bg-white' }} rounded-lg px-4 py-2 max-w-md shadow-sm">
                                            @if(!$message->isFromCurrentUser())
                                                <p class="text-xs font-medium text-gray-500 mb-1">
                                                    {{ $message->expediteur->nom }} {{ $message->expediteur->prenom }}
                                                </p>
                                            @endif
                                            <p class="text-sm">{{ $message->contenu }}</p>
                                            <div class="flex items-center justify-between mt-1">
                                                <span class="text-xs {{ $message->isFromCurrentUser() ? 'text-blue-200' : 'text-gray-500' }}">
                                                    {{ $message->formatted_created_at }}
                                                </span>
                                                @if($message->isFromCurrentUser())
                                                    <span class="text-xs text-blue-200 ml-2">
                                                        @if($message->lu)
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @else
                                                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                            </svg>
                                                        @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Message Input -->
                    <div class="border-t border-gray-200 bg-white p-4">
                        <form class="flex items-center space-x-4">
                            <div class="flex-1 relative">
                                <input type="text" 
                                    class="w-full pl-4 pr-12 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Écrivez votre message...">
                                <button type="button" class="absolute right-2 top-2 text-gray-400 hover:text-gray-600">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </button>
                            </div>
                            <button type="submit" class="bg-blue-600 text-white p-3 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 21l21-9L2 3v7l15 2-15 2v7z"/>
                                </svg>
                            </button>
                        </form>
                    </div>
                @else
                    <!-- Empty State -->
                    <div class="flex-1 flex flex-col items-center justify-center text-center p-6">
                        <svg class="h-24 w-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Aucune conversation sélectionnée</h3>
                        <p class="text-gray-500">Sélectionnez une conversation ou commencez-en une nouvelle</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.message-transition {
    transition: all 0.3s ease-out;
}

.message-enter {
    opacity: 0;
    transform: translateY(20px);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 3px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('[data-messages-container]');
    
    // Auto-scroll to bottom
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    scrollToBottom();

    // Real-time updates with Echo
    if (typeof Echo !== 'undefined' && window.conversationId) {
        Echo.private('conversation.' + window.conversationId)
            .listen('NouveauMessage', (e) => {
                // Add new message to the UI
                const messageElement = document.createElement('div');
                messageElement.className = 'flex justify-start message-transition message-enter';
                // ... add message content
                messagesContainer.appendChild(messageElement);
                scrollToBottom();
            });
    }
});
</script>
@endpush
@endsection