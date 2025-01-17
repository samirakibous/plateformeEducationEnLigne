<?php
require_once 'db.php';
require_once 'categorie.php';
session_start();
if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
$categorie = new Categorie();
$categorie->getAllCategories();
?>
<!DOCTYPE html>
<?php if($role=== 'admin') { ?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width= device-width, initial-scale=1.0">
    <title>Youdemy - Categories</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">    
    <?php require_once 'header.php' ?>
    <button id="openFormCategorie" class="text-black p-5 rounded  float-right m-5 bg-[#E3A008]">add categorie</button>
    <div id="addCategorie" class="fixed hidden inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-md p-6 w-full max-w-md ">
        <h2 class="text-xl font-bold mb-4 text-gray-800">Ajouter Categorie</h2>
        <form method="POST" action="categorieActions/submit.php">
            <div class="mb-4">
                <input 
                name="name"
                    type="text" 
                    placeholder="Enter your text"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
            </div>
            <div class="flex justify-center gap-5">
            <input type="hidden" name="action" value="submit">

            <button id="addButtonCat" type="submit" class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                Submit
            </button>
            <button id="closeFormCategorie"  class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition">
                Annuler
            </button>
        </div>
        </form>
    </div>

    </div>
    <h1 class="text-2xl font-bold text-center mb-4 text-gray-800">Categories</h1>
        <div class="grid grid-cols-3 gap-4">
            <?php
           $categorie = new Categorie();
           $categories = $categorie->getAllCategories();
            foreach ($categories as $categorie) {
                echo '<div class="bg-white shadow-lg rounded-lg p-6">';
                echo '<h2 class="text-lg font-bold text-gray-800">' . $categorie['name'] . '</h2>';
                echo '
                <button class="bg-[#E3A008] text-white px-6 py-2 rounded-lg hover:bg-[#c58f07] transition float-right ">Supprimer</button>';
                echo '</div>';
            }
            ?>
        </div>
    <script>
    const addCategorie = document.getElementById('addCategorie');
    const openFormCategorie = document.getElementById('openFormCategorie');
    const closeFormCategorie = document.getElementById('closeFormCategorie');
    
    openFormCategorie.addEventListener('click', () => {
        addCategorie.classList.remove('hidden');  
    });
    
    closeFormCategorie.addEventListener('click', () => {
        addCategorie.classList.add('hidden'); 
    });
</script>

</body>
    <?php 
} else {
    echo "Vous n'avez pas accès à cette page.";
} 
?>

 