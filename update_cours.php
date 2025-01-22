<?php
require_once 'db.php';
require_once 'classes/categorie.php';
require_once 'classes/Cours.php';

// session_start(); // Assurez-vous que la session est bien démarrée
session_start();

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


$categorie = new Categorie();
$categories = $categorie->getAllCategories();



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = $_POST['titre'] ?? null;
    $description = $_POST['description'] ?? null;
    $cours_id = $_POST['cours_id'] ?? null;
    $category_id = $_POST['category_id'] ?? null;

    if ($title == null && $description == null) {
        echo "Le titre et la description sont obligatoires.";
        exit();
    }
    
    $success = $cours->updateCoursTitle($cours_id, $title);
    if (!$success) {
        echo "Une erreur s'est produite lors de la mise à jour du titre du cours.";
    } else {
        $success = $cours->updateCoursDescription($cours_id, $description);
        if (!$success) {
            echo "Une erreur s'est produite lors de la mise à jour de la description du cours.";
        } else {
            $success = $cours->updateCoursCategoryId($cours_id, $category_id);
        }
    }
    if ($success) {
        header('Location: MesCours.php');
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
                <label for="categorie" class="block text-gray-700 font-bold mb-2">Catégorie :</label>
                <select id="categorie" name="category_id" class="w-full border border-gray-300 rounded-md p-2" required>
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