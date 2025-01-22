<?php
require_once 'db.php';
require_once 'classes/cours.php';

session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'enseignant') {
    header('Location: login.php');
    exit;
}
if (isset($_GET['cours_id'])) {
    $cours_id = $_GET['cours_id'];

    $cours = new Cours();
    if ($cours->delete($cours_id)) {
        header('Location: MesCours.php');
        exit;
    } else {
        echo "Une erreur est survenue lors de la suppression du cours.";
    }
} else {
    header('Location: MesCours.php');
    exit;
}
?>
