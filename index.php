<?php

require_once 'db.php';
require_once 'classes/Cours.php';
require_once 'classes/inscription.php';
session_start();

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}

// Récupération des paramètres
$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Toujours s'assurer que la page est au moins 1
$limit = 6; // Nombre de cours par page
$offset = ($page - 1) * $limit; // Calcul de l'offset

// Initialiser la classe Cours
$cours = new Cours();

// Récupérer les cours filtrés et paginés
$coursList = $cours->getCoursWithPagination($search, $limit, $offset);

// Compter le nombre total de cours correspondant à la recherche
$totalCours = $cours->countCours($search);
$totalPages = ceil($totalCours / $limit);

if (isset($_POST['inscrire']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $coursId = $_POST['cours_id'];
    $etudiantId = $_SESSION['user_id'];

    $inscription = new Inscription();
    $inscription->inscrire($coursId,$etudiantId);
   

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
    <!-- header -->
    <?php require_once 'newHeader.php' ?>
    <!-- Barre de recherche -->
    <section class="container mx-auto px-4 mt-8">
        


        <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Tous Les Cours</h1>
        <div class="grid grid-cols-3 gap-4">
            <?php if (empty($coursList)): ?>
                <p class="text-gray-600">Aucun cours trouvé.</p>
            <?php else: ?>
                <?php foreach ($coursList as $cours): ?>
                    <div class="bg-white shadow-lg rounded-lg p-6">
                        <h2 class="text-lg font-bold text-gray-800"><?= htmlspecialchars($cours['title']); ?></h2>
                        <p class="text-gray-600"><?= htmlspecialchars($cours['description']); ?></p>

                    <?php if ($role == 'etudiant'): ?>
                        <?php 
                        $ins = new Inscription();
                            $etudiantId = $_SESSION['user_id'];
                        ?>
                        <?php if($ins->getEnrolementByEtudianteEtCours($etudiantId ,$cours['cours_id'])): ?>
                            <p class="text-gray-600">Vous avez deja inscrit ce cours</p>
                        <?php else: ?>
                        
                        <form action="index.php" method="POST" > 

                            <input type="hidden" value="<?= $cours['cours_id']; ?>" name="cours_id">
                            <button name="inscrire" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
                                S'inscrire
                            </button>
                        
                        </form>
                        <?php endif; ?>

                    <?php endif; ?>
                            <a href="details_cours.php?cours_id=<?= htmlspecialchars($cours['cours_id']); ?>" 
                            class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition float-right">
                            Voir le cours
                            </a>
                        
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <!-- Pagination -->
        <div class="flex justify-center mt-6 space-x-2">
            <?php if ($page > 1): ?>
                <a href="?search=<?= urlencode($search); ?>&page=<?= $page - 1; ?>"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Précédent</a>
            <?php endif; ?>

            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($search); ?>&page=<?= $i; ?>"
                    class="px-4 py-2 <?= $i === $page ? 'bg-blue-500 text-white' : 'bg-gray-300'; ?> rounded-lg hover:bg-gray-400">
                    <?= $i; ?>
                </a>
            <?php endfor; ?>

            <?php if ($page < $totalPages): ?>
                <a href="?search=<?= urlencode($search); ?>&page=<?= $page + 1; ?>"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400">Suivant</a>
            <?php endif; ?>
        </div>
    </section>
</body>

</html>
