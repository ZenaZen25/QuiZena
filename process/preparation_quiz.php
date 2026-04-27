<?php

// Avvio della sessione PHP
// Serve per salvare le domande del quiz, l'indice corrente e il punteggio dell'utente
session_start();

// Definisco la cartella principale del progetto
$root = dirname(__DIR__);

// Inclusione file di connessione al database
require_once $root . "/utils/db_connect.php";

// Inclusione file per verificare se l'utente è loggato
require_once $root . "/utils/is-connected.php";

// -----------------------------------------------------------
// Controllo il metodo della richiesta
// -----------------------------------------------------------
if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    // Se non è GET, reindirizzo alla pagina quiz con errore
    header("Location: ../public/quiz.php?error=bad-method");
    exit();
}

// -----------------------------------------------------------
// Controllo se l'ID del quiz è stato passato
// -----------------------------------------------------------
if (!isset($_GET['id'])) {
    header("Location: ../public/quiz.php?error=missing-id");
    exit();
}

if (empty($_GET['id'])) {
    header("Location: ../public/quiz.php?error=missing-value");
    exit();
}

// Pulizia dell'input per sicurezza
$idQuiz = htmlspecialchars(trim($_GET['id']));
$_SESSION['quiz_id'] = $idQuiz; // Salvo l'id del quiz in sessione per usarlo dopo

// -----------------------------------------------------------
// Recupero domande dal database
// -----------------------------------------------------------
try {
    // Preparo la query per prendere tutte le domande del quiz
    $stmt = $pdo->prepare("SELECT * FROM question WHERE quiz_id = :quiz_id");
    $stmt->execute([':quiz_id' => $idQuiz]);

    // Prendo tutte le domande come array
    $questions = $stmt->fetchAll();

    // Controllo se sono state trovate domande
    if ($questions) {

        // Per ogni domanda recupero anche le risposte associate
        foreach ($questions as &$question) {
            // Query per prendere le risposte della domanda
            $stmtAns = $pdo->prepare("SELECT * FROM `answer` WHERE `question_id`= :question_id");
            $stmtAns->execute([':question_id' => $question['id']]);

            // 1. Recuperiamo le risposte
            $answers = $stmtAns->fetchAll(PDO::FETCH_ASSOC);

            // 2. Controlliamo che $answers sia effettivamente un array e non sia vuoto
            if (is_array($answers) && !empty($answers)) {
                shuffle($answers); // Mischia solo se ci sono risposte // mélange
            } else {
                $answers = []; // Se è null o false, lo trasformiamo in un array vuoto per evitare errori
            }

            // 3. Assegniamo il risultato alla domanda
            $question['answers'] = $answers;

            // Salviamo le risposte mischiate dentro la domanda originale grazie alla '&'
            $question['answers'] = $answers;
        }

        // -----------------------------------------------------------
        // Salvo tutto in sessione
        // -----------------------------------------------------------
        $_SESSION['questions'] = $questions;      // Array completo di domande e risposte
        $_SESSION['NumeroQuestioni'] = 0;        // Indice della domanda corrente (inizia da 0)
        $_SESSION['score'] = 0;                  // Punteggio iniziale
        $_SESSION['total_time'] = 0;      // Tempo azzerato (importante per ajax_quiz_questions.php)
    } else {
        // Se non ci sono domande → errore quiz non trovato
        header("Location: ../public/quiz.php?error=quiz-not-found");
        exit();
    }

    // -----------------------------------------------------------
    // Reindirizzo alla pagina che mostra le domande
    // -----------------------------------------------------------
    header("Location: ../public/questions.php");
    exit();
} catch (PDOException $e) {
    // In caso di errore database → reindirizzo con errore
    header("Location: ../public/user.php?error=db-error");
    exit();
}

// var_dump($_GET); // utile per debug