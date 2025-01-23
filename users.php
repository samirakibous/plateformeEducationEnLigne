<?php
require_once 'db.php';
require_once 'classes/user.php';
require_once 'classes/demande.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];}
// } else {
//     $role = 'visiteur';
// }
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    </head>

    <body class="bg-gray-100">
        <?php require_once 'newHeader.php' ?>

        <section class="container mx-auto px-4 mt-8">
            <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">utilisateurs</h1>
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
            <table class="table-auto w-full border-collapse">
                <thead class="bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                    <tr>
                        <th class="px-6 py-4 text-gray-800">ID</th>
                        <th class="px-6 py-4 text-gray-800">Nom</th>
                        <th class="px-6 py-4 text-gray-800">Email</th>
                        <th class="px-6 py-4 text-gray-800">Role</th>
                        <th class="px-6 py-4 text-gray-800">Status</th>
                        <th class="px-6 py-4 text-gray-800">Date Inscription</th>
                        <th class="px-6 py-4 text-gray-800">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="odd:bg-gray-100 even:bg-gray-50 hover:bg-gray-200 transition">
                            <td class="px-6 py-4 text-gray-800"><?= $user['id'] ?></td>
                            <td class="px-6 py-4 text-gray-800"><?= $user['nom'] ?></td>
                            <td class="px-6 py-4 text-gray-800"><?= $user['email'] ?></td>
                            <td class="px-6 py-4 text-gray-800"><?= $user['role'] ?></td>
                            <td class="px-6 py-4 text-gray-800"><?= $user['status'] ?></td>
                            <td class="px-6 py-4 text-gray-800"><?= $user['date_inscription'] ?></td>
                            <td class="px-6 py-4 text-gray-800">
                                <div class="flex justify-center items-center space-x-4">
                                    <form action="userActions/supprimer.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="action" value="supprimer">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition">❌</button>
                                    </form>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <form action="userActions/suspend.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="action" value="suspender">
                                            <button type="submit"
                                                class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600 transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2">
                                                <i class="fas fa-pause"></i>
                                        </form>
                                    <?php else: ?>
                                        <form action="userActions/activate.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="action" value="activer">
                                            <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600 transition-all duration-300 ease-in-out transform hover:scale-105 flex items-center space-x-2">
                                                <i class="fas fa-check"></i></button>
                                        </form>
                                    <?php endif; ?>


                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            </div>
        </section>
    </body>

    </html>
<?php
} else {
    echo "Vous n'avez pas accès à cette page.";
}
?>