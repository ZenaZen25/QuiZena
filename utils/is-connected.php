<?php 

// // Protezione: se non è loggato, torna alla pagina login
// if (!isset($_SESSION['pseudo'])) {
//     header('Location: user.php');
//     exit();
// }




// 1. Assicuriamoci che la sessione sia attiva
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Controllo COERENTE: usiamo 'user_id' perché è quello che setti nel login
if (!isset($_SESSION['user_id'])) {
    
    // 3. Reindirizzamento con percorso relativo corretto
    // Se is-connected.php è in /utils/ e user.php è in /public/
    header('Location: ../public/user.php');
    exit();
}

?>

