<?php
require_once 'db.php';
require_once 'classes/User.php';
require_once 'classes/demande.php';

require_once 'classes/Cours.php';
require_once 'classes/inscription.php';
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
<?php if($role=== 'admin') { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= device-width, initial-scale=1.0">
    <title>Youdemy - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">    
    <?php require_once 'newHeader.php' ?>
    
    <section class="container mx-auto px-4 mt-8">
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Demandes</h1>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="table-auto w-full border-collapse">
            <thead class="bg-gradient-to-r from-gray-700 to-gray-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left">ID</th>
                    <th class="px-6 py-3 text-left">Nom</th>
                    <th class="px-6 py-3 text-left">Email</th>
                    <th class="px-6 py-3 text-left">Rôle</th>
                    <th class="px-6 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($demandes as $demande): ?>
                    <tr class="odd:bg-gray-100 even:bg-gray-50 hover:bg-gray-200 transition">
                        <td class="px-6 py-4 text-gray-800"><?= $demande['id'] ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($demande['nom']) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($demande['email']) ?></td>
                        <td class="px-6 py-4 text-gray-800"><?= htmlspecialchars($demande['role']) ?></td>
                        <td class="px-6 py-4">
                            <div class="flex justify-center items-center space-x-4">
                                <form action="demandes.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $demande['id'] ?>">
                                    <input type="hidden" name="action" value="accepter">
                                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded-full hover:bg-green-600 transition">
                                        ✔️
                                    </button>
                                </form>
                                <form action="demandes.php" method="POST">
                                    <input type="hidden" name="id" value="<?= $demande['id'] ?>">
                                    <input type="hidden" name="action" value="refuser">
                                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-full hover:bg-red-600 transition">
                                        ❌
                                    </button>
                                </form>
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

 