<?php
require_once 'db.php';
require_once 'classes/Cours.php';
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
 
 <header class="bg-gradient-to-r from-yellow-400 to-orange-500 text-white py-6 shadow-md">
    <div class="container mx-auto px-6 flex justify-between items-center">
        <!-- Logo -->
        <h1 class="text-3xl font-extrabold text-gray-900">Youdemy</h1>

        <!-- Navigation et Actions -->
        <div class="flex items-center space-x-6">
            <?php if ($role === 'enseignant'): ?>
                <nav class="flex gap-x-4">
                    <a href="index.php" class="text-white font-medium hover:text-gray-200 transition">Accueil</a>
                    <a href="MesCours.php" class="text-white font-medium hover:text-gray-200 transition">Mes Cours</a>
                </nav>
                <form action="headerController.php" method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit"
                        class="bg-gray-900 text-yellow-400 px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition">
                        Déconnexion
                    </button>
                </form>
            <?php elseif ($role === 'visiteur'): ?>
                <div class="flex gap-x-4">
                    <a href="login.php"
                        class="bg-gray-900 text-yellow-400 px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition">
                        Connexion
                    </a>
                    <a href="register.php"
                        class="bg-white text-gray-900 px-4 py-2 rounded-lg font-medium hover:bg-gray-200 transition">
                        S'inscrire
                    </a>
                </div>
            <?php elseif ($role === 'admin'): ?>
                <nav class="flex gap-x-4">
                    <a href="demandes.php" class="text-white font-medium hover:text-gray-200 transition">Demandes</a>
                    <a href="users.php" class="text-white font-medium hover:text-gray-200 transition">Utilisateurs</a>
                    <a href="categories.php" class="text-white font-medium hover:text-gray-200 transition">Catégories</a>
                    <a href="tags.php" class="text-white font-medium hover:text-gray-200 transition">Tags</a>
                </nav>
                <form action="headerController.php" method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit"
                        class="bg-gray-900 text-yellow-400 px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition">
                        Déconnexion
                    </button>
                </form>
            <?php elseif ($role === 'etudiant'): ?>
                <nav class="flex gap-x-4">
                    <a href="index.php" class="text-white font-medium hover:text-gray-200 transition">Les Cours</a>
                    <a href="coursInscrit.php" class="text-white font-medium hover:text-gray-200 transition">Mes Cours</a>
                </nav>
                <form action="headerController.php" method="POST">
                    <input type="hidden" name="action" value="logout">
                    <button type="submit"
                        class="bg-gray-900 text-yellow-400 px-4 py-2 rounded-lg font-medium hover:bg-gray-700 transition">
                        Déconnexion
                    </button>
                </form>
            <?php endif; ?>

            <!-- Barre de recherche -->
            <form method="GET" action="index.php" class="flex items-center space-x-3 bg-white p-2 rounded-lg shadow-sm">
                <input type="text" name="search" placeholder="Rechercher un cours..."
                    class="p-2 w-48 text-gray-800 rounded-md focus:outline-none focus:ring focus:ring-yellow-300"
                    value="<?= htmlspecialchars($search); ?>">
                <button type="submit"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition">
                    Rechercher
                </button>
            </form>
        </div>
    </div>
</header>

