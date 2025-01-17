<?php
session_start();
require_once '../db.php';
require_once '../User.php';
require_once '../Cours.php';

$user = new User();


if (isset($_POST['action']) && $_POST['action'] === 'supprimer') {
    if () {
        # code...
    }
    // $user->deleteUser($_POST['id']);
}

header('Location: /users.php');