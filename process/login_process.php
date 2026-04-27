<?php
session_start();
require_once "../utils/db_connect.php";


// Verifichiamo il metodo POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/user.php?error=bad-method");
    exit();
}

$pseudo = isset($_POST['pseudo']) ? trim($_POST['pseudo']) : '';

// Controllo se vuoto
if (empty($pseudo)) {
    header("Location: ../public/user.php?error=missing-value");
    exit();
}

try {
    // 1. CERCHIAMO se l'utente esiste già
    $stmt = $pdo->prepare("SELECT id, pseudo FROM user WHERE pseudo = :pseudo");
    $stmt->execute([':pseudo' => $pseudo]);
    $user = $stmt->fetch();

    if ($user) {
        // CASO A: L'utente esiste, recuperiamo i dati
        $_SESSION['user_id'] = (int)$user['id']; // Cast a intero per evitare errori DOUBLE
        $_SESSION['user_name'] = $user['pseudo'];
    } else {
        // CASO B: L'utente non esiste, lo creiamo
        $insert = $pdo->prepare("INSERT INTO user (pseudo, created_at) VALUES (:pseudo, NOW())");
        $insert->execute([':pseudo' => $pseudo]);
        
        $_SESSION['user_id'] = (int)$pdo->lastInsertId();
        $_SESSION['user_name'] = $pseudo;
    }

    // Reindirizzamento pulito
    header("Location: ../public/quiz.php");
    exit();

} catch (PDOException $e) {
    // Se c'è un errore, lo registriamo e torniamo indietro
    error_log($e->getMessage());
    header("Location: ../public/user.php?error=db-error");
    exit();
}