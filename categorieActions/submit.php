<?php
session_start();
require_once '../db.php';
require_once '../categorie.php';

$categorie = new Categorie();
if (isset($_POST['action']) && $_POST['action'] === 'submit') {
    $name = $_POST['name'];
    $categorie->createCategorie($name);
}
header('Location: /categories.php');