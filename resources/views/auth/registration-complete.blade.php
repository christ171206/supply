<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Complete - Supply</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <div class="text-6xl mb-4">📧</div>
        <h2 class="text-2xl font-semibold mb-4">Almost There!</h2>
        <p class="text-gray-600 mb-6">Check your email inbox and confirm your account.</p>

        <a href="/email-confirm" class="block bg-blue-900 text-white py-2 rounded-md hover:bg-blue-800 transition">I have verified my email</a>

        <p class="text-sm text-blue-700 hover:underline mt-4">
            <a href="#">Resend Confirmation Email</a>
        </p>
    </div>
</body>
</html>
