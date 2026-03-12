<?php
session_start();
// session_destroy();
$root = dirname(__DIR__);
require_once $root . '/utils/db_connect.php';
require_once $root . '/utils/is-connected.php';


// Recuperiamo i quiz dalla tua tabella 'quiz' (database quizena)
$stmt = $pdo->query("SELECT * FROM quiz");
$quizzes = $stmt->fetchAll();

include $root . '/partials/header.php';
?>





<div class="max-w-4xl mx-auto px-4 mt-10">
    <section class="w-full bg-white border-[3px] border-[#FF9F43] rounded-[30px] p-6 md:p-10 flex flex-col md:flex-row justify-between items-center shadow-[0_10px_30px_rgba(0,0,0,0.1)] mb-10">
        <div class="text-center md:text-left mb-6 md:mb-0">
            <h2 class="text-3xl md:text-4xl font-bold font-baskerville text-[#2D3436]">Bienvenue !</h2>
            <p class="text-2xl md:text-3xl font-bold text-[#33658A] mt-1">
                <?= htmlspecialchars($_SESSION['pseudo']) ?> 👋
            </p>
        </div>
        <div class="bg-white border-2 border-[#B8D1E1] px-8 py-4 rounded-2xl flex items-center gap-4 shadow-sm">
            <span class="text-3xl">⭐</span>
            <span class="text-3xl font-bold text-[#2D3436]">1240 pts</span>
        </div>
    </section>

    <section class="flex flex-wrap justify-center gap-4 md:gap-10 mb-16">
        <div class="w-32 h-24 md:w-40 md:h-28 bg-white border-[3px] border-[#FCC822] rounded-[25px] flex items-center justify-center text-center p-2 shadow-lg hover:rotate-2 transition-transform">
            <span class="text-[#FCC822] font-bold text-xl md:text-2xl font-baskerville leading-tight">Questions</span>
        </div>
        <div class="w-32 h-24 md:w-40 md:h-28 bg-white border-[3px] border-[#FF5E5E] rounded-[25px] flex flex-col items-center justify-center text-center p-2 shadow-lg hover:-rotate-2 transition-transform">
            <span class="text-[#FF5E5E] font-bold text-lg md:text-xl font-baskerville uppercase">~ 2</span>
            <span class="text-[#FF5E5E] font-bold text-lg md:text-xl font-baskerville uppercase">Minutes</span>
        </div>
        <div class="w-32 h-24 md:w-40 md:h-28 bg-white border-[3px] border-[#33658A] rounded-[25px] flex flex-col items-center justify-center text-center p-2 shadow-lg hover:rotate-2 transition-transform">
            <span class="text-[#33658A] font-bold text-lg md:text-xl font-baskerville uppercase font-bold">4</span>
            <span class="text-[#33658A] font-bold text-lg md:text-xl font-baskerville uppercase leading-tight font-bold">Choix</span>
        </div>
    </section>

    <h3 class="text-3xl md:text-5xl font-bold font-baskerville text-[#2D3436] mb-10">Quiz disponible:</h3>

    <div class="space-y-6">
        <?php if (empty($quizzes)): ?>
            <div class="bg-white/80 p-10 rounded-3xl text-center italic text-gray-500 border-2 border-dashed border-gray-300">
                Aucun quiz disponible pour le moment...
            </div>
        <?php else: ?>
            <?php foreach ($quizzes as $quiz): ?>
                <div class="bg-white border-[3px] border-[#FF9F43] rounded-[30px] p-5 md:p-6 flex items-center gap-5 md:gap-8 shadow-md hover:shadow-xl transition-all group">

                    <div class="w-20 h-20 md:w-24 md:h-24 bg-[#FFF5ED] rounded-2xl flex items-center justify-center text-4xl md:text-5xl border border-orange-50 group-hover:scale-110 transition-transform">
                        <?php
                        $title = strtolower($quiz['title']);
                        if (strpos($title, 'scien') !== false) echo '🔬';
                        elseif (strpos($title, 'hist') !== false) echo '📚';
                        elseif (strpos($title, 'gen') !== false) echo '🧠';
                        else echo '🎮';
                        ?>
                    </div>

                    <div class="flex-1">
                        <h4 class="text-2xl md:text-3xl font-bold text-[#2D3436] font-baskerville">
                            <?= htmlspecialchars($quiz['title']) ?>
                        </h4>
                        <p class="text-gray-500 text-lg md:text-xl italic font-baskerville">
                            <?= htmlspecialchars($quiz['nb_questions']) ?> questions
                            <span class="text-[#33658A] lowercase"><?= htmlspecialchars($quiz['difficulty']) ?></span>
                        </p>
                    </div>

                    <a href="question.php?id=<?= $quiz['id'] ?>"
                        class="
    /* Layout base (Mobile) */
    block text-center w-full 
    /* Layout Tablet/PC (sopra i 640px) */
    sm:inline-block sm:w-auto 
    /* Colori e stile 3D */
    bg-[#FF9F43] hover:bg-[#FF8C1A] text-white font-bold 
    /* Padding responsive: meno spazio su mobile, più su PC */
    py-2 px-6 md:py-3 md:px-14 
    /* Bordi e Animazione */
    rounded-2xl border-b-[6px] border-[#CC7A29] 
    active:border-b-0 active:translate-y-1.5 transition-all 
    /* Testo responsive */
    text-lg md:text-xl uppercase tracking-widest
   ">
                        Play
                    </a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

    <div class="absolute bottom-2 left-4 md:right-20 lg:right-40 z-10 hidden sm:block">
        <img src="../assets/imgs/Personnes.png" class="w-64 md:w-80 lg:w-88 object-contain">
    </div>
</div>

</main>

</body>

</html>