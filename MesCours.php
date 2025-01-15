<?php
require_once 'db.php';
require_once 'categories.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
$categorie = new Categories();
$categories = $categorie->getAllCategories();
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
    <button id="openForm" class="text-black p-5 rounded  float-right m-5 bg-[#E3A008]">add cours</button>
    <div id="addCours" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
      <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Ajouter un Livre</h1>
    <form  action="ajouter_cours.php" method="POST" enctype="multipart/form-data" class="">
        <div class="mb-4">
            <label for="titre" class="block text-gray-700 font-bold mb-2">Titre du cours :</label>
            <input type="text" id="titre" name="titre" class="w-full border border-gray-300 rounded-md p-2" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Description :</label>
            <textarea id="description" name="description" class="w-full border border-gray-300 rounded-md p-2" rows="4" required></textarea>
        </div>

        <div class="mb-4">
            <label for="contenu" class="block text-gray-700 font-bold mb-2">Contenu (vidéo ou document) :</label>
            <input type="file" id="contenu" name="contenu" class="w-full border border-gray-300 rounded-md p-2" accept=".mp4,.pdf,.doc,.docx,.ppt,.pptx" required>
        </div>

        <div class="mb-4">
            <label for="tags" class="block text-gray-700 font-bold mb-2">Tags (séparés par des virgules) :</label>
            <input type="text" id="tags" name="tags" class="w-full border border-gray-300 rounded-md p-2" placeholder="Exemple : programmation, PHP, débutant" required>
        </div>

        <div class="mb-4">
            <label for="categorie" class="block text-gray-700 font-bold mb-2">Catégorie :</label>
            <select id="categorie" name="categorie" class="w-full border border-gray-300 rounded-md p-2" required>
                <option value="">-- Sélectionnez une catégorie --</option>
                <?php foreach ($categories as $categorie): ?>
                    <?php var_dump($categories) ?>
                    <option value="<?= htmlspecialchars($categorie['id']); ?>">
                        <?= htmlspecialchars($categorie['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex justify-center gap-5">
            <button id="addButton" type="submit" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                Ajouter le cours
            </button>
            <button id="closeForm"  class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                Annuler
            </button>
        </div>
    </form>
      </div>
    </div>
<script>
    const addCours= document.getElementById('addCours');
    const openForm= document.getElementById('openForm');
    const closeForm= document.getElementById('closeForm')
    openForm.addEventListener('click',()=>{
        addCours.classList.remove('hidden');  
    })
 
    closeForm.addEventListener('click',()=>{
        addCours.classList.add('hidden'); 
    })

</script>

</body>

</html>