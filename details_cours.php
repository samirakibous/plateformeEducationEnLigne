<?php
require_once 'db.php';
require_once 'cours.php';

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
<body class="bg-gray-100">
    <div class="container mx-auto px-4 mt-8">
        <h1 class="text-3xl font-bold text-center mb-4 text-gray-800"><?= htmlspecialchars($details['title']) ?></h1>
        <p class="text-gray-600 mb-4"><?= htmlspecialchars($details['description']) ?></p>
        <?php if (!empty($details['path'])): ?>
            <div class="video-container">
                <h2 class="text-xl font-bold text-gray-800">Vidéo du cours</h2>
                <iframe 
                    src="<?= htmlspecialchars($details['path']) ?>" 
                    width="100%" 
                    height="400" 
                    frameborder="0" 
                    allowfullscreen>
                </iframe>
            </div>
        <?php else: ?>
            <p class="text-red-500">Aucune vidéo disponible pour ce cours.</p>
        <?php endif; ?>
    </div>
</body>
</html>
