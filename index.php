<?php
require_once 'db.php';
require_once 'Cours.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
?>
<?php //if($role=== 'visiteur') { 
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
 <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Tous Les Cours</h1>
        <div class="grid grid-cols-3 gap-4">
            <?php
            
            $cours = new Cours();
            $cours = $cours->getAllCours();
            foreach ($cours as $cours) {
                echo '<div class="bg-white shadow-lg rounded-lg p-6">';
                echo '<h2 class="text-lg font-bold text-gray-800">' . $cours['titre'] . '</h2>';
                echo '<p class="text-gray-600">' . $cours['description'] . '</p>';
                echo '<p class="text-gray-600">' . $cours['contenu'] . '</p>';
                echo '</div>';
            }
            ?>
        </div>
    </section>



</body>

</html>
<?php //}  else{
    //echo "vous n'avez pas accès à cette page";
//}?>