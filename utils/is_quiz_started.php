<?php 

// Protezione: se non è loggato, torna alla pagina login
if (!isset($_SESSION['questions'])) {
    header('Location: quiz.php');
    exit();
}

?>