<?php

// -----------------------------------------------------------
// Avvio sessione e impostazione header JSON
// -----------------------------------------------------------
session_start();  // Serve per leggere/scrivere le domande, indice corrente e punteggio
header('Content-Type: application/json');  // Imposta il tipo di risposta come JSON

// Connessione al database
require_once '../../utils/db_connect.php';

// -----------------------------------------------------------
// 1️⃣ Recupero i dati inviati dal JS
// -----------------------------------------------------------
$data = json_decode(file_get_contents("php://input"), true);
// ⚠️ php://input si può leggere UNA SOLA VOLTA — prendiamo tutto qui
$answer_id  = $data['answer_id']  ?? null;
$time_taken = $data['time_taken'] ?? 0;   //es. timer parte da 20, l'utente risponde a 14s → timeTaken = 6
$time_elapsed = $data['time_elapsed']  ?? null;

// Controllo che sia presente l'ID della risposta inviata
if (!isset($answer_id) && !isset($time_elapsed)) {
    echo json_encode(["error" => "No answer_id"]);
    exit();
}

// -----------------------------------------------------------
// 2️⃣ Recupero la domanda corrente dalla sessione
// -----------------------------------------------------------
$currentIndex    = $_SESSION['NumeroQuestioni'];           // Indice della domanda corrente
$currentQuestion = $_SESSION['questions'][$currentIndex];  // L'array della domanda corrente


$isCorrect     = false;  // Variabile per indicare se la risposta scelta è corretta
$correctAnswer = null;   // Variabile per salvare l'ID della risposta corretta


// -----------------------------------------------------------
// 3️⃣ Controllo la risposta scelta
// -----------------------------------------------------------



foreach ($currentQuestion['answers'] as $answer) {    //Scorre tutte le risposte della domanda corrente. Es. domanda ha 4 risposte (A, B, C, D) — le esamina una per una.
    if (!isset($time_elapsed)) {
        // Se l'utente ha cliccato questa risposta
        if ($answer['id'] == $answer_id) {
            if ($answer['is_correct']) {
                $isCorrect = true;       // Risposta corretta
                $_SESSION['score']++;    // Incremento aggiungi 1 al punteggio salvato nella sessione.
            }
        }
    }

    // Trovo sempre qual è la risposta corretta
    if ($answer['is_correct']) {
        $correctAnswer = $answer['id'];
    }
}


// -----------------------------------------------------------
// 4️⃣ Accumulo il tempo di questa domanda in sessione
// -----------------------------------------------------------
$_SESSION['total_time'] = ($_SESSION['total_time'] ?? 0) + $time_taken;

// -----------------------------------------------------------
// 5️⃣ Recupero il totale delle domande
// -----------------------------------------------------------
$totalQuestions = count($_SESSION['questions']);

// -----------------------------------------------------------
// 6️⃣ Passo alla prossima domanda
// -----------------------------------------------------------
$_SESSION['NumeroQuestioni']++;

// -----------------------------------------------------------
// 7️⃣ Controllo se abbiamo finito il quiz
// -----------------------------------------------------------
$isFinished = ($_SESSION['NumeroQuestioni'] >= $totalQuestions);
// TRUE se abbiamo appena risposto all'ultima domanda

$nextQuestion = null;
if (!$isFinished) {
    // Se non abbiamo finito, preparo la prossima domanda
    $nextQuestion = $_SESSION['questions'][$_SESSION['NumeroQuestioni']];
}


///////////////////////////////////////////////////////////////////////////
//////////Clasement: salvataggio risultati alla fine del quiz/////////////
/////////////////////////////////////////////////////////////////////////

// -----------------------------------------------------------
// 7.5️⃣ SALVATAGGIO NEL DATABASE (Se il quiz è finito)
// -----------------------------------------------------------
// Solo quando $isFinished diventa true cioé finito, 
// il server apre i cancelli verso il database per rendere i punti permanenti.
// if ($isFinished) {

// ///////Recupero dei Dati dalla Sessione////////

//     $user_id = $_SESSION['user_id']; // Assicurati che sia in sessione al login
//     $quiz_id = $_SESSION['quiz_id']; // L'ID del quiz che stanno giocando
    
//     // Calcolo punti: esempio 100 punti per ogni risposta corretta
//     $final_points = $_SESSION['score'] * 100; 
//     $correct_answers = $_SESSION['score'];
//     $total_time = $_SESSION['total_time'];

//     // Inserimento nella tabella score
//     $stmt = $pdo->prepare("INSERT INTO score (points, correct_answers, time_seconds, played_at, user_id, quiz_id) 
    
//     -- // Prepariamo la query SQL con i segnaposto per evitare SQL Injection
//     VALUES (:pts, :corr, :time, NOW(), :uid, :qid)");

//     // Eseguiamo il salvataggio inviando i dati reali al database
//     $stmt->execute([
//         'pts'  => $final_points,
//         'corr' => $correct_answers,
//         'time' => $total_time,
//         'uid'  => $user_id,
//         'qid'  => $quiz_id
//     ]);
    
//     // Opzionale: pulisci la sessione per un nuovo quiz
//     // unset($_SESSION['questions'], $_SESSION['NumeroQuestioni'], $_SESSION['score'], $_SESSION['total_time']);
// }


// -----------------------------------------------------------
// 8️⃣ Invio la risposta al JS in formato JSON
// -----------------------------------------------------------
echo json_encode([
    "isCorrect"     => $isCorrect,      // Se la risposta era corretta
    "correctAnswer" => $correctAnswer,  // ID della risposta corretta
    "isFinished"    => $isFinished,     // TRUE se era l'ultima domanda
]);
