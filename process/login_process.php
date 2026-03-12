<?php
/**
 * ETAPE 1: Controllo del Metodo (Sicurezza)
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/user.php?error=bad-method");
    exit();
}

/**
 * ETAPE 2: Controllo Esistenza e Valori Vuoti
 */
if (!isset($_POST["pseudo"]) || empty(trim($_POST["pseudo"]))) {
    // Come nell'esercizio dell'ospedale, rimandiamo indietro con un errore
    header("Location: ../public/user.php?error=missing-value");
    exit();
}

/**
 * ETAPE 3: Recupero e Sanitizzazione
 */
$pseudo = trim($_POST["pseudo"]);

/**
 * ETAPE 4: Esecuzione Sicura (Prepared Statements)
 */
require_once "../utils/db_connect.php";

try {
    // 1. Verifichiamo se lo pseudo esiste già
    $sqlCheck = "SELECT * FROM user WHERE pseudo = :pseudo";
    $stmtCheck = $pdo->prepare($sqlCheck);
    $stmtCheck->execute([':pseudo' => $pseudo]);
    $user = $stmtCheck->fetch();

    session_start();

    if ($user) {
        // Se esiste, effettuiamo il login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['pseudo'] = $user['pseudo'];
    } else {
        // 2. Se non esiste, lo inseriamo (come l'INSERT dei pazienti)
        $sqlInsert = "INSERT INTO user (pseudo, created_at) VALUES (:pseudo, NOW())";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([':pseudo' => $pseudo]);

        $_SESSION['user_id'] = $pdo->lastInsertId();
        $_SESSION['pseudo'] = $pseudo;
    }

    // 3. Reindirizziamo alla pagina principale o alla dashboard
    header("Location: ../public/quiz.php");
} catch (PDOException $e) {
    // In caso di errore, reindirizziamo con un messaggio di errore generico
    header("Location: ../public/user.php?error=database-error");
   exit();
}