<?php
require_once 'db.php';
require_once 'classes/categorie.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
$categorie = new Categorie();
$categorie->getAllCategories();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['categorie_id'])) {
    $categorieId = $_POST['categorie_id'];
    $result = $categorie->deleteCategorie($categorieId);
}
?>
<!DOCTYPE html>
<?php if ($role === 'admin') { ?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width= device-width, initial-scale=1.0">
        <title>Youdemy - Categories</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </head>

    <body class="bg-gray-100">
    <?php require_once 'newHeader.php'; ?>

    <div class="bg-white shadow-xl rounded-lg p-6 mt-8">

    
    <!-- Bouton pour ajouter une catégorie avec une icône -->
    <button id="openFormCategorie" class="text-white p-4 rounded-lg float-right m-5 bg-[#E3A008] hover:bg-[#c58f07] transition-all duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i>
    </button>

    <!-- Titre de la section -->
    <h1 class="text-3xl font-semibold text-center mb-8 text-gray-800">Catégories</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-4">
            <?php
            $categorie = new Categorie();
            $categories = $categorie->getAllCategories();
            foreach ($categories as $categorie) {
                echo '<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105 border border-gray-200">';
                echo '<h2 class="text-xl font-semibold text-gray-800 mb-4">' . htmlspecialchars($categorie['name']) . '</h2>';
                echo '<form action="categories.php" method="POST">';
                echo '<input type="hidden" name="categorie_id" value="' . $categorie['id'] . '">';
                echo '<button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-all duration-300 ease-in-out float-right transform hover:scale-110">
                        <i class="fas fa-trash-alt"></i>
                    </button>';
                echo '</form>';
                echo '</div>';
            }
            ?>
        </div>
    
        </div>
        <div id="addCategorie" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md ">
                <h2 class="text-xl font-bold mb-4 text-gray-800">Ajouter Categorie</h2>
                <form method="POST" action="categorieActions/submit.php">
                    <div class="mb-4">
                        <input
                            name="name"
                            type="text"
                            placeholder="Enter your text"
                            class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                    <div class="flex justify-center gap-5">
                        <input type="hidden" name="action" value="submit">

                        <button id="addButtonCat" type="submit" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                            Submit
                        </button>
                        <button id="closeFormCategorie" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                            Annuler
                        </button>
                    </div>
                </form>
            </div>

        </div>
        <script>
            const addCategorie = document.getElementById('addCategorie');
            const openFormCategorie = document.getElementById('openFormCategorie');
            const closeFormCategorie = document.getElementById('closeFormCategorie');

            openFormCategorie.addEventListener('click', () => {
                addCategorie.classList.remove('hidden');
            });

            closeFormCategorie.addEventListener('click', () => {
                addCategorie.classList.add('hidden');
            });
        </script>

    </body>
<?php
} else {
    echo "Vous n'avez pas accès à cette page.";
}
?>