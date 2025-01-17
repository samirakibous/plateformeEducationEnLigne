<?php
require_once 'db.php';
require_once 'User.php';
require_once 'demande.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
$user = new User();
$users = $user->getAllUsers();

?>
<?php if ($role === 'admin') { ?>
<!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width= device-width, initial-scale=1.0">
        <title>Youdemy - Accueil</title>
        <script src="https://cdn.tailwindcss.com"></script>
    </head>

    <body class="bg-gray-100">
        <?php require_once 'header.php' ?>
<div class="container mx-auto p-5">
    <h2 class="text-2xl font-bold mb-4">Insertion en masse de tags</h2>
    <form method="POST" action="bulk_insert_tags.php">
        <div class="mb-4">
            <textarea 
                name="tags" 
                rows="5" 
                placeholder="Saisissez plusieurs tags, séparés par des virgules ou des sauts de ligne"
                class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            ></textarea>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
            Ajouter les tags
        </button>
    </form>
</div>
    </body>
    </html>
    <?php
} else {
    echo "Vous n'avez pas accès à cette page.";
}
?>