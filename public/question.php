<?php
session_start();
$root = dirname(__DIR__);
require_once $root . '/utils/db_connect.php';
require_once $root . '/utils/is-connected.php';

$quizId = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($quizId === 0) {
    header("Location: quiz.php");
    exit();
}

try {
    $sql = "SELECT q.id AS q_id, q.question_text, quiz.category,
                   a.id AS a_id, a.answer_text, a.is_correct
            FROM question q
            JOIN answer a ON q.id = a.question_id
            JOIN quiz ON q.quiz_id = quiz.id
            WHERE q.quiz_id = :quiz_id
            ORDER BY q.id ASC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':quiz_id' => $quizId]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $questionsData = [];
    foreach ($results as $row) {
        $id = $row['q_id'];
        if (!isset($questionsData[$id])) {
            $questionsData[$id] = [
                'text' => $row['question_text'],
                'category' => $row['category'], // Questo ora passa a JS!
                'answers' => []
            ];
        }
        $questionsData[$id]['answers'][] = [
            'text' => $row['answer_text'],
            'is_correct' => (int)$row['is_correct']
        ];
    }

    $jsonQuestions = json_encode(array_values($questionsData));
} catch (PDOException $e) {
    die("Errore: " . $e->getMessage());
}

include $root . '/partials/header.php';
?>

<div id="quiz-data-bridge" data-quiz='<?= htmlspecialchars($jsonQuestions, ENT_QUOTES, 'UTF-8') ?>' style="display:none;"></div>

<main class="max-w-4xl mx-auto px-4 mt-6 mb-20 relative min-h-screen">
    <div class="w-full bg-white border-2 border-gray-100 h-6 rounded-full overflow-hidden shadow-inner mb-8">
        <div id="progress-bar" class="bg-[#FF9F43] h-full transition-all duration-500" style="width: 0%"></div>
    </div>

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-3xl font-bold font-serif text-[#2D3436]">
            Question <span id="current-number">1</span>/<span id="total-questions">0</span>
        </h2>

        <div class="relative w-20 h-20 flex items-center justify-center">
            <svg class="w-full h-full transform -rotate-90">
                <circle cx="40" cy="40" r="34" stroke="#eee" stroke-width="6" fill="none" />
                <circle cx="40" cy="40" r="34" stroke="#FF5E5E" stroke-width="6" fill="none"
                    stroke-dasharray="213" stroke-dashoffset="0" id="timer-circle" class="transition-all duration-1000" />
            </svg>
            <span id="timer-text" class="absolute text-2xl font-bold text-[#FF5E5E]">20</span>
        </div>
    </div>

    <div class="bg-[#7497B2] rounded-[40px] p-8 md:p-12 shadow-2xl text-white text-center mb-10 min-h-[220px] flex flex-col justify-center border-b-8 border-[#5D7B93]">
        <div class="text-xl mb-4 flex justify-center items-center gap-2">
          
        </div>
        <h1 id="question-text" class="text-2xl md:text-4xl font-medium leading-tight italic">
            Chargement...
        </h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" id="answers-grid"></div>

    <div class="flex justify-center mt-12">
        <button id="next-btn" class="hidden bg-[#FFC62D] hover:bg-[#FFB100] text-white text-2xl font-bold py-4 px-20 rounded-[30px] shadow-[0_8px_0_#E59E00] active:shadow-none active:translate-y-2 transition-all uppercase tracking-widest">
            Suivant →
        </button>
    </div>
</main> <div class="fixed bottom-0 left-0 w-full pointer-events-none -z-10">
    <div class="max-w-7xl mx-auto relative h-40">
        <img src="../assets/imgs/Personnes.png" class="absolute bottom-0 left-4 w-48 md:w-64 lg:w-80 opacity-60 object-contain">
    </div>
</div>

<div id="result-screen" class="hidden fixed inset-0 flex items-center justify-center bg-black/50 z-50 px-4">
    <div class="bg-white border-[3px] border-[#FF9F43] rounded-[40px] p-10 text-center shadow-xl max-w-lg w-full">
        <h2 class="text-4xl font-bold mb-4 text-[#2D3436]">Quiz Terminé ! 🎉</h2>
        <p class="text-2xl mb-8 text-gray-600">
            Ton score final : <span id="final-score" class="font-bold text-[#FF9F43]">0 / 0</span>
        </p>
        <a href="quiz.php" class="inline-block bg-[#FF9F43] text-white font-bold py-3 px-10 rounded-2xl border-b-4 border-[#CC7A29] hover:scale-105 transition-all">
            RETOUR AUX QUIZ
        </a>
    </div>
</div>

</body>
</html>