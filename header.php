
 <header class="bg-[#E3A008] text-white py-4">
        <div class="container mx-auto px-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold text-[#000000]">Youdemy</h1>
            <?php if ($role === 'enseignant'): ?>
                <ul class="flex gap-x-5">
                    <li><a href="index.php" class="text-black hover:underline">Home</a></li>
                    <li><a href="MesCours.php" class="text-black hover:underline">Mes cours</a></li>
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
            <?php endif; ?>
        </div>
    </header>
