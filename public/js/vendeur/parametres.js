// Code JavaScript pour gérer les interactions avec les paramètres
document.addEventListener('alpine:init', () => {
    // Gestion des paramètres
    Alpine.data('parametres', () => ({
        active: 'general',
        
        // État pour le drag & drop du logo
        isDragging: false,
        
        // Méthodes pour le drag & drop
        handleDragEnter() {
            this.isDragging = true;
        },
        handleDragLeave() {
            this.isDragging = false;
        },
        handleDrop(event) {
            this.isDragging = false;
            // Logique pour gérer le fichier déposé
            const file = event.dataTransfer.files[0];
            if (file) {
                document.getElementById('logo_upload').files = event.dataTransfer.files;
            }
        },

        // Méthodes pour la prévisualisation du logo
        previewLogo(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    document.getElementById('logo_preview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        },

        // Méthode pour sauvegarder les paramètres
        async saveSettings(formId) {
            const form = document.getElementById(formId);
            if (form) {
                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form)
                    });
                    
                    if (response.ok) {
                        // Afficher une notification de succès
                        this.showNotification('Paramètres enregistrés avec succès', 'success');
                    } else {
                        // Afficher une notification d'erreur
                        this.showNotification('Erreur lors de l\'enregistrement', 'error');
                    }
                } catch (error) {
                    console.error('Erreur:', error);
                    this.showNotification('Une erreur est survenue', 'error');
                }
            }
        },

        // Méthode pour afficher les notifications
        showNotification(message, type = 'success') {
            // Logique pour afficher les notifications
            const notification = document.createElement('div');
            notification.className = `fixed bottom-4 right-4 px-6 py-3 rounded-lg shadow-lg ${
                type === 'success' ? 'bg-green-500' : 'bg-red-500'
            } text-white`;
            notification.textContent = message;
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.remove();
            }, 3000);
        }
    }));
});