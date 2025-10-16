<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Supply</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h2 class="text-2xl font-semibold text-center mb-6">Create an Account</h2>

       <form action="{{ route('register') }}" method="POST" class="space-y-4">
    @csrf
    <input type="text" name="nom" placeholder="Nom complet" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    <input type="email" name="email" placeholder="Email" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
    <input type="password" name="motDePasse" placeholder="Mot de passe" required class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

    <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-md hover:bg-blue-800 transition">
        Créer un compte
    </button>
</form>

    </div>
</body>
</html>
