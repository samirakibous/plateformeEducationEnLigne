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
$demande = new Demande();
$demandes = $demande->getDemandes();

if (isset($_POST['action']) && $_POST['action'] === 'accepter') {
    $demande->accepterDemande($_POST['id']); 
} elseif (isset($_POST['action']) && $_POST['action'] === 'refuser') {
    $demande->deleteDemande($_POST['id']); 
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
    <?php require_once 'header.php' ?>
    <section class="container mx-auto px-4 mt-8">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Demandes</h1>
        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID</th>
                    <th class="border border-gray-300 px-4 py-2">Nom</th>
                    <th class="border border-gray-300 px-4 py-2">Email</th>
                    <th class="border border-gray-300 px-4 py-2">Role</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr>
                        <td class="border border-gray-300 px-4 py-2"><?= $demande['id'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $demande['nom'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $demande['email'] ?></td>
                        <td class="border border-gray-300 px-4 py-2"><?= $demande['role'] ?></td>
                        <td class="border border-gray-300 px-4 py-2">
                            <div class="flex space-x-2">
                            <form action="demandes.php" method="POST">
                                <input type="hidden" name="id" value="<?= $demande['id'] ?>">   
                                <input type="hidden" name="action" value="accepter">
                                <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">Accepter</button>
                            </form>
                            <form action="demandes.php" method="POST">
                                <input type="hidden" name="id" value="<?= $demande['id'] ?>">
                                <input type="hidden" name="action" value="refuser">
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">Refuser</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </section>
</body>
</html>