@extends('layouts.vendeur')

@section('title', 'Messagerie')

@section('content')
<div class="flex h-[calc(100vh-4rem)] bg-gray-50 overflow-hidden">
    <div class="flex-1 flex">
        <!-- Sidebar avec les conversations -->
        <div class="w-96 bg-white border-r border-gray-200 flex flex-col">
            <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 bg-white sticky top-0 z-10">
                <h2 class="text-xl font-bold text-gray-800">Messagerie</h2>
                <button class="p-2 text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-full transition-colors duration-200" 
                        data-bs-toggle="modal" data-bs-target="#newMessageModal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <div class="relative group">
                    <input type="text" 
                           placeholder="Rechercher une conversation..." 
                           class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-300 rounded-xl text-sm focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200">
                    <svg class="absolute left-3 top-3 h-5 w-5 text-gray-400 group-focus-within:text-blue-500 transition-colors duration-200" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

    <div class="row">
        <!-- Liste des conversations -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Conversations</h5>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#newMessageModal">
                        <i class="fas fa-plus me-2"></i>Nouveau message
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="overflow-y-auto flex-1">
                @forelse($conversations as $userId => $messages)
                    @php
                        $lastMessage = $messages->first();
                        $otherUser = $lastMessage->expediteur_id === Auth::id() 
                            ? $lastMessage->destinataire 
                            : $lastMessage->expediteur;
                        $unreadCount = $messages->where('destinataire_id', Auth::id())
                            ->where('lu', false)
                            ->count();
                    @endphp
                    <a href="{{ route('vendeur.messagerie.conversation', $otherUser->id) }}" 
                        class="flex items-center px-6 py-4 hover:bg-gray-50 transition-all duration-200 border-l-4 {{ request()->route('userId') == $otherUser->id ? 'border-blue-500 bg-blue-50/80' : 'border-transparent' }}">
                        <div class="relative flex-shrink-0">
                            <div class="relative">
                                <img src="{{ $otherUser->photoProfil ?? asset('images/default-avatar.png') }}" 
                                    class="w-14 h-14 rounded-full object-cover ring-2 {{ request()->route('userId') == $otherUser->id ? 'ring-blue-500' : 'ring-gray-100' }}" 
                                    alt="{{ $otherUser->nom }}">
                                <span class="absolute bottom-0.5 right-0.5 w-3.5 h-3.5 {{ $otherUser->derniereActivite && now()->diffInMinutes($otherUser->derniereActivite) < 5 ? 'bg-green-500' : 'bg-gray-300' }} rounded-full ring-2 ring-white"></span>
                            </div>
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 bg-blue-500 text-white text-xs font-medium rounded-full min-w-[1.25rem] h-5 flex items-center justify-center px-1.5 ring-2 ring-white">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <div class="flex items-center justify-between mb-1">
                                <h3 class="text-base font-semibold text-gray-900 truncate pr-2">{{ $otherUser->nom }}</h3>
                                <span class="text-xs text-gray-500 whitespace-nowrap">{{ $lastMessage->created_at->calendar() }}</span>
                            </div>
                            <div class="flex items-start space-x-2">
                                @if($lastMessage->expediteur_id === Auth::id())
                                    <span class="flex-shrink-0 text-xs text-gray-400">Vous:</span>
                                @endif
                                <p class="text-sm {{ $unreadCount > 0 ? 'font-medium text-gray-900' : 'text-gray-500' }} truncate">
                                    {{ $lastMessage->contenu }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <div class="flex flex-col items-center justify-center h-full text-gray-500">
                        <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                            </path>
                        </svg>
                        <p class="text-sm">Aucune conversation</p>
                    </div>
                @endforelse
            </div>
                </div>
            </div>

            <!-- Notifications -->
            <div class="card mt-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Notifications</h5>
                    @if($notifications->isNotEmpty())
                        <button class="btn btn-link btn-sm p-0" onclick="markAllNotificationsAsRead()">
                            Tout marquer comme lu
                        </button>
                    @endif
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                        @forelse($notifications as $notification)
                            <div class="list-group-item">
                                <div class="d-flex w-100 justify-content-between">
                                    <h6 class="mb-1">{{ $notification->titre }}</h6>
                                    <small>{{ $notification->created_at->diffForHumans() }}</small>
                                </div>
                                <p class="mb-1">{{ $notification->contenu }}</p>
                                @if(!$notification->lu)
                                    <button class="btn btn-link btn-sm p-0" 
                                            onclick="markNotificationAsRead({{ $notification->id }})">
                                        Marquer comme lu
                                    </button>
                                @endif
                            </div>
                        @empty
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-bell fa-2x mb-2"></i>
                                <p class="mb-0">Aucune notification</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Zone de conversation -->
        <div class="flex-1 flex flex-col bg-white">
            @if(isset($activeConversation))
                <!-- En-tête de la conversation -->
                <div class="h-16 flex items-center justify-between px-6 border-b border-gray-200 bg-white sticky top-0 z-10">
                    <div class="flex items-center">
                        <div class="relative">
                            <img src="{{ $activeConversation->first()->expediteur_id === Auth::id() 
                                ? $activeConversation->first()->destinataire->photoProfil 
                                : $activeConversation->first()->expediteur->photoProfil 
                                ?? asset('images/default-avatar.png') }}" 
                                class="w-11 h-11 rounded-full object-cover ring-2 ring-gray-100" alt="">
                            @php
                                $otherUser = $activeConversation->first()->expediteur_id === Auth::id() 
                                    ? $activeConversation->first()->destinataire 
                                    : $activeConversation->first()->expediteur;
                                $isOnline = $otherUser->derniereActivite && now()->diffInMinutes($otherUser->derniereActivite) < 5;
                            @endphp
                            <span class="absolute bottom-0.5 right-0.5 w-3 h-3 {{ $isOnline ? 'bg-green-500' : 'bg-gray-300' }} rounded-full ring-2 ring-white"></span>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-base font-semibold text-gray-900">
                                {{ $otherUser->nom }}
                            </h3>
                            <span class="text-sm text-gray-500">
                                {{ $isOnline ? 'En ligne' : ($otherUser->derniereActivite ? 'Vu ' . $otherUser->derniereActivite->diffForHumans() : 'Hors ligne') }}
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-full transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Messages -->
                <div class="flex-1 overflow-y-auto px-6 py-8 space-y-6" id="messages-container">
                    @foreach($activeConversation as $message)
                        <div class="flex {{ $message->expediteur_id === Auth::id() ? 'justify-end' : 'justify-start' }} group">
                            <div class="flex items-end {{ $message->expediteur_id === Auth::id() ? 'flex-row-reverse' : 'flex-row' }} max-w-[85%]">
                                <div class="flex-shrink-0 {{ $message->expediteur_id === Auth::id() ? 'ml-3' : 'mr-3' }}">
                                    <img src="{{ $message->expediteur->photoProfil ?? asset('images/default-avatar.png') }}" 
                                        class="w-8 h-8 rounded-full object-cover opacity-0 group-hover:opacity-100 transition-opacity duration-200" 
                                        alt="">
                                </div>
                                <div class="flex flex-col {{ $message->expediteur_id === Auth::id() ? 'items-end' : 'items-start' }}">
                                    <div class="{{ $message->expediteur_id === Auth::id() 
                                        ? 'bg-blue-500 text-white' 
                                        : 'bg-gray-100 text-gray-900' }} 
                                        rounded-2xl px-4 py-2 shadow-sm hover:shadow-md transition-shadow duration-200">
                                        <p class="text-sm whitespace-pre-wrap">{{ $message->contenu }}</p>
                                    </div>
                                    <div class="flex items-center mt-1 space-x-2">
                                        <span class="text-xs text-gray-400">
                                            {{ $message->created_at->format('H:i') }}
                                        </span>
                                        @if($message->expediteur_id === Auth::id())
                                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41L9 16.17z"/>
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <div id="typing-indicator" class="hidden">
                        <div class="flex items-center space-x-2 text-gray-500 text-sm">
                            <div class="typing-indicator">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Zone de saisie -->
                <div class="border-t border-gray-200 p-4 bg-white">
                    <form action="{{ route('vendeur.messagerie.send') }}" method="POST" class="flex items-center space-x-4" id="message-form">
                        @csrf
                        <input type="hidden" name="destinataire_id" value="{{ $activeConversation->first()->expediteur_id === Auth::id() 
                            ? $activeConversation->first()->destinataire->id 
                            : $activeConversation->first()->expediteur->id }}">
                        <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2z"/>
                            </svg>
                        </button>
                        <div class="flex-1 relative">
                            <input type="text" name="contenu" 
                                class="w-full pr-24 pl-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition-all duration-200"
                                placeholder="Écrivez votre message..."
                                id="message-input"
                                data-message-input>
                            <div class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center space-x-1">
                                <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </button>
                                <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" class="p-3 rounded-xl bg-blue-500 text-white hover:bg-blue-600 shadow-lg hover:shadow-xl active:scale-95 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2 21l21-9L2 3v7l15 2-15 2v7z"></path>
                            </svg>
                        </button>
                    </form>
                </div>
            @else
                <div class="flex-1 flex flex-col items-center justify-center">
                    <svg class="w-24 h-24 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                        </path>
                    </svg>
                    <h2 class="text-xl font-semibold text-gray-900 mb-2">Sélectionnez une conversation</h2>
                    <p class="text-gray-500">Ou commencez une nouvelle conversation en cliquant sur le bouton +</p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal Nouveau Message -->
