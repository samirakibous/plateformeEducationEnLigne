<?php
require_once 'db.php';
require_once 'classes/User.php';
require_once 'classes/Tag.php';
if (!isset($_SESSION)){
    session_start();
}


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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-gray-100">
    <?php require_once 'newHeader.php'; ?>

 <div class="bg-white shadow-xl rounded-lg p-6 mt-8">
    <button id="openFormTag"  class="text-white p-4 rounded-lg float-right m-5 bg-[#E3A008] hover:bg-[#c58f07] transition-all duration-300 ease-in-out transform hover:scale-105 shadow-md hover:shadow-lg">
        <i class="fas fa-plus-circle mr-2"></i>
    </button>

    <h1 class="text-3xl font-semibold text-center mb-8 text-gray-800">Tags</h1>
    <div class="grid grid-cols-3 gap-4">
        <?php
        $tag = new Tag();
        $tags = $tag->getAllTags();
        foreach ($tags as $tag) {
            echo '<div class="bg-white shadow-lg rounded-lg p-6 hover:shadow-2xl transition-all duration-300 ease-in-out transform hover:scale-105 border border-gray-200">';
            echo '<h2 class="text-xl font-semibold text-gray-800 mb-4">' . htmlspecialchars($tag['tag_name']) . '</h2>';
            echo '<form action="bulk_insert_tags.php" method="POST">';
            echo '<input type="hidden" name="tag_id" value="' . htmlspecialchars($tag['tag_id']) . '">';
            echo '<button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition-all duration-300 ease-in-out float-right transform hover:scale-110">
                        <i class="fas fa-trash-alt"></i>
                    </button>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>


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
