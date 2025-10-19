<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vérification d'identité - Supply</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center font-sans">
    <div class="w-full max-w-md bg-white shadow-lg rounded-2xl p-8 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-2">Vérification d'identité</h2>
        <p class="text-sm text-gray-500 mb-6">
            Pour finaliser votre inscription en tant que vendeur, veuillez importer une photo claire de votre carte nationale d'identité.
        </p>

        @if(session('success'))
            <div class="p-6 text-center">
                <div class="mx-auto flex items-center justify-center w-12 h-12 rounded-full bg-green-100 mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Document reçu avec succès !</h3>
                <p class="text-gray-600">{{ session('success') }}</p>
                <div class="mt-6">
                    <a href="{{ route('dashboard') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        Retour au tableau de bord
                    </a>
                </div>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-3 rounded-md bg-red-50 border border-red-200 text-red-700 text-sm">
                @foreach ($errors->all() as $error)
                    <div>⚠️ {{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if(!session('success'))
            <form action="{{ route('vendeur.cni.upload') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <div>
                    <label for="cni" class="block text-sm font-medium text-gray-700">Télécharger la CNI</label>
                    <input type="file" id="cni" name="cni" accept="image/*" required
                        class="mt-1 w-full border border-gray-300 rounded-lg px-4 py-2 bg-white focus:ring-2 focus:ring-green-500 focus:outline-none">
                    <p class="text-xs text-gray-500 mt-1">Formats acceptés : JPG, PNG (max 2 Mo)</p>
                </div>

                <button type="submit"
                    class="w-full mt-2 bg-gradient-to-r from-green-500 via-emerald-500 to-teal-500 hover:from-green-600 hover:to-emerald-600 text-white py-2.5 rounded-lg font-semibold shadow-md transition-all">
                    Envoyer ma CNI
                </button>
            </form>
        @endif

        <p class="mt-6 text-center text-sm text-gray-500">
            Une fois validée, vous aurez accès à votre tableau de bord vendeur.
        </p>
    </div>
</body>
</html>