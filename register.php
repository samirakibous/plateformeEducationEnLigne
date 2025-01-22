<?php
require 'db.php';
session_start();

require_once 'classes/User.php';

$message = '';
if (isset($_POST['register'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name = htmlspecialchars($_POST['fullname']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $role = htmlspecialchars($_POST['role']);

        $user = new User();
        $message = $user->register($name, $email, $password, $role);
    }
}


?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Youdemy</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-yellow-400 to-orange-500 flex items-center justify-center min-h-screen">


    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8">
        <!-- Titre -->
        <h1 class="text-3xl font-extrabold text-gray-900 text-center mb-6">Rejoignez Youdemy</h1>
        <p class="text-sm text-gray-600 text-center mb-8">
            Créez un compte pour accéder à nos cours et outils pédagogiques.
        </p>
        <form action="register.php" method="POST" class="space-y-6">
            <div>
                <label for="fullname" class="block text-sm font-semibold text-gray-700 mb-1">Nom complet</label>
                <input type="text" name="fullname" id="fullname" required
                class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" id="email" required
                class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
            </div>
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                <input type="password" name="password" id="password" required
                class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
            </div>
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                <select name="role" id="role" required
                class="block w-full rounded-lg border border-gray-300 shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent sm:text-sm">
                    <option value="etudiant">Étudiant</option>
                    <option value="enseignant">Enseignant</option>
                </select>
            </div>
            <div>
                <button type="submit" name="register"
                class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                S'inscrire
                </button>
            </div>
        </form>
        <p class="text-sm text-gray-600 text-center mt-6">
            Vous avez déjà un compte ? <a href="login.php" class="text-yellow-500 font-semibold hover:underline">Connectez-vous</a>.
        </p>
    </div>

</body>

</html>