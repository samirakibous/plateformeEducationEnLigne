<?php
require_once 'db.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
} 

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
</body>
</html>
<?php 
} else {
     echo "Vous n'avez pas accès à cette page.";
} 
?>