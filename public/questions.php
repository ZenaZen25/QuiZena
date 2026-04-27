<?php
session_start();
$root = dirname(__DIR__);
require_once $root . '/utils/db_connect.php';
require_once $root . '/utils/is-connected.php';
require_once $root . '/utils/is_quiz_started.php';

$question = $_SESSION['questions'][$_SESSION['NumeroQuestioni']];

// var_dump($question);
// die();

include $root . '/partials/header.php';
?>

<main class="max-w-4xl mx-auto px-4 pt-12 mt-6  relative">

    <div class="w-full mb-8">
  <div class="w-full h-6 bg-gray-200 rounded-full border-4 border-gray-300 shadow-inner overflow-hidden">
    
    <div id="progress-bar"
      class="h-full rounded-full bg-linear-to-r from-orange-400 to-yellow-400 transition-all duration-500 ease-out"
      style="width: 0%">
    </div>

  </div>
</div>

    <!-- Titolo  -->
    <div class="flex justify-between items-center mb-12">

        <h2 class="text-4xl font-bold text-gray-700">
            Question <span id="current-num"><?= $_SESSION['NumeroQuestioni'] + 1 ?></span>/<span id="total-num"><?= count($_SESSION['questions']) ?></span>
        </h2>
        
        <!-- timer -->

        <div class="flex flex-row gap-8 items-center">
            <p id="elapsed-time" class="text-red-500 font-semibold opacity-0">Temps écoulé, la bonne risposta era:</p>

            <div class="relative w-28 h-28 flex items-center justify-center">
                <svg class="absolute inset-0 w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                    <circle cx="50" cy="50" r="45"
                        stroke="currentColor"
                        stroke-width="8"
                        fill="transparent"
                        class="text-gray-200" />

                    <circle id="timer-circle"
                        cx="50" cy="50" r="45"
                        stroke="currentColor"
                        stroke-width="8"
                        fill="transparent"
                        stroke-dasharray="283"
                        stroke-dashoffset="0"
                        stroke-linecap="round"
                        class="text-red-500 transition-all duration-1000" />
                </svg>

                <span id="timer-text" class="text-3xl font-black text-red-500">16</span>
            </div>
        </div>
    </div>

    <!-- Sezione domanda e risposte -->
    <section class="mt-12">
        <div class="bg-[#3e6a8b] rounded-[40px] px-8 py-16 text-center shadow-2xl mb-20 relative">


            <p id="question-text" class="text-white text-3xl md:text-4xl font-medium leading-tight max-w-3xl mx-auto">
                <?= htmlspecialchars($question['question_text']) ?>
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-16 gap-y-12 max-w-4xl mx-auto">

            <?php
            $letters = ['A', 'B', 'C', 'D'];
            foreach ($question['answers'] as $index => $answer) {
            ?>

                <button
                    class="answer-btn group flex items-center w-full min-h-25 bg-white border-[3px] border-[#33658A] rounded-[30px] shadow-[0_10px_0_0_rgba(51,101,138,0.1)] hover:shadow-none hover:translate-y-1 transition-all"
                    data-answer-id="<?= $answer['id'] ?>">

                    <div class="ml-4 w-16 h-16 bg-[#3e6a8b] rounded-2xl flex items-center justify-center text-2xl font-bold text-[#000000] shrink-0">
                        <?= $letters[$index] ?>
                    </div>

                    <div class="grow text-2xl font-semibold text-gray-700 px-6">
                        <?= htmlspecialchars($answer['answer_text']) ?>
                    </div>

                </button>

            <?php } ?>

        </div>
    </section>
    <div class="absolute left-12.5 -bottom-96  md:-left-40 lg:-left-60 z-10 hidden sm:block pointer-events-none">
        <img src="../assets/imgs/Personnes.png"
            class="w-64 md:w-80 lg:w-100 object-contain opacity-90 transform -rotate-3">
    </div>

    <!-- Bottone “Suivant” -->

</main>