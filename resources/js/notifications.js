import './bootstrap';

// Configuration de Pusher
const pusher = new Pusher(import.meta.env.VITE_PUSHER_APP_KEY, {
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    encrypted: true
});

// Sons de notification
const notificationSound = new Audio('/sounds/notification.mp3');

// Gestion des notifications
document.addEventListener('DOMContentLoaded', () => {
    const userId = document.body.dataset.userId;
    
    if (userId) {
        // S'abonner au canal privé du vendeur
        const channel = pusher.subscribe(`private-vendeur.${userId}`);
        
        // Écouter les notifications de messages
        channel.bind('message-notification', (data) => {
            // Jouer le son
            notificationSound.play();
            
            // Créer une notification système
            if ('Notification' in window && Notification.permission === 'granted') {
                new Notification('Nouveau message', {
                    body: data.notification.message,
                    icon: '/images/logo.png'
                });
            }
            
            // Dispatcher l'événement pour mettre à jour l'interface
            window.dispatchEvent(new CustomEvent('message-notification', {
                detail: data
            }));
        });
    }
});

// Demander la permission pour les notifications système
if ('Notification' in window && Notification.permission !== 'granted') {
    Notification.requestPermission();
}

// Gestion du statut en ligne
let activityTimer;
document.addEventListener('mousemove', updateActivity);
document.addEventListener('keydown', updateActivity);

function updateActivity() {
    clearTimeout(activityTimer);
    activityTimer = setTimeout(() => {
        fetch('/update-activity', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        });
    }, 300000); // 5 minutes
}