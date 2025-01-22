<?php
?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 Interdit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="flex items-center justify-center min-h-screen bg-teal-100">
    <div class="text-center">
        <div class="flex items-center justify-center mb-6">
            <div class="w-24 h-24 bg-red-500 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636a9 9 0 11-12.728 0m12.728 0L5.636 18.364" />
                </svg>
            </div>
        </div>
        <h1 class="text-4xl font-bold text-gray-800">403 Forbidden</h1>
        <p class="mt-4 text-lg text-gray-600">
            Vous n'avez pas l'autorisation d'accéder à cette page.
        </p>
        <a href="index.php" class="mt-6 inline-block px-6 py-3 bg-blue-500 text-white font-medium rounded-lg hover:bg-blue-600">
            Retour à l'accueil
        </a>
    </div>
</body>
</html>
