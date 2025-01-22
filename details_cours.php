<?php
require_once 'db.php';
require_once 'classes/cours.php';
session_start();
if (isset($_GET['cours_id'])) {
    $coursId = $_GET['cours_id'];

    // Récupération des détails du cours
    $cours = new Cours();
    $details = $cours->getCourseDetailsById($coursId);

    if (!$details) {
        echo "Détails introuvables pour ce cours.";
        exit;
    }
} else {
    echo "Aucun cours sélectionné.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Cours</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    <?php require_once 'newHeader.php'; ?>
    <div class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-3xl">
        <h1 class="text-4xl font-bold text-center text-gray-800 mb-6">
            <?= htmlspecialchars($details['title']) ?>
        </h1>
        <?php if (!empty($details['path'])): ?>
            <div class="mb-6">
                <div class="relative w-full h-0" style="padding-bottom: 56.25%; /* Ratio 16:9 */">
                    <iframe 
                        src="<?= htmlspecialchars($details['path']) ?>" 
                        class="absolute top-0 left-0 w-full h-full rounded-lg shadow-lg" 
                        frameborder="0" 
                        allowfullscreen>
                    </iframe>
                </div>
            </div>
        <?php else: ?>
            <p class="text-red-500 text-center font-semibold mb-4">
                Aucune vidéo disponible pour ce cours.
            </p>
        <?php endif; ?>
        <div class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            <?= nl2br(htmlspecialchars($details['description'])) ?>
        </div>
        <div class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">teacher name </h2>
            <?= nl2br(htmlspecialchars($details['nom'])) ?>
        </div>

    </div>
</div>

</body>
</html>