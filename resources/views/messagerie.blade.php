@extends('layouts.vendeur')

@section('content')
<div class="flex h-screen">
    <!-- Liste des conversations -->
    <div class="w-1/4 bg-white border-r border-gray-200">
        <div class="p-4">
            <h2 class="text-xl font-semibold">Messages</h2>
            <!-- Zone de recherche -->
            <div class="mt-4">
                <input type="text" 
                       placeholder="Rechercher..." 
                       class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                       x-model="searchQuery"
                       @input="filterConversations">
            </div>
        </div>

        <!-- Liste des conversations -->
        <div class="overflow-y-auto h-[calc(100vh-200px)]">
            <template x-for="conversation in filteredConversations" :key="conversation.id">
                <div class="p-4 border-b border-gray-200 hover:bg-gray-50 cursor-pointer"
                     :class="{'bg-blue-50': selectedConversation?.id === conversation.id}"
                     @click="selectConversation(conversation)">
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0">
                            <img :src="conversation.avatar" class="w-10 h-10 rounded-full" alt="Avatar">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-gray-900" x-text="conversation.name"></p>
                            <p class="text-sm text-gray-500 truncate" x-text="conversation.lastMessage"></p>
                        </div>
                        <div class="text-xs text-gray-400" x-text="formatDate(conversation.lastMessageDate)"></div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <!-- Zone de messages -->
    <div class="flex-1 flex flex-col bg-gray-50">
        <template x-if="!selectedConversation">
            <div class="flex-1 flex items-center justify-center">
                <div class="text-center text-gray-500">
                    <i class="fas fa-comments text-4xl mb-2"></i>
                    <p>Sélectionnez une conversation pour commencer</p>
                </div>
            </div>
        </template>

        <template x-if="selectedConversation">
            <!-- En-tête de la conversation -->
            <div class="p-4 bg-white border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <img :src="selectedConversation.avatar" class="w-10 h-10 rounded-full" alt="Avatar">
                        <div>
                            <h3 class="font-medium text-gray-900" x-text="selectedConversation.name"></h3>
                            <p class="text-sm text-gray-500" x-text="selectedConversation.status"></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="p-2 hover:bg-gray-100 rounded-full">
                            <i class="fas fa-search text-gray-600"></i>
                        </button>
                        <button class="p-2 hover:bg-gray-100 rounded-full">
                            <i class="fas fa-ellipsis-v text-gray-600"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Messages -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer">
                <template x-for="message in selectedConversation.messages" :key="message.id">
                    <div class="flex"
                         :class="{'justify-end': message.isSent}">
                        <div class="max-w-[70%] break-words rounded-lg px-4 py-2"
                             :class="message.isSent ? 'bg-blue-500 text-white' : 'bg-white text-gray-900'">
                            <template x-if="message.type === 'text'">
                                <p x-text="message.content"></p>
                            </template>
                            <template x-if="message.type === 'image'">
                                <img :src="message.content" class="max-w-full rounded" alt="Image">
                            </template>
                            <template x-if="message.type === 'file'">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-file"></i>
                                    <span x-text="message.content"></span>
                                </div>
                            </template>
                            <div class="text-xs mt-1 opacity-75" x-text="formatTime(message.timestamp)"></div>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Zone de saisie -->
            <div class="p-4 bg-white border-t border-gray-200">
                <form @submit.prevent="sendMessage" class="flex items-end space-x-2">
                    <button type="button" class="p-2 text-gray-500 hover:text-gray-700"
                            @click="openFileInput">
                        <i class="fas fa-paperclip"></i>
                    </button>
                    <div class="flex-1">
                        <textarea
                            class="w-full px-4 py-2 bg-gray-100 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none"
                            placeholder="Écrivez votre message..."
                            rows="1"
                            x-model="newMessage"
                            @keydown.enter.prevent="sendMessage"></textarea>
                    </div>
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:opacity-50"
                            :disabled="!newMessage.trim()">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('messagerie', () => ({
        conversations: [],
        selectedConversation: null,
        newMessage: '',
        searchQuery: '',
        filteredConversations: [],

        init() {
            // Charger les conversations initiales
            this.loadConversations();
            
            // Écouter les nouveaux messages
            Echo.private('messagerie')
                .listen('NewMessage', (e) => {
                    this.handleNewMessage(e.message);
                });
        },

        loadConversations() {
            // Simuler le chargement des conversations
            fetch('/vendeur/messagerie/conversations')
                .then(response => response.json())
                .then(data => {
                    this.conversations = data;
                    this.filterConversations();
                });
        },

        filterConversations() {
            if (!this.searchQuery) {
                this.filteredConversations = this.conversations;
                return;
            }

            const query = this.searchQuery.toLowerCase();
            this.filteredConversations = this.conversations.filter(conv => 
                conv.name.toLowerCase().includes(query) || 
                conv.lastMessage.toLowerCase().includes(query)
            );
        },

        selectConversation(conversation) {
            this.selectedConversation = conversation;
            // Marquer comme lu
            fetch('/vendeur/messagerie/lu', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ conversationId: conversation.id })
            });
            
            // Faire défiler jusqu'au dernier message
            this.$nextTick(() => {
                const container = document.getElementById('messagesContainer');
                container.scrollTop = container.scrollHeight;
            });
        },

        async sendMessage(e) {
            if (!this.newMessage.trim()) return;

            const messageData = {
                conversationId: this.selectedConversation.id,
                content: this.newMessage,
                type: 'text'
            };

            try {
                const response = await fetch('/vendeur/messagerie/envoyer', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify(messageData)
                });

                if (response.ok) {
                    // Ajouter le message à la conversation
                    const message = await response.json();
                    this.selectedConversation.messages.push(message);
                    this.newMessage = '';

                    // Faire défiler jusqu'au nouveau message
                    this.$nextTick(() => {
                        const container = document.getElementById('messagesContainer');
                        container.scrollTop = container.scrollHeight;
                    });
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
                // Afficher une notification d'erreur
            }
        },

        openFileInput() {
            // Implémenter la logique d'upload de fichier
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*,.pdf,.doc,.docx';
            input.onchange = async (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const formData = new FormData();
                formData.append('file', file);
                formData.append('conversationId', this.selectedConversation.id);

                try {
                    const response = await fetch('/vendeur/messagerie/upload', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: formData
                    });

                    if (response.ok) {
                        const message = await response.json();
                        this.selectedConversation.messages.push(message);
                        
                        // Faire défiler jusqu'au nouveau message
                        this.$nextTick(() => {
                            const container = document.getElementById('messagesContainer');
                            container.scrollTop = container.scrollHeight;
                        });
                    }
                } catch (error) {
                    console.error('Erreur lors de l\'upload du fichier:', error);
                    // Afficher une notification d'erreur
                }
            };
            input.click();
        },

        formatDate(date) {
            // Formater la date (à implémenter selon vos besoins)
            return new Date(date).toLocaleDateString();
        },

        formatTime(timestamp) {
            // Formater l'heure (à implémenter selon vos besoins)
            return new Date(timestamp).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        },

        handleNewMessage(message) {
            // Gérer les nouveaux messages reçus via WebSocket
            if (this.selectedConversation?.id === message.conversationId) {
                this.selectedConversation.messages.push(message);
                this.$nextTick(() => {
                    const container = document.getElementById('messagesContainer');
                    container.scrollTop = container.scrollHeight;
                });
            }

            // Mettre à jour la dernière conversation
            const conversation = this.conversations.find(c => c.id === message.conversationId);
            if (conversation) {
                conversation.lastMessage = message.content;
                conversation.lastMessageDate = message.timestamp;
                // Réorganiser les conversations pour mettre la plus récente en haut
                this.conversations.sort((a, b) => 
                    new Date(b.lastMessageDate) - new Date(a.lastMessageDate)
                );
                this.filterConversations();
            }
        }
    }));
});
</script>
@endpush