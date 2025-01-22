<?php
require_once 'db.php';
require_once 'categories.php';
require_once 'classes/Tag.php';
require_once 'classes/Cours.php';

// session_start(); // Assurez-vous que la session est bien démarrée
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: login.php');
    exit();
}

// Récupérer l'ID du cours via GET ou POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cours_id = $_POST['cours_id'] ?? null;
} else {
    $cours_id = $_GET['cours_id'] ?? null;
}

// Vérification si l'ID est valide
if (!$cours_id) {
    echo "Aucun ID de cours fourni.";
    exit();
}

// Récupérer les détails du cours
$cours = new Cours();
$coursDetails = $cours->getCourseDetailsById($cours_id);

if (!$coursDetails) {
    echo "Cours introuvable.";
    exit();
}

// Récupérer les catégories et les tags
$categorie = new Categorie();
$categories = $categorie->getAllCategories();
$tag = new Tag();
$tags = $tag->getAllTags();

// Si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données soumises par l'utilisateur
    $courseData = [
        'title'       => $_POST['titre'] ?? '',
        'description' => $_POST['description'] ?? '',
        'type'        => $_POST['contenu'] ?? '',
        'path'        => $_POST['contenue'] ?? '',
        'category_id' => $_POST['categorie'] ?? null,
    ];

    // Récupérer les tags sélectionnés
    $tagsSelected = $_POST['tags'] ?? [];
    $contentData = [
        'tags' => implode(',', $tagsSelected), // Convertir les tags en chaîne séparée par des virgules
    ];

    // Validation des données
    if (empty($courseData['title']) || empty($courseData['description'])) {
        echo "Le titre et la description sont obligatoires.";
        exit();
    }

    
    $teacher_id = $_SESSION['user_id'];
    // Mise à jour du cours
    $success = $cours->updateCourseAndRelatedTables($cours_id, $courseData, $teacher_id, $datatype, $data);

    if ($success) {
        header('Location: MesCours.php'); // Redirection après succès
        exit();
    } else {
        echo "Une erreur s'est produite lors de la mise à jour du cours.";
    }
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mettre à jour le Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <?php require_once 'header.php'; ?>

    <div class="container mx-auto px-4 mt-8">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Mettre à jour le Cours</h1>

        <form action="update_cours.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="cours_id" value="<?= htmlspecialchars($cours_id); ?>">


            <div class="mb-4">
                <label for="titre" class="block text-gray-700 font-bold mb-2">Titre du Cours :</label>
                <input type="text" id="titre" name="titre" class="w-full border border-gray-300 rounded-md p-2"
                    value="<?= htmlspecialchars($coursDetails['title']); ?>" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description :</label>
                <textarea id="description" name="description" class="w-full border border-gray-300 rounded-md p-2"
                    rows="4" required><?= htmlspecialchars($coursDetails['description']); ?></textarea>
            </div>

            <div class="mb-4">
                <label for="contenu" class="block text-gray-700 font-bold mb-2">Type de Contenu :</label>
                <select name="contenu" id="contenu" class="w-full p-2 border border-gray-300 rounded-lg" required>
                    <option value="video" <?= $coursDetails['type'] === 'video' ? 'selected' : ''; ?>>Vidéo</option>
                    <option value="document" <?= $coursDetails['type'] === 'document' ? 'selected' : ''; ?>>Document</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="contenue" class="block text-gray-700 font-bold mb-2">Chemin du Contenu :</label>
                <input type="text" name="contenue" id="contenue" class="w-full border border-gray-300 rounded-md p-2"
                    value="<?= htmlspecialchars($coursDetails['path']); ?>" required>
            </div>


            <div class="mb-4">
                <label for="tags" class="block text-gray-700 font-bold mb-2">Tags :</label>
                <select name="tags[]" id="tags" multiple class="w-full p-2 border border-gray-300 rounded-lg">
                    <?php
                    $coursTags = explode(',', $coursDetails['tags']);
                    foreach ($tags as $tag) {
                        $selected = in_array($tag['tag_id'], $coursTags) ? 'selected' : '';
                        echo '<option value="' . htmlspecialchars($tag['tag_id']) . '" ' . $selected . '>'
                            . htmlspecialchars($tag['tag_name']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="categorie" class="block text-gray-700 font-bold mb-2">Catégorie :</label>
                <select id="categorie" name="categorie" class="w-full border border-gray-300 rounded-md p-2" required>
                    <option value="">-- Sélectionnez une catégorie --</option>
                    <?php foreach ($categories as $categorie) : ?>
                        <option value="<?= htmlspecialchars($categorie['id']); ?>"
                            <?= isset($coursDetails['category_id']) && $coursDetails['category_id'] == $categorie['id'] ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($categorie['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>


            <div class="flex justify-center gap-5">
                <button type="submit"
                    class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                    Mettre à jour
                </button>
                <a href="mes_cours.php"
                    class="bg-gray-500 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition">Annuler</a>
            </div>
        </form>
    </div>
</body>

</html>