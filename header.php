<?php
require_once 'db.php';
require_once 'classes/Cours.php';

if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
} else {
    $role = 'visiteur';
}
?>
 
 <header class="bg-[#E3A008] text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-[#000000]">Youdemy</h1>

            <?php if ($role === 'enseignant'): ?>
                <ul class="flex gap-x-5">
                    <li><a href="index.php" class="text-black hover:underline">Home</a></li>
                    <li><a href="MesCours.php" class="text-black hover:underline">Mes cours</a></li>
                    <form action="headerController.php" method="POST"><input type="hidden" name="action" value="logout">
                    <button type="submit" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">Deconnexion
                    </button>
                </form>
                </ul>
            <?php elseif ($role === 'visiteur'): ?>
                <div class="flex gap-x-5">
                    <a href="login.php" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        Connexion
                    </a>
                    <a href="register.php" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">
                        S'inscrire
                    </a>
                </div>
            <?php elseif ($role === 'admin'): ?>
                <ul class="flex gap-x-5">
                    <li><a href="demandes.php" class="text-black hover:underline">demandes</a></li>
                    <li><a href="users.php" class="text-black hover:underline">users</a></li>
                    <li><a href="categories.php" class="text-black hover:underline">categories</a></li>
                    <li><a href="tags.php" class="text-black hover:underline">tags</a></li>
                    <form action="headerController.php" method="POST"><input type="hidden" name="action" value="logout">
                    <button type="submit" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">Deconnexion
                    </button>
                </form>
                <?php elseif ($role === 'etudiant'): ?>
                    <ul class="flex gap-x-5">
                    <li><a href="index.php" class="text-black hover:underline">Les cours</a></li>
                    <li><a href="coursInscrit.php" class="text-black hover:underline">Mes cours</a></li>
                    <form action="headerController.php" method="POST"><input type="hidden" name="action" value="logout">
                    <button type="submit" class="bg-black text-[#E3A008] px-4 py-2 rounded-lg hover:bg-gray-200 transition">Deconnexion
                    </button>
                </form>
                
                </ul>
            <?php endif; ?>
            
        </div>
    </header>
