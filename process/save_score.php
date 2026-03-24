<?php
session_start();
$root = dirname(__DIR__);
require_once $root . '/utils/db_connect.php';

if (!isset($_SESSION['quiz_id'])) {
    $_SESSION['quiz_id'] = 1; // Force l'ID à 1 si vide, juste pour tester
}

// var_dump($_SESSION); // Debug : vérifier les données de session avant de les utiliser

// 1. Vérification que les données minimales nécessaires sont présentes en session
if (isset($_SESSION['user_id']) && isset($_SESSION['score'])) {

    // Récupération des données de la session
    $user_id = $_SESSION['user_id'];
    $quiz_id = $_SESSION['quiz_id'] ?? 1; // ID du quiz (assurez-vous qu'il existe en DB)
    $score   = $_SESSION['score'];
    $points  = $score * 100; // Calcul des points (ex. 100 par réponse correcte)
    $secs    = $_SESSION['total_time'] ?? 0; // Temps total accumulé
    $played = date('Y-m-d H:i:s');
    try {
        // requete SQL pour insérer le score dans la base de données

        $sql = "INSERT INTO score (points, correct_answers, time_seconds, played_at, user_id, quiz_id) 
        VALUES (:points, :correct, :secs, :played, :uid, :qid)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':points'  => $points,
            ':correct' => $score,
            ':secs'    => $secs,
            ':played'  => $played,
            ':uid'     => $user_id,
            ':qid'     => $quiz_id
        ]);

        // 3. Una volta salvato, vai alla pagina dei risultati
        header('Location: ../public/resultats.php');
        exit();
    } catch (PDOException $e) {
        // Se la query fallisce, questo ti dirà il perché (es. colonna errata)
        die("Errore durante il salvataggio dello score: " . $e->getMessage());
    }
} else {
    // Si la session est expirée ou les données manquent, on retourne au quiz
    header('Location: ../public/quiz.php?error=session_expired');
    exit();
}
