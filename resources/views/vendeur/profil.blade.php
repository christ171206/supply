@extends('layouts.vendeur')

@section('title', 'Mon Profil')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête du profil -->
        <div class="relative h-48 bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="absolute -bottom-16 left-8">
                <div class="relative">
                    <img src="{{ auth()->user()->avatar ?? asset('images/default-avatar.png') }}" 
                         alt="Photo de profil" 
                         class="w-32 h-32 rounded-full border-4 border-white shadow-lg object-cover">
                    <label for="avatar" class="absolute bottom-0 right-0 bg-blue-500 text-white rounded-full p-2 cursor-pointer hover:bg-blue-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                        </svg>
                    </label>
                    <input type="file" id="avatar" name="avatar" class="hidden" accept="image/*">
                </div>
            </div>
        </div>

        <!-- Informations du profil -->
        <div class="pt-20 px-8 pb-8">
            <div class="grid md:grid-cols-2 gap-8">
                <!-- Informations personnelles -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800">Informations personnelles</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet</label>
                            <input type="text" id="nom" name="nom" value="{{ auth()->user()->nom }}" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                            <input type="email" id="email" name="email" value="{{ auth()->user()->email }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                            <input type="tel" id="telephone" name="telephone" value="{{ auth()->user()->telephone }}"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>

                <!-- Sécurité -->
                <div class="space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800">Sécurité</h2>
                    <div class="space-y-4">
                        <div>
                            <label for="current_password" class="block text-sm font-medium text-gray-700">Mot de passe actuel</label>
                            <input type="password" id="current_password" name="current_password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="new_password" class="block text-sm font-medium text-gray-700">Nouveau mot de passe</label>
                            <input type="password" id="new_password" name="new_password"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="new_password_confirmation" class="block text-sm font-medium text-gray-700">Confirmer le nouveau mot de passe</label>
                            <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="mt-8 flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuler
                </button>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Enregistrer les modifications
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Notification de succès -->
<div id="success-notification" class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg transform transition-transform duration-300 translate-y-full opacity-0">
    Les modifications ont été enregistrées avec succès
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du changement d'avatar
    const avatarInput = document.getElementById('avatar');
    const avatarImage = document.querySelector('img[alt="Photo de profil"]');

    avatarInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarImage.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Gestion du formulaire
    const form = document.querySelector('form');
    const successNotification = document.getElementById('success-notification');

    form.addEventListener('submit', async function(e) {
        e.preventDefault();

        try {
            // Simulation de l'envoi du formulaire (à remplacer par votre logique d'API)
            await new Promise(resolve => setTimeout(resolve, 1000));

            // Afficher la notification de succès
            successNotification.classList.remove('translate-y-full', 'opacity-0');
            
            // Masquer la notification après 3 secondes
            setTimeout(() => {
                successNotification.classList.add('translate-y-full', 'opacity-0');
            }, 3000);
        } catch (error) {
            console.error('Erreur lors de la mise à jour du profil:', error);
        }
    });
});
</script>
@endpush