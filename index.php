<?php
require_once 'db.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= device-width, initial-scale=1.0">
    <title>Youdemy - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <!-- header -->
    <?php require_once 'header.php' ?>
    <!-- Barre de recherche -->
    <section class="container mx-auto px-4 mt-8">
        <form method="GET" action="index.php" class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Rechercher un cours..."
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit"
                class="bg-[#E3A008] text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                Rechercher
            </button>
        </form>
        <?php
        var_dump($role);
        ?>

    </section>



</body>

</html>