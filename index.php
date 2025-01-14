<?php
require_once 'db.php'
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

    <!-- Header -->
    <header class="bg-[#E3A008] text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-[#000000]">Youdemy</h1>
            <div class="flex gap-x-5">
            <a href="login.php" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                Connexion
            </a>
            <a href="register.php" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                s'inscrire
            </a>
            </div>
        </div>
    </header>

    <!-- Barre de recherche -->
    <section class="container mx-auto px-4 mt-8">
        <form method="GET" action="index.php" class="flex items-center space-x-4">
            <input type="text" name="search" placeholder="Rechercher un cours..." 
                class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-300">
            <button type="submit" 
                class="bg-[#E3A008] text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition">
                Rechercher
            </button>
        </form>
    </section>

    <!-- Liste des cours -->
    <section class="container mx-auto px-4 mt-8">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">Catalogue des cours</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Exemple de cours statiques (remplacez avec vos données dynamiques)
            $cours = [
                ["titre" => "Apprendre le PHP", "description" => "Introduction au langage PHP.", "enseignant" => "John Doe"],
                ["titre" => "HTML & CSS", "description" => "Création de pages web modernes.", "enseignant" => "Jane Smith"],
                ["titre" => "JavaScript Avancé", "description" => "Maîtrisez les concepts avancés de JS.", "enseignant" => "Alex Brown"],
            ];

            // Affichage des cours
            foreach ($cours as $cour) {
                echo '
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold text-gray-800">' . htmlspecialchars($cour['titre']) . '</h3>
                    <p class="text-gray-600 mt-2">' . htmlspecialchars($cour['description']) . '</p>
                    <p class="text-sm text-gray-500 mt-4">Enseignant : ' . htmlspecialchars($cour['enseignant']) . '</p>
                    <a href="#" class="text-blue-500 mt-4 inline-block hover:underline">Voir les détails</a>
                </div>
                ';
            }
            ?>
        </div>
    </section>

</body>
</html>
