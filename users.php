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

        <section class="container mx-auto px-4 mt-8">
            <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Users</h1>
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="border border-gray-300 px-4 py-2">ID</th>
                        <th class="border border-gray-300 px-4 py-2">Nom</th>
                        <th class="border border-gray-300 px-4 py-2">Email</th>
                        <th class="border border-gray-300 px-4 py-2">Role</th>
                        <th class="border border-gray-300 px-4 py-2">Status</th>
                        <th class="border border-gray-300 px-4 py-2">Date Inscription</th>


                        <th class="border border-gray-300 px-4 py-2">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['id'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['nom'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['email'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['role'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['status'] ?></td>
                            <td class="border border-gray-300 px-4 py-2"><?= $user['date_inscription'] ?></td>
                            <td class="border border-gray-300 px-4 py-2">
                                <div class="flex space-x-2">
                                    <form action="userActions/supprimer.php" method="POST">
                                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                        <input type="hidden" name="action" value="supprimer">
                                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">supprimer</button>
                                    </form>
                                    <?php if ($user['status'] === 'active'): ?>
                                        <form action="userActions/suspend.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="action" value="suspender">
                                            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">suspender</button>
                                        </form>
                                    <?php else: ?>
                                        <form action="userActions/activate.php" method="POST">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="action" value="activer">
                                            <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">activer</button>
                                        </form>
                                    <?php endif; ?>
                                  

                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
    </body>

    </html>
<?php
} else {
    echo "Vous n'avez pas accès à cette page.";
}
?>