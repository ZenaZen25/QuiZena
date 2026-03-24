<?php
session_start();

$root = dirname(__DIR__);
require_once $root . '/utils/db_connect.php';
require_once $root . '/utils/is-connected.php';
require_once $root . '/utils/is_quiz_started.php';

// Recuperi i dati che il tuo AJAX ha salvato durante il quiz
$score = $_SESSION['score'] ?? 0;
$total = count($_SESSION['questions'] ?? []);
$user = $_SESSION['user_name'] ?? 'Invitato';

// Calcoli i punti (es. 100 punti a risposta corretta)
$punti = $score * 100;

$incorrect = $total - $score;
$tempo_totale = $_SESSION['total_time'] ?? 0;
$tempo_medio = ($total > 0) ? round($tempo_totale / $total) : 0;

// recupera lo quiz che sto facendo per mostrare il titolo nella pagina dei risultati
$quiz_title = $_SESSION['quiz_title'] ?? 'Quiz';

include $root . '/partials/header.php';
?>

<!-- Blobs decorativi -->


<main class="relative z-10 max-w-3xl mx-auto px-4 py-10 text-center">

    <!-- Trofeo -->
    <div class="mb-6 animate-bounce">
        <span class="text-[5.5rem] font-black leading-none text-center block text-black">🏆</span>
    </div>

    <!-- Titolo -->
    <div class="mb-10">
        <h1 class="text-4xl font-black text-gray-800 mb-1">
            Bravo <?= htmlspecialchars($user) ?> !
        </h1>
        <p class="text-2xl font-extrabold text-gray-700">
            Tu as terminé le quiz <?= htmlspecialchars($quiz_title) ?>
        </p>
    </div>

    <!-- Card punteggio -->

    <div class="bg-[#FCC822] border-4 border-[#33658A] rounded-2xl py-12 px-6 max-w-2xl mx-auto mb-10 shadow-lg shadow-black/20">
        <span id="qz-pts"
            data-target="<?= (int)$punti ?>"
            class="text-xl font-extrabold text-white block leading-none text-[5.5rem]">
            0
        </span>
        <span class="text-xl text-center font-bold text-white uppercase tracking-widest px-3 mt-2 block">
            Points
        </span>
    </div>

    <!-- Statistiche -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 p-6 max-w-2xl mx-auto mb-14 w-[90%] md:w-full">
        <div class="bg-white border-2 border-green-500 rounded-2xl p-6 text-center shadow-lg shadow-black/5">
            <span class="text-4xl font-black text-green-500 block mb-1"><?= $score ?>/<?= $total ?></span>
            <span class="text-lg font-bold text-gray-700">Correct</span>
        </div>

        <div class="bg-white border-2 border-red-500 rounded-2xl p-6 text-center shadow-lg shadow-black/5">
            <span class="text-4xl font-black text-red-500 block mb-1"><?= $incorrect ?>/<?= $total ?></span>
            <span class="text-lg font-bold text-gray-700">Incorrect</span>
        </div>

        <div class="bg-white border-2 border-green-500 rounded-2xl p-6 text-center shadow-lg shadow-black/5">
            <span class="text-4xl font-black text-yellow-500 block mb-1"><?= $tempo_medio ?>s</span>
            <span class="text-lg font-bold text-gray-700">Moy. temps</span>
        </div>

    </div>

    <!-- Bottoni -->
    <!-- Bottone “Suivant” -->
    <div class="relative max-w-2xl border-amber-500 mx-auto mb-20">

        <a href="quiz.php"
            class="relative z-10 block border bg-[#FFC107] hover:bg-[#ffcd42] text-white font-extrabold py-6 px-12 rounded-3xl border-b-8 text-2xl text-center uppercase tracking-widest transition-all active:translate-y-2 active:border-b-0">
            Rejouer
        </a>
        <div class="absolute top-10 -left-12 md:-left-20 z-0">
            <img src="../assets/imgs/Personnes.png"
                class="w-48 md:w-64 lg:w-80 object-contain opacity-90 transition-transform hover:-rotate-3">
        </div>
    </div>

</main>

<?php
// IMPORTANTE: Puliamo la sessione del quiz così l'utente può ricominciare
// ma non distruggiamo la sessione dell'utente loggato!
// unset($_SESSION['questions']);
// unset($_SESSION['NumeroQuestioni']);
// unset($_SESSION['score']);
// unset($_SESSION['total_time']);
// unset($_SESSION['is_quiz_started']);
?>