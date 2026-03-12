<?php
/**
 * ETAPE 1: Controllo del Metodo
 * Verifichiamo che i dati arrivino solo tramite POST
 */
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: ../public/user.php?error=bad-method");
    exit();
}

/**
 * ETAPE 2: Controllo Esistenza Campi
 * Verifichiamo che la chiave 'pseudo' esista nell'array $_POST
 */
if (!isset($_POST["pseudo"])) {
    header("Location: ../public/user.php?error=missing-input");
    exit();
}

/**
 * ETAPE 3: Controllo Valori Vuoti
 * Verifichiamo che l'utente non abbia inviato uno pseudo vuoto
 */
if (empty(trim($_POST["pseudo"]))) {
    header("Location: ../public/user.php?error=missing-value");
    exit();
}

/**
 * ETAPE 4: Recupero e Sanitizzazione
 * Puliamo lo pseudo per evitare spazi inutili
 */
$pseudo = trim($_POST["pseudo"]);

/**
 * ETAPE 5: Gestione Database e Sessione
 */
require_once "../utils/db_connect.php";
session_start();

try {
    // 5.1: Cerchiamo se l'utente esiste già
    $sqlSearch = "SELECT id, pseudo FROM user WHERE pseudo = :pseudo";
    $stmtSearch = $pdo->prepare($sqlSearch);
    $stmtSearch->execute([':pseudo' => $pseudo]);
    $user = $stmtSearch->fetch();

    if ($user) {
        // L'utente esiste, recuperiamo l'ID
        $userId = $user['id'];
    } else {
        // 5.2: L'utente non esiste, lo creiamo (Registrazione automatica)
        $sqlInsert = "INSERT INTO user (pseudo) VALUES (:pseudo)";
        $stmtInsert = $pdo->prepare($sqlInsert);
        $stmtInsert->execute([':pseudo' => $pseudo]);
        $userId = $pdo->lastInsertId();
    }

    /**
     * ETAPE 6: Salvataggio Sessione e Redirect
     */
    $_SESSION['user_id'] = $userId;
    $_SESSION['pseudo']  = $pseudo;

    // Se tutto va bene, andiamo alla pagina di scelta dei quiz
    header("Location: ../public/quiz.php?success=welcome");
    exit();

} catch (PDOException $e) {
    // In caso di errore del database
    header("Location: ../public/user.php?error=db-error");
    exit();
}