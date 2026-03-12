<?php 

// Protezione: se non è loggato, torna alla pagina login
if (!isset($_SESSION['pseudo'])) {
    header('Location: user.php');
    exit();
}

?>