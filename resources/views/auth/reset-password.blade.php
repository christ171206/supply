<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset - Supply</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md text-center">
        <h2 class="text-2xl font-semibold mb-4">Password Reset</h2>
        <p class="text-gray-600 mb-6">We'll help you reset your password.</p>

        <form class="space-y-4">
            <input type="email" placeholder="Enter your email" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">

            <button class="w-full bg-blue-900 text-white py-2 rounded-md hover:bg-blue-800 transition">Reset Password</button>

            <p class="text-sm text-blue-700 hover:underline mt-4">
                <a href="/login">Back to Sign In</a>
            </p>
        </form>
    </div>
</body>
</html>
