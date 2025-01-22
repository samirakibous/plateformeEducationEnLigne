<?php
require_once 'db.php';
require_once 'classes/user.php';
session_start();

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    $message = $user->login($email, $password);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center min-h-screen">

    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Titre -->
        <h1 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Bienvenue sur Youdemy</h1>
        <p class="text-sm text-gray-600 text-center mb-8">
            Connectez-vous pour accéder à vos cours.
        </p>
        
        <!-- Formulaire -->
        <form action="login.php" method="POST" class="space-y-6">
            <!-- Champ Email -->
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Adresse email</label>
                <input type="email" name="email" id="email" required 
                    class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
            </div>
            
            <!-- Champ Mot de Passe -->
            <div>
                <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">Mot de passe</label>
                <input type="password" name="password" id="password" required 
                    class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
            </div>
            
            <!-- Bouton Connexion -->
            <div>
                <button type="submit" name="login" 
                    class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                    Se connecter
                </button>
            </div>
        </form>

        <!-- Lien vers Inscription -->
        <p class="text-sm text-gray-600 text-center mt-6">
            Pas encore inscrit ? <a href="register.php" class="text-yellow-500 font-semibold hover:underline">Créez un compte</a>.
        </p>
    </div>

</body>
</html>
