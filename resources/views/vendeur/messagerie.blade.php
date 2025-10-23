@extends('layouts.vendeur')

@section('title', 'Messagerie')

@section('content')
    <div class="-m-6"><!-- Annule le padding du layout -->
        <div x-data="messagerie()" class="h-[calc(100vh-64px)] bg-gray-100">
            <!-- Container principal avec ombre et coins arrondis -->
            <div class="h-full bg-white shadow-lg overflow-hidden">
            <!-- En-tête de la messagerie -->
            <div class="bg-gradient-to-br from-blue-600 via-blue-500 to-indigo-600 text-white p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold tracking-tight">Messages</h1>
                        <p class="text-blue-100 mt-1">Conversations avec vos clients</p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 hover:bg-white/10 rounded-full transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </button>
                        <button class="p-2 hover:bg-white/10 rounded-full transition duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
                <div class="flex h-[calc(100vh-12rem)] bg-white relative">
                    <!-- Liste des conversations -->
                    <div class="w-[380px] border-r border-gray-100 flex flex-col bg-gray-50/50">
                        <div class="p-4">
                            <div class="relative">
                                <input type="text" x-model="searchQuery" placeholder="Rechercher une conversation..."
                                       class="w-full pl-12 pr-4 py-3 bg-gray-100 border-0 rounded-xl placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all duration-200">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Liste filtrée des conversations -->
                        <div class="flex-1 overflow-y-auto mt-4">
                            <div class="px-2">
                                <template x-for="conversation in filteredConversations" :key="conversation.id">
                                    <div @click="selectConversation(conversation)"
                                         :class="{'bg-blue-50/80 hover:bg-blue-50/80': selectedConversation?.id === conversation.id}"
                                         class="p-3 rounded-xl mb-1 hover:bg-gray-100/80 cursor-pointer transition-all duration-200">
                                        <div class="flex items-start space-x-3">
                                            <div class="relative flex-shrink-0">
                                                <img :src="conversation.client.photo_profil || '/img/default-avatar.png'"
                                                     class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-lg">
                                                <div :class="conversation.client.is_online ? 'bg-green-500' : 'bg-gray-400'"
                                                     class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white shadow-sm">
                                                </div>
                                            </div>
                                        <div class="flex-1 min-w-0">
                                                <div class="flex items-center justify-between mb-1">
                                                    <h3 class="font-semibold text-gray-900 truncate"
                                                        x-text="conversation.client.nom + ' ' + conversation.client.prenom"></h3>
                                                    <span class="text-xs text-gray-400 flex items-center"
                                                          x-text="formatDate(conversation.updated_at)">
                                                    </span>
                                                </div>
                                                <div class="flex items-center justify-between">
                                                    <p class="text-sm text-gray-500 truncate pr-2"
                                                       :class="{'font-semibold text-gray-900': conversation.messages_non_lus_count > 0}"
                                                       x-text="conversation.dernier_message?.contenu || 'Aucun message'"></p>
                                                    <template x-if="conversation.messages_non_lus_count > 0">
                                                        <span class="flex-shrink-0 inline-flex items-center justify-center px-2 py-1 text-xs font-medium bg-blue-500 text-white rounded-full"
                                                              x-text="conversation.messages_non_lus_count"></span>
                                                    </template>
                                                </div>
                                            </div>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <!-- Zone de conversation -->
                    <div class="flex-1 flex flex-col bg-gray-50" :class="showClientInfo ? 'mr-1/4' : ''">
                        <template x-if="selectedConversation">
                            <!-- En-tête de la conversation -->
                            <div class="px-6 py-3 bg-white border-b flex items-center justify-between shadow-sm backdrop-blur-lg bg-white/80">
                                <div class="flex items-center space-x-4">
                                    <div class="relative">
                                        <img :src="selectedConversation.client.photo_profil || '/img/default-avatar.png'"
                                             class="w-12 h-12 rounded-full object-cover ring-2 ring-white shadow-lg">
                                        <div :class="selectedConversation.client.is_online ? 'bg-green-500' : 'bg-gray-400'"
                                             class="absolute bottom-0 right-0 w-3 h-3 rounded-full border-2 border-white shadow-sm">
                                        </div>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-gray-900" x-text="selectedConversation.client.nom + ' ' + selectedConversation.client.prenom"></h3>
                                        <div class="flex items-center mt-0.5 text-sm">
                                            <span :class="selectedConversation.client.is_online ? 'text-green-500' : 'text-gray-500'"
                                                  x-text="selectedConversation.client.is_online ? 'En ligne' : 'Hors ligne'"></span>
                                            <span class="mx-2 text-gray-300">•</span>
                                            <span class="text-gray-500 flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                Compte vérifié
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <button class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                        </svg>
                                    </button>
                                    <button @click="toggleClientInfo"
                                            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-xl transition-all duration-200">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                    </button>
                                    <div class="relative" x-data="{ open: false }">
                                        <button @click="open = !open"
                                                class="p-2 text-gray-500 hover:text-blue-600 hover:bg-blue-50 rounded-full transition duration-200">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/>
                                            </svg>
                                        </button>
                                        <div x-show="open" @click.away="open = false"
                                             class="absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl py-2 z-10">
                                            <button @click="resolveConversation" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                Marquer comme résolu
                                            </button>
                                            <button @click="blockUser" class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                                </svg>
                                                Bloquer l'utilisateur
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Messages -->
                            <div class="flex-1 overflow-y-auto px-4 py-6 space-y-4 bg-[#f0f2f5]" x-ref="messagesContainer">
                                <template x-for="message in selectedConversation.messages" :key="message.id">
                                    <div :class="message.expediteur_id === userId ? 'ml-auto flex flex-col items-end' : 'mr-auto flex flex-col items-start'"
                                         class="max-w-[70%] group">
                                        <div class="flex items-end gap-2">
                                            <template x-if="message.expediteur_id !== userId">
                                                <img :src="selectedConversation.client.photo_profil || '/img/default-avatar.png'"
                                                     class="w-6 h-6 rounded-full object-cover mb-1">
                                            </template>
                                            <div :class="message.expediteur_id === userId ? 'bg-blue-500 text-white' : 'bg-white text-gray-700'"
                                                 class="rounded-2xl shadow-sm px-4 py-2 relative message-bubble hover:shadow-md transition-shadow duration-200"
                                             class="rounded-lg p-3 mb-1">
                                            <template x-if="message.produit">
                                                <div class="mb-2 bg-white rounded-lg shadow-sm p-3 flex items-center space-x-3 hover:bg-gray-50 transition duration-200">
                                                    <img :src="message.produit.image" class="w-16 h-16 object-cover rounded-lg shadow-sm">
                                                    <div class="flex-1">
                                                        <p class="font-medium text-gray-900" x-text="message.produit.nom"></p>
                                                        <p class="text-sm text-gray-600 mt-1" x-text="formatPrice(message.produit.prix)"></p>
                                                    </div>
                                                    <button class="text-blue-500 hover:text-blue-600 p-2">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                        </svg>
                                                    </button>
                                                </div>
                                            </template>
                                            <p x-text="message.contenu"></p>
                                            <template x-if="message.piece_jointe">
                                                <div class="mt-2">
                                                    <a :href="'/storage/' + message.piece_jointe" target="_blank"
                                                       class="flex items-center space-x-2 text-sm hover:underline">
                                                        <i class="fas fa-paperclip"></i>
                                                        <span>Pièce jointe</span>
                                                    </a>
                                                </div>
                                            </template>
                                        </div>
                                        <div class="flex items-center space-x-2 text-xs text-gray-500">
                                            <span x-text="formatTime(message.created_at)"></span>
                                            <template x-if="message.expediteur_id === userId">
                                                <span>
                                                    <i class="fas" :class="message.lu ? 'fa-check-double text-blue-500' : 'fa-check'"></i>
                                                </span>
                                            </template>
                                        </div>
                                    </div>
                                </template>
                            </div>

                            <!-- Zone de saisie -->
                            <div class="p-4 bg-white border-t flex items-end gap-2">
                                <button type="button" class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </button>
                                <button type="button" @click="$refs.fileInput.click()"
                                        class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-full transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </button>
                                <div class="flex-1 flex items-center bg-[#f0f2f5] rounded-2xl px-4">
                                    <textarea x-model="newMessage" rows="1"
                                             @keydown.enter.prevent="sendMessage"
                                             placeholder="Écrivez votre message..."
                                             class="w-full py-3 bg-transparent border-0 focus:outline-none focus:ring-0 resize-none text-gray-700 placeholder-gray-400"></textarea>
                                </div>
                                <button type="button" @click="sendMessage"
                                        :class="newMessage.trim() ? 'text-blue-500 hover:text-blue-600' : 'text-gray-400'"
                                        class="p-2 hover:bg-gray-100 rounded-full transition-all duration-200">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                </button>
                                <input type="file" x-ref="fileInput" @change="uploadFile" class="hidden"
                                       accept="image/*,application/pdf,.doc,.docx">
                            </div>
                        </template>

                        <template x-if="!selectedConversation">
                            <div class="flex-1 flex items-center justify-center">
                                <div class="text-center text-gray-500">
                                    <i class="fas fa-comments text-4xl mb-2"></i>
                                    <p>Sélectionnez une conversation pour commencer</p>
                                </div>
                            </div>
                        </template>
                    </div>

                    <!-- Panneau d'informations client -->
                    <div x-show="showClientInfo" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-full" x-transition:enter-end="opacity-100 transform translate-x-0" x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100 transform translate-x-0" x-transition:leave-end="opacity-0 transform translate-x-full" class="w-1/4 border-l border-gray-200 bg-white absolute right-0 top-0 h-full z-10">
                        <template x-if="selectedConversation">
                            <div class="p-4">
                                <h3 class="font-semibold mb-4">Informations client</h3>
                                <div class="space-y-4">
                                    <div>
                                        <p class="text-sm text-gray-500">Email</p>
                                        <p x-text="selectedConversation.client.email"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Téléphone</p>
                                        <p x-text="selectedConversation.client.telephone"></p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500">Dernière activité</p>
                                        <p x-text="formatDate(selectedConversation.client.derniere_activite)"></p>
                                    </div>

                                    <!-- Dernières commandes -->
                                    <div class="border-t pt-4">
                                        <h4 class="font-medium mb-2">Dernières commandes</h4>
                                        <template x-for="commande in selectedConversation.commandes" :key="commande.id">
                                            <div class="border rounded p-2 mb-2">
                                                <div class="flex justify-between items-center">
                                                    <span class="font-medium" x-text="'#' + commande.reference"></span>
                                                    <span :class="{
                                                        'text-green-500': commande.statut === 'completed',
                                                        'text-yellow-500': commande.statut === 'pending',
                                                        'text-red-500': commande.statut === 'cancelled'
                                                    }" x-text="commande.statut"></span>
                                                </div>
                                                <p class="text-sm text-gray-500" x-text="formatDate(commande.created_at)"></p>
                                                <p class="font-medium" x-text="formatPrice(commande.total)"></p>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
