<?php

if (!isset($_SESSION)){
    session_start();
}
require_once 'db.php';
require_once 'classes/VideoContent.php';
require_once 'classes/DocumentContent.php';
require_once 'classes/Cours.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'ajouterCours') {
    $title = $_POST['titre'];
    $description = $_POST['description'];
    $enseignantId = $_SESSION['user_id'];
    $categoryId = $_POST['categorie'];
    $contenuType = $_POST['contenu'];
    $tags = $_POST['tags'];

    // var_dump($_POST);die(); // "video" ou "document"
    // Étape 1 : Ajouter le cours
    $cours = new Cours();
    $courseId = $cours->create($title, $description, $enseignantId, $categoryId,$tags);

    if ($courseId) {

        // Étape 2 : Ajouter le contenu associé
        if ($contenuType === 'video') {
            // Récupérer les données spécifiques à la vidéo
            $vidUrl = $_POST['contenue']; // Chemin de la vidéo
            // Ajouter le contenu vidéo
            $videoContent = new VideoContent($courseId, $vidUrl, 82828);
            $videoResult = $videoContent->save();
            $videoResult = $videoContent->display($courseId);


            if ($videoResult) {
                echo "Cours et contenu vidéo ajoutés avec succès.";
            } else {
                echo "Erreur lors de l'ajout du contenu vidéo.";
            }
        } elseif ($contenuType === 'document') {
            // Récupérer les données spécifiques au document
            $path = $_POST['contenue']; // Chemin du document

            // Ajouter le contenu document
            $documentContent = new DocumentContent($courseId, $path, 16739);
            $docResult = $documentContent->save();

            if ($docResult) {
                echo "Cours et contenu document ajoutés avec succès.";
            } else {
                echo "Erreur lors de l'ajout du contenu document.";
            }
        } else {
            echo "Type de contenu invalide.";
        }
    } else {
        echo "Erreur lors de l'ajout du cours.";
    }
} else {
    // echo "Requête invalide.";
}
?>