<div class="modal fade" id="newMessageModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-lg shadow-lg border-0">
            <div class="modal-header border-b bg-gray-50 p-4">
                <h5 class="modal-title text-lg font-semibold text-gray-900">Nouveau message</h5>
                <button type="button" class="text-gray-400 hover:text-gray-500" data-bs-dismiss="modal">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <form action="{{ route('vendeur.messagerie.send') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Destinataire</label>
                        <select class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                name="destinataire_id" required>
                            <option value="">Sélectionner un destinataire</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Message</label>
                        <textarea class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                                name="contenu" rows="4" required
                                placeholder="Écrivez votre message ici..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-t bg-gray-50 p-4 flex justify-end space-x-2">
                    <button type="button" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50" 
                            data-bs-dismiss="modal">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-lg hover:bg-blue-600">
                        Envoyer
                    </button>
                </div>
            </form>
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

.message-enter-active {
    opacity: 1;
    transform: translateY(0);
}

.typing-indicator {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    background: #f3f4f6;
    border-radius: 1rem;
}

.typing-indicator span {
    height: 0.5rem;
    width: 0.5rem;
    background: #9ca3af;
    border-radius: 50%;
    margin: 0 0.1rem;
    display: inline-block;
    animation: bounce 1.4s infinite ease-in-out;
}

.typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
.typing-indicator span:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce {
    0%, 80%, 100% { transform: scale(0); }
    40% { transform: scale(1); }
}

/* Scrollbar personnalisé */
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
    const messageForm = document.querySelector('form[data-message-form]');
    const messageInput = document.querySelector('[data-message-input]');
    
    // Initialisation de Select2 avec un thème moderne
    $('select[name="destinataire_id"]').select2({
        theme: 'default',
        placeholder: 'Rechercher un utilisateur...',
        minimumInputLength: 2,
        ajax: {
            url: '{{ route("vendeur.messagerie.search-users") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.map(function(user) {
                        return {
                            id: user.id,
                            text: user.nom,
                            email: user.email,
                            avatar: user.photoProfil || '/images/default-avatar.png'
                        };
                    })
                };
            },
            cache: true
        },
        templateResult: formatUserResult,
        templateSelection: formatUserSelection
    });

    // Format personnalisé pour les résultats de recherche
    function formatUserResult(user) {
        if (!user.id) return user.text;
        return $(`
            <div class="flex items-center">
                <img src="${user.avatar}" class="w-8 h-8 rounded-full object-cover mr-3" />
                <div>
                    <div class="font-medium">${user.text}</div>
                    <div class="text-sm text-gray-500">${user.email}</div>
                </div>
            </div>
        `);
    }

    // Format personnalisé pour l'option sélectionnée
    function formatUserSelection(user) {
        if (!user.id) return user.text;
        return $(`
            <div class="flex items-center">
                <img src="${user.avatar}" class="w-6 h-6 rounded-full object-cover mr-2" />
                <span>${user.text}</span>
            </div>
        `);
    }

    // Auto-scroll avec animation fluide
    function scrollToBottom() {
        if (messagesContainer) {
            const scrollHeight = messagesContainer.scrollHeight;
            const currentScroll = messagesContainer.scrollTop + messagesContainer.clientHeight;
            const threshold = 100; // pixels from bottom

            if (scrollHeight - currentScroll <= threshold) {
                messagesContainer.scrollTo({
                    top: scrollHeight,
                    behavior: 'smooth'
                });
            }
        }
    }

    // Gestion de l'envoi des messages
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            const message = messageInput.value.trim();
            
            if (message) {
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            contenu: message,
                            destinataire_id: this.querySelector('[name="destinataire_id"]').value
                        })
                    });

                    const data = await response.json();
                    if (data.success) {
                        // Ajouter le message avec animation
                        const messageElement = document.createElement('div');
                        messageElement.className = 'flex justify-end message-transition message-enter';
                        messageElement.innerHTML = `
                            <div class="flex items-end flex-row-reverse">
                                <img src="{{ Auth::user()->photoProfil ?? asset('images/default-avatar.png') }}" 
                                    class="w-8 h-8 rounded-full object-cover ml-2" alt="">
                                <div class="bg-blue-500 text-white rounded-2xl px-4 py-2 max-w-[80%] break-words">
                                    <p class="text-sm">${message}</p>
                                    <span class="text-xs text-blue-100 block mt-1">
                                        ${new Date().toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                    </span>
                                </div>
                            </div>
                        `;
                        
                        messagesContainer.appendChild(messageElement);
                        requestAnimationFrame(() => {
                            messageElement.classList.remove('message-enter');
                        });
                        
                        scrollToBottom();
                        messageInput.value = '';
                        messageInput.focus();
                    }
                } catch (error) {
                    console.error('Erreur lors de l\'envoi du message:', error);
                }
            }
        });
    }

    // Initialisation des tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Notification de frappe
    let typingTimer;
    if (messageInput) {
        messageInput.addEventListener('input', function() {
            clearTimeout(typingTimer);
            // Émettre l'événement "typing" via Echo...
            typingTimer = setTimeout(() => {
                // Émettre l'événement "stopped-typing" via Echo...
            }, 1000);
        });
    }

    // Écouter les nouveaux messages en temps réel
    if (typeof Echo !== 'undefined' && window.conversationId) {
        Echo.private('conversation.' + window.conversationId)
            .listen('NouveauMessage', (e) => {
                if (e.message.expediteur_id !== {{ Auth::id() }}) {
                    const messageElement = document.createElement('div');
                    messageElement.className = 'flex justify-start message-transition message-enter';
                    messageElement.innerHTML = `
                        <div class="flex items-end">
                            <img src="${e.message.expediteur.photoProfil || '/images/default-avatar.png'}" 
                                class="w-8 h-8 rounded-full object-cover mr-2" alt="">
                            <div class="bg-gray-100 text-gray-900 rounded-2xl px-4 py-2 max-w-[80%] break-words">
                                <p class="text-sm">${e.message.contenu}</p>
                                <span class="text-xs text-gray-500 block mt-1">
                                    ${new Date(e.message.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                                </span>
                            </div>
                        </div>
                    `;
                    
                    messagesContainer.appendChild(messageElement);
                    requestAnimationFrame(() => {
                        messageElement.classList.remove('message-enter');
                    });
                    
                    scrollToBottom();
                    
                    // Notification sonore
                    if (!document.hasFocus()) {
                        const audio = new Audio('/sounds/message.mp3');
                        audio.play();
                    }
                }
            })
            .listenForWhisper('typing', (e) => {
                // Afficher l'indicateur de frappe
                showTypingIndicator(e.name);
            })
            .listenForWhisper('stopped-typing', (e) => {
                // Masquer l'indicateur de frappe
                hideTypingIndicator();
            });
    }

    // Fonctions pour gérer l'indicateur de frappe
    function showTypingIndicator(userName) {
        const typingIndicator = document.querySelector('[data-typing-indicator]');
        if (typingIndicator) {
            typingIndicator.textContent = `${userName} est en train d'écrire...`;
            typingIndicator.classList.remove('hidden');
        }
    }

    function hideTypingIndicator() {
        const typingIndicator = document.querySelector('[data-typing-indicator]');
        if (typingIndicator) {
            typingIndicator.classList.add('hidden');
        }
    }

    // Vérification périodique du statut en ligne
    setInterval(function() {
        fetch('{{ route("vendeur.messagerie.check-online-status") }}')
            .then(response => response.json())
            .then(data => {
                data.users.forEach(user => {
                    const statusIndicator = document.querySelector(`[data-user-status="${user.id}"]`);
                    if (statusIndicator) {
                        statusIndicator.classList.toggle('bg-green-500', user.online);
                        statusIndicator.classList.toggle('bg-gray-300', !user.online);
                    }
                });
            });
    }, 60000); // Vérifier toutes les minutes
});
</script>
@endpush
@endsection