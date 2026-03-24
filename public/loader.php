<?php
session_start();
$root = dirname(__DIR__);
require_once $root . "/utils/db_connect.php";

$errors = [];

// Se il form viene inviato (POST)
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // 1. Recupero e pulizia dello pseudo
    $pseudo = trim($_POST["pseudo"] ?? '');

    // 2. Validazione: lo pseudo non deve essere vuoto
    if (empty($pseudo)) {
        $errors[] = "Veuillez entrer un pseudo pour jouer.";
    }

    // 3. Se non ci sono errori, procediamo al database
    if (empty($errors)) {
        try {
            // Controlliamo se lo pseudo esiste già
            $stmt = $pdo->prepare("SELECT * FROM user WHERE pseudo = :pseudo");
            $stmt->execute([':pseudo' => $pseudo]);
            $user = $stmt->fetch();

            if ($user) {
                // Se esiste, lo logghiamo
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['pseudo'] = $user['pseudo'];
            } else {
                // Se NON esiste, lo creiamo 
                $sql = "INSERT INTO user (pseudo, created_at) VALUES (:pseudo, NOW())";
                $stmt = $pdo->prepare($sql);
                $stmt->execute([':pseudo' => $pseudo]);

                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['pseudo'] = $pseudo;
            }

            // Successo! Redirigiamo alla scelta dei quiz
            header("Location: selection.php");
            exit();

        } catch (PDOException $e) {
            $errors[] = "Erreur database: " . $e->getMessage();
        }
    }
}

// Includiamo l'header DOPO la logica di redirect
include $root . '/partials/header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuiZena - Le plaisir de jouer</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&display=swap" rel="stylesheet">

</head>
<body class="bg-[#FDFDFD] text-[#003459]">

<header class="w-full p-6 flex justify-between items-center max-w-7xl mx-auto">

</header>