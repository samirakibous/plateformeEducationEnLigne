<?php
require_once 'db.php'; // Connexion à la base de données
require_once 'Tag.php'; // Inclusion de la classe

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tags'])) {
    // Récupérer les tags soumis
    $tagsInput = $_POST['tags'];

    // Séparer les tags par virgule ou saut de ligne
    $tagsArray = preg_split('/[\n,]+/', $tagsInput);

    // Initialiser l'instance de TagManager
    $tag = new Tag();

    // Appeler la méthode d'insertion
    $result = $tag->insertTags($tagsArray);

    // Afficher un message de succès ou d'erreur
    echo $result['message'];
}
?>
