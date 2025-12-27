import './bootstrap';

// Configuration de Pusher
const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true
});

// Gestion de la messagerie
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.querySelector('[data-messages-container]');
    const messageForm = document.querySelector('[data-message-form]');
    const messageInput = document.querySelector('[data-message-input]');
    const conversationId = document.querySelector('[data-conversation-id]')?.value;

    if (conversationId) {
        // S'abonner au canal de la conversation
        const channel = pusher.subscribe(`private-conversation.${conversationId}`);
        
        // Écouter les nouveaux messages
        channel.bind('nouveau-message', function(data) {
            if (data.message.expediteur_id !== window.userId) {
                appendMessage(data.message);
            }
        });
    }

    // Envoyer un message
    if (messageForm) {
        messageForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const contenu = messageInput.value.trim();
            if (!contenu) return;

            try {
                const response = await fetch(messageForm.action, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        conversation_id: conversationId,
                        contenu: contenu
                    })
                });

                const data = await response.json();
                if (data.message) {
                    appendMessage(data.message);
                    messageInput.value = '';
                    scrollToBottom();
                }
            } catch (error) {
                console.error('Erreur lors de l\'envoi du message:', error);
            }
        });
    }

    // Ajouter un message à la conversation
    function appendMessage(message) {
        const template = document.querySelector('[data-message-template]');
        if (!template) return;

        const messageEl = template.content.cloneNode(true);
        const messageContainer = messageEl.querySelector('.message-container');
        const messageContent = messageEl.querySelector('.message-content');
        const messageTime = messageEl.querySelector('.message-time');
        const messageAvatar = messageEl.querySelector('.message-avatar');

        // Configurer le message
        if (message.expediteur_id === window.userId) {
            messageContainer.classList.add('justify-end');
            messageContent.classList.add('bg-blue-600', 'text-white');
        } else {
            messageContainer.classList.add('justify-start');
            messageContent.classList.add('bg-white');
        }

        messageContent.textContent = message.contenu;
        messageTime.textContent = message.created_at;
        
        if (messageAvatar) {
            messageAvatar.src = message.expediteur.photoProfil || '/images/default-avatar.png';
            messageAvatar.alt = message.expediteur.nom;
        }

        messagesContainer.appendChild(messageEl);
        scrollToBottom();
    }

    // Faire défiler jusqu'au dernier message
    function scrollToBottom() {
        if (messagesContainer) {
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }

    // Scroll initial
    scrollToBottom();
});

// Gestion des notifications
const notificationSound = new Audio('/sounds/notification.mp3');

// Marquer les messages comme lus
function markMessagesAsRead(conversationId) {
    fetch('/client/messagerie/messages/lu', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ conversation_id: conversationId })
    });
}

// Gérer la visibilité de la page
document.addEventListener('visibilitychange', function() {
    if (!document.hidden && conversationId) {
        markMessagesAsRead(conversationId);
    }
});