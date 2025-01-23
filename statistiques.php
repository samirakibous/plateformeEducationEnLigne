<?php
session_start();

require_once 'db.php';
require_once 'classes/etudiant.php';
require_once 'classes/Cours.php';
require_once 'classes/Enseignant.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
} 

$etudiant = new Etudiant();
$etudiants = $etudiant->getEtudiantNumber();

$cours = new Cours();
$coursNbr = $cours->getTotalCoursesNumber();
$coursMostEnroulement = $cours->getTopCoursesByEnrollment();

$enseignant = new Enseignant();
$enseignantTop = $enseignant->getTopTeachersByEnrollment();
var_dump($enseignantTop);die();
?>
<?php if($role=== 'enseignant') { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= device-width, initial-scale=1.0">
    <title>Youdemy - Accueil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">    
    <?php require_once 'newHeader.php' ?>

    <div class="container mx-auto px-4 mt-8">
    <h1 class="text-3xl font-bold text-center mb-6 text-gray-800">Statistiques</h1>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Statistiques des inscriptions</h2>
        <p class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            Nombre d'inscriptions : <?= htmlspecialchars($etudiants) ?>
        </p>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Statistiques des cours</h2>
        <p class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            Nombre de cours : <?= htmlspecialchars($coursNbr) ?>
        </p>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Le cour avec le plus d' étudiants</h2>
        <p class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            Nombre de cours : <?= htmlspecialchars($coursMostEnroulement['title']) ?>
        </p>
    </div>
    <div class="bg-white shadow-lg rounded-lg p-8">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">top 3 des enseignants</h2>
        <p class="text-lg text-gray-700 leading-relaxed text-justify break-words">
            Nombre de cours : <?= htmlspecialchars($coursMostEnroulement['title']) ?>
        </p>
    </div>
    </div>  
            
</body>
</html>
<?php 
} else {
     echo "Vous n'avez pas accès à cette page.";
} 
?>