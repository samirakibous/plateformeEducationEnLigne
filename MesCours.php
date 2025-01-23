<?php
require_once 'db.php';
require_once 'classes/categorie.php';
require_once 'classes/Cours.php';
require_once 'classes/Tag.php';
require_once 'ajouter_cours.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
$categorie = new Categorie();
$categorie->getAllCategories();

$categorie = new Categorie();
$categories = $categorie->getAllCategories();
$tag = new Tag();
$tags = $tag->getAllTags();
?>
<?php if ($role === 'enseignant') {
?>
    <!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width= device-width, initial-scale=1.0">
        <title>Youdemy - Accueil</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">



    </head>
    <body class="bg-gray-100">
    <!-- Header -->
    <?php require_once 'newHeader.php'; ?>

    <!-- Bouton Ajouter un cours -->
    <div class="container mx-auto px-4 mt-6 flex justify-end">

    </div>

    <!-- Section des cours -->
    <div class="container mx-auto px-4 mt-8">
    <div class="bg-white shadow-lg rounded-lg p-8">
        <!-- Bouton Ajouter un cours -->
    <button id="openForm" class="bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg hover:bg-yellow-700 transition">
            Ajouter un cours
        </button>
    <h1 class="text-4xl font-extrabold text-center mb-6 text-yellow-600   decoration-4">
        Mes Cours
    </h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $id = $_SESSION['user_id'];
            $cours = new Cours();
            $cours = $cours->getEnseignantCours($id);
            foreach ($cours as $cours) {
                echo '<div class="bg-white shadow-md rounded-lg overflow-hidden">';

                // Image par défaut pour chaque cours
                echo '<img src="uploads/images/CoursPhoto.png" alt="Cours image" class="w-full h-40 object-cover">';

                // Contenu du cours
                echo '<div class="p-6">';
                echo '<h2 class="text-xl font-bold text-gray-800 mb-2">' . htmlspecialchars($cours['title']) . '</h2>';
                echo '<p class="text-gray-600 mb-4">' . htmlspecialchars($cours['description']) . '</p>';

                // Boutons d'action
                echo '<div class="flex justify-between items-center">';
                echo '<a href="details_cours.php?cours_id=' . htmlspecialchars($cours['cours_id']) .
                '" class="text-[#E3A008] hover:text-[#c58f07] transition text-2xl"><i class="fas fa-eye"></i></a>';
                echo '<div class="flex space-x-2">';
                echo '<a href="update_cours.php?cours_id=' . htmlspecialchars($cours['cours_id']) .
                '" class="text-[#E3A008] hover:text-[#c58f07] transition text-2xl"><i class="fas fa-edit"></i></a>';
                echo '<a href="delete_cours.php?cours_id=' . htmlspecialchars($cours['cours_id']) . '"
                        class=" text-[#E3A008] hover:text-[#c58f07] transition text-2xl"">
                        <i class="fas fa-trash"></i>
                    </a>';
                echo '</div>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    </div>

            <div id="addCours" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
                    <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Ajouter un Livre</h1>
                    <form action="ajouter_cours.php" method="POST" enctype="multipart/form-data" class="">
                        <div class="mb-4">
                            <label for="titre" class="block text-gray-700 font-bold mb-2">Titre du cours :</label>
                            <input type="text" id="titre" name="titre" class="w-full border border-gray-300 rounded-md p-2" required>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 font-bold mb-2">Description :</label>
                            <textarea id="description" name="description" class="w-full border border-gray-300 rounded-md p-2" rows="4" required></textarea>
                        </div>

                        <?php
                        $contenu = isset($_POST['contenu']) ? $_POST['contenu'] : '';
                        ?>
                        <div class="mb-4">
                            <label for="contenu" class="block text-gray-700 font-bold mb-2">Contenu (vidéo ou document) :</label>
                            <select name="contenu" id="contenu" class="w-full p-2 border border-gray-300 rounded-lg">
                                <option value="" disabled <?= empty($contenu) ? 'selected' : ''; ?>>-- Sélectionnez une option --</option>
                                <option value="video" <?= $contenu === 'video' ? 'selected' : ''; ?>>Vidéo</option>
                                <option value="document" <?= $contenu === 'document' ? 'selected' : ''; ?>>Document</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <input type="text" name="contenue" class="w-full border border-gray-300 rounded-md p-2" required>
                        </div>

                            <div class="mb-4">
                                <label for="tags" class="block text-gray-700 font-bold mb-2">Tags :</label>
                                <select name="tags[]" id="tags" multiple class="w-full p-2 border border-gray-300 rounded-lg">
                                    <?php
                                    foreach ($tags as $tag) {

                                        echo '<option value="' . htmlspecialchars($tag['tag_id']) . '">' . htmlspecialchars($tag['tag_name']) . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label for="categorie" class="block text-gray-700 font-bold mb-2">Catégorie :</label>
                                <select id="categorie" name="categorie" class="w-full border border-gray-300 rounded-md p-2" required>
                                    <option value="">-- Sélectionnez une catégorie --</option>
                                    <?php foreach ($categories as $categorie): ?>
                                        <option value="<?= htmlspecialchars($categorie['id']); ?>">
                                            <?= htmlspecialchars($categorie['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="flex justify-center gap-5">
                                <input type="hidden" name="action" value="ajouterCours">
                                <input type="hidden" name="enseignant_id" value="<?= $_SESSION['user_id']; ?>">
                                <button type="submit" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                                    Ajouter le cours
                                </button>
                                <button id="closeForm" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                                    Annuler
                                </button>
                            </div>
                    </form>
                </div>
            </div>
            <script>
                const addCours = document.getElementById('addCours');
                const openForm = document.getElementById('openForm');
                const closeForm = document.getElementById('closeForm')
                openForm.addEventListener('click', () => {
                    addCours.classList.remove('hidden');
                })

                closeForm.addEventListener('click', () => {
                    addCours.classList.add('hidden');
                })
            </script>

    </body>

    </html>
<?php } else {
    header('location: erreure.php');
} ?>
