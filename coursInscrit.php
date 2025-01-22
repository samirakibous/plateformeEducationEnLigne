<?php
require_once 'classes/inscription.php';
?>
<!DOCTYPE html>
    <html lang="fr">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width= device-width, initial-scale=1.0">
        <title>Youdemy - Accueil</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    </head>

    <body class="bg-gray-100">
        <!-- header -->
        <?php require_once 'newHeader.php' ?>

    <div class="container mx-auto px-4 mt-8">
    <div class="bg-white shadow-lg rounded-lg p-8">

    <h1 class="text-4xl font-extrabold text-center mb-6 text-yellow-600   decoration-4">
        Mes Cours
    </h1>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            $id = $_SESSION['user_id'];
            
            $coursMng = new Cours();
            $cours = $coursMng->getCoursByEtudiant( $id );
            foreach ($cours as $cours) {
                echo '<div class="bg-white shadow-md rounded-lg overflow-hidden">';
                
                echo '<img src="uploads/images/CoursPhoto.png" alt="Cours image" class="w-full h-40 object-cover">';

                // Contenu du cours
                echo '<div class="p-6">';
                echo '<h2 class="text-xl font-bold text-gray-800 mb-2">' . htmlspecialchars($cours['title']) . '</h2>';
                echo '<p class="text-gray-600 mb-4">' . htmlspecialchars($cours['description']) . '</p>';
                
                // Boutons d'action
                echo '<div class="flex justify-between items-center">';
                echo '<a href="details_cours.php?cours_id=' . htmlspecialchars($cours['cours_id']) . 
                '" class="text-[#E3A008] hover:text-[#c58f07] transition text-2xl"><i class="fas fa-eye"></i></a>';
                echo '</div>';

                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </div>
    </div>
    </body>
    </html>