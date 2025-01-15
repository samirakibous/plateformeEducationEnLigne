<?php
require_once 'db.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
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
    <!-- header -->
    <?php require_once 'header.php' ?>
    <button class="text-black p-5 rounded  float-right m-5 bg-[#E3A008]">add cours</button>
</body>
</html>