.message-bubble::before {
    content: '';
    position: absolute;
    bottom: 0;
    width: 12px;
    height: 12px;
}

.message-bubble[class*="bg-blue-500"]::before {
    right: -6px;
    clip-path: polygon(0 0, 0% 100%, 100% 100%);
    background: #3b82f6;
}

.message-bubble[class*="bg-white"]::before {
    left: -6px;
    clip-path: polygon(100% 0, 0 100%, 100% 100%);
    background: white;
}

/* Styliser la scrollbar pour Chrome, Safari et Opera */
::-webkit-scrollbar {
    width: 6px;
    height: 6px;
}

::-webkit-scrollbar-track {
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endpush

@section('scripts')
<script>
function messagerie() {
    return {
        conversations: @json($conversations),
        selectedConversation: @json($conversation_active),
        showClientInfo: false,
        searchQuery: '',
        newMessage: '',
        userId: {{ Auth::id() }},
        pusherChannel: null,

        init() {
            this.initPusher();
            this.scrollToBottom();
            this.watchConversation();
        },

        get filteredConversations() {
            return this.conversations.filter(conv => {
                const searchTerm = this.searchQuery.toLowerCase();
                const clientName = `${conv.client.nom} ${conv.client.prenom}`.toLowerCase();
                return clientName.includes(searchTerm);
            });
        },

        initPusher() {
            this.pusherChannel = window.Echo.private('vendeur.' + this.userId);

            this.pusherChannel.listen('MessageNotification', (e) => {
                if (this.selectedConversation?.id === e.message.conversation_id) {
                    this.selectedConversation.messages.push(e.message);
                    this.scrollToBottom();
                    this.markAsRead(e.message.id);
                }

                const conversation = this.conversations.find(c => c.id === e.message.conversation_id);
                if (conversation) {
                    if (!this.selectedConversation || this.selectedConversation.id !== conversation.id) {
                        conversation.messages_non_lus_count++;
                    }
                    conversation.dernier_message = e.message;
                    this.conversations.sort((a, b) => new Date(b.updated_at) - new Date(a.updated_at));
                }
            });

            this.pusherChannel.listen('MessageStatutNotification', (e) => {
                if (this.selectedConversation?.id === e.conversation_id) {
                    this.selectedConversation.messages.forEach(message => {
                        if (message.expediteur_id === this.userId && !message.lu) {
                            message.lu = true;
                            message.lu_at = new Date();
                        }
                    });
                }
            });

            this.pusherChannel.listen('ClientActivityNotification', (e) => {
                const conversation = this.conversations.find(c => c.client.id === e.client_id);
                if (conversation) {
                    conversation.client.is_online = e.is_online;
                    conversation.client.derniere_activite = e.derniere_activite;
                    if (this.selectedConversation?.id === conversation.id) {
                        this.selectedConversation.client.is_online = e.is_online;
                        this.selectedConversation.client.derniere_activite = e.derniere_activite;
                    }
                }
            });
        },

        async selectConversation(conversation) {
            const response = await fetch(`/vendeur/messagerie?conversation=${conversation.id}`);
            const data = await response.json();
            this.selectedConversation = data.conversation;
            this.scrollToBottom();

            const convIndex = this.conversations.findIndex(c => c.id === conversation.id);
            if (convIndex > -1) {
                this.conversations[convIndex].messages_non_lus_count = 0;
            }
        },

        watchConversation() {
            this.$watch('selectedConversation.messages', () => {
                this.$nextTick(() => this.scrollToBottom());
            });
        },

        scrollToBottom() {
            this.$nextTick(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            });
        },

        async sendMessage() {
            if (!this.newMessage.trim()) return;

            try {
                const response = await fetch('/vendeur/messagerie/envoyer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        conversation_id: this.selectedConversation.id,
                        message: this.newMessage
                    })
                });

                const data = await response.json();
                if (data.success) {
                    this.selectedConversation.messages.push(data.message);
                    this.newMessage = '';
                    this.scrollToBottom();
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
            }
        },

        async uploadFile(event) {
            const file = event.target.files[0];
            if (!file) return;

            const formData = new FormData();
            formData.append('file', file);
            formData.append('conversation_id', this.selectedConversation.id);

            try {
                const response = await fetch('/vendeur/messagerie/upload', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                });

                const data = await response.json();
                if (data.success) {
                    this.selectedConversation.messages.push(data.message);
                    this.scrollToBottom();
                }
            } catch (error) {
                console.error('Erreur lors du téléchargement du fichier:', error);
            }

            event.target.value = '';
        },

        async markAsRead(messageId) {
            try {
                await fetch('/vendeur/messagerie/lu', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ message_id: messageId })
                });
            } catch (error) {
                console.error('Erreur lors du marquage comme lu:', error);
            }
        },

        async resolveConversation() {
            if (!confirm('Êtes-vous sûr de vouloir marquer cette conversation comme résolue ?')) return;

            try {
                const response = await fetch('/vendeur/messagerie/resoudre', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ conversation_id: this.selectedConversation.id })
                });

                const data = await response.json();
                if (data.success) {
                    this.selectedConversation.status = 'resolved';
                }
            } catch (error) {
                console.error('Erreur lors de la résolution de la conversation:', error);
            }
        },

        async blockUser() {
            if (!confirm('Êtes-vous sûr de vouloir bloquer cet utilisateur ?')) return;

            try {
                const response = await fetch('/vendeur/messagerie/bloquer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ client_id: this.selectedConversation.client.id })
                });

                const data = await response.json();
                if (data.success) {
                    window.location.reload();
                }
            } catch (error) {
                console.error('Erreur lors du blocage de l\'utilisateur:', error);
            }
        },

        toggleClientInfo() {
            this.showClientInfo = !this.showClientInfo;
        },

        formatDate(date) {
            return new Date(date).toLocaleDateString('fr-FR', {
                day: 'numeric',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        formatTime(date) {
            return new Date(date).toLocaleTimeString('fr-FR', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        formatPrice(price) {
            return new Intl.NumberFormat('fr-FR', {
                style: 'currency',
                currency: 'EUR'
            }).format(price);
        }
    }
}
</script>
@endsection
