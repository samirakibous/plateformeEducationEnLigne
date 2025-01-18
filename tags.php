<?php
require_once 'db.php';
require_once 'User.php';
require_once 'Tag.php';
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}

$user = new User();
$users = $user->getAllUsers();

if ($role === 'admin') { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youdemy - Tags</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php require_once 'header.php'; ?>

    <!-- Bouton pour ouvrir le formulaire d'ajout de tags -->
    <button id="openFormTag" class="text-black p-5 rounded float-right m-5 bg-[#E3A008]">Ajouter des tags</button>

    <!-- Formulaire d'insertion en masse de tags -->
    <div id="addTag" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md">
            <h2 class="text-xl font-bold mb-4 text-gray-800">Insertion en masse de tags</h2>
            <form method="POST" action="bulk_insert_tags.php">
                <div class="mb-4">
                    <textarea 
                        name="tags" 
                        rows="5" 
                        placeholder="Saisissez plusieurs tags, séparés par des virgules ou des sauts de ligne"
                        class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    ></textarea>
                </div>
                <input type="hidden" name="action" value="add">
                <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                    Ajouter les tags
                </button>
                <button type="button" id="closeFormTag" class="ml-2 bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">
                    Annuler
                </button>
            </form>
        </div>
    </div>

    <!-- Liste des tags -->
    <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Tags</h1>
    <div class="grid grid-cols-3 gap-4">
        <?php
        $tag = new Tag();
        $tags = $tag->getAllTags(); // Récupérer tous les tags depuis la base de données
        foreach ($tags as $tag) { // Utiliser $tags correctement
            echo '<div class="bg-white shadow-lg rounded-lg p-6">';
            echo '<h2 class="text-lg font-bold text-gray-800">' . htmlspecialchars($tag['tag_name']) . '</h2>';
            echo '<form action="bulk_insert_tags.php" method="POST">';
            echo '<input type="hidden" name="tag_id" value="' . htmlspecialchars($tag['tag_id']) . '">';
            echo '<button type="submit" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition float-right">Supprimer</button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Script JavaScript pour gérer l'affichage du formulaire -->
    <script>
        const addTag = document.getElementById('addTag');
        const openFormTag = document.getElementById('openFormTag');
        const closeFormTag = document.getElementById('closeFormTag');

        openFormTag.addEventListener('click', () => {
            addTag.classList.remove('hidden');
        });

        closeFormTag.addEventListener('click', () => {
            addTag.classList.add('hidden');
        });
    </script>
</body>

</html>
<?php
} else {
    echo "Vous n'avez pas accès à cette page.";
}
?>
