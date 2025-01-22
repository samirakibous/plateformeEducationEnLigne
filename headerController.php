<?php

require_once 'db.php';
require_once 'classes/cours.php';
require_once 'classes/user.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $user = new User();
    $action = $_POST['action']; 
    if ($action === 'logout') {
        $user->logout();
    }
}

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
