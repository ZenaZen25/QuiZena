<?php
session_start(); // Inizia la sessione per riconoscere l'utente loggato
$root = dirname(__DIR__); // Trova la cartella principale del progetto

// Include i file necessari per la connessione al DB e il controllo sicurezza
require_once $root . '/utils/db_connect.php';
require_once $root . '/utils/is-connected.php';

// -------------------------------------------------------------------------
// 1. RECUPERO DATI: La query SQL "intelligente"
// -------------------------------------------------------------------------
// Spiegazione Query:
// - JOIN: Unisce la tabella 'user' e 'score' usando l'ID utente.
// - MAX(points): Prende solo il punteggio più alto di ogni giocatore.
// - GROUP BY: Evita i duplicati (un nome appare una sola volta).
// - ORDER BY: Mette il più bravo (punteggio più alto) in cima alla lista.
$stmt = $pdo->query("
    SELECT u.pseudo, MAX(s.points) as top_score 
    FROM user u 
    JOIN score s ON u.id = s.user_id 
    GROUP BY u.id 
    ORDER BY top_score DESC 
    LIMIT 10
");
$rankings = $stmt->fetchAll(); // Trasforma il risultato del DB in un array PHP ($rankings)

// -------------------------------------------------------------------------
// 2. GESTIONE PODIO VUOTO
// -------------------------------------------------------------------------
// Se il database ha meno di 3 giocatori, aggiungiamo dei "finti" giocatori (---)
// così il design del podio (1°, 2°, 3°) non si rompe visivamente.
for ($i = count($rankings); $i < 3; $i++) {
    $rankings[] = ['pseudo' => '---', 'top_score' => 0];
}

include $root . '/partials/header.php'; // Carica il menu e i meta tag
?>

<main class="relative min-h-screen bg-white overflow-hidden pt-10 pb-40 px-4">

    <div class="absolute top-0 left-[-10%] w-64 h-64 bg-yellow-100/30 rounded-full blur-3xl -z-10"></div>
    <div class="absolute bottom-10 right-[-5%] w-80 h-80 bg-blue-100/30 rounded-full blur-3xl -z-10"></div>

    <div class="text-center mb-12">
        <h1 class="text-4xl md:text-5xl font-bold text-black tracking-tight">Classement Global</h1>
    </div>

    <section class="max-w-6xl mx-auto px-2 mb-20">
        <div class="flex flex-col sm:flex-row justify-center items-center sm:items-end gap-6 sm:gap-4 md:gap-20">
            
            <div class="flex flex-col items-center order-2 sm:order-1"> <div class="text-center mb-3">
                    <img src="../assets/imgs/Group 211.png" class="w-16 h-16 md:w-24 object-contain mx-auto" alt="">
                    <p class="font-bold text-xl md:text-2xl text-[#1D2D44] mt-2"><?= htmlspecialchars($rankings[1]['pseudo']) ?></p>
                    <p class="text-gray-400 text-lg md:text-xl font-semibold"><?= $rankings[1]['top_score'] ?> pts</p>
                </div>
                <div class="w-28 h-28 sm:w-36 sm:h-40 md:w-44 md:h-48 bg-[#FF6B6B] border-4 border-black rounded-t-[30px] flex items-center justify-center shadow-lg">
                    <span class="text-4xl md:text-6xl font-black text-white italic">2</span>
                </div>
            </div>

            <div class="flex flex-col items-center order-1 sm:order-2"> <div class="text-center mb-3">
                    <img src="../assets/imgs/Group 209 (1).png" class="w-20 h-20 md:w-32 object-contain mx-auto scale-110" alt="">
                    <p class="font-bold text-2xl md:text-4xl text-[#1D2D44] mt-2"><?= htmlspecialchars($rankings[0]['pseudo']) ?></p>
                    <p class="text-gray-400 text-xl md:text-2xl font-semibold"><?= $rankings[0]['top_score'] ?> pts</p>
                </div>
                <div class="w-32 h-44 sm:w-44 sm:h-60 md:w-56 md:h-72 bg-[#FFC107] border-4 border-black rounded-t-[35px] flex items-center justify-center shadow-[inset_0_8px_0_rgba(255,255,255,0.4)] relative z-10">
                    <span class="text-6xl md:text-8xl font-black text-white italic">1</span>
                </div>
            </div>

            <div class="flex flex-col items-center order-3"> <div class="text-center mb-3">
                    <img src="../assets/imgs/Group 204.png" class="w-16 h-16 md:w-24 object-contain mx-auto" alt="">
                    <p class="font-bold text-xl md:text-2xl text-[#1D2D44] mt-2"><?= htmlspecialchars($rankings[2]['pseudo']) ?></p>
                    <p class="text-gray-400 text-lg md:text-xl font-semibold"><?= $rankings[2]['top_score'] ?> pts</p>
                </div>
                <div class="shadow-lg rounded-t-[30px]">
                    <div class="w-28 h-20 sm:w-36 sm:h-28 md:w-44 md:h-36 bg-[#33658A] border-4border-black rounded-t-[30px] flex items-center justify-center shadow-[inset_0_6px_0_rgba(255,255,255,0.2)] drop-shadow-lg">
                        <span class="text-4xl md:text-6xl font-black text-white italic">3</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-4xl mx-auto space-y-8 px-4">
        <?php
        // array_slice: Salta i primi 3 giocatori (che sono già sul podio) e prende gli altri
        $others = array_slice($rankings, 3);
        foreach ($others as $index => $player):
            $pos = $index + 4; // L'indice parte da 0, quindi il primo della lista "altri" è il 4°
        ?>
            <div class="flex items-center justify-between bg-white border-[3px] border-[#FF9F43] rounded-[25px] p-4 md:p-5 shadow-[0_8px_0_0_rgba(0,0,0,0.1)] hover:translate-x-1 transition-all">
                <div class="flex items-center gap-6">
                    <span class="text-2xl md:text-3xl font-black text-gray-800 ml-4"><?= $pos ?></span>
                    <span class="text-lg md:text-xl font-bold text-gray-700"><?= htmlspecialchars($player['pseudo']) ?></span>
                </div>

                <div class="bg-white border-[3px] border-[#33658A] rounded-2xl px-5 py-2 flex items-center gap-3">
                    <span class="text-yellow-400 text-xl md:text-2xl">⭐</span>
                    <span class="font-bold text-lg md:text-xl text-[#1D2D44]"><?= $player['top_score'] ?> pts</span>
                </div>
            </div>
        <?php endforeach; ?>
    </section>

    <div class="relative max-w-2xl border-amber-500 mx-auto mt-20 mb-20">
        <a href="quiz.php"
            class="relative z-10 block border border-amber-300 w-full bg-[#FFC107] hover:bg-[#faecc4] text-white font-extrabold py-6 px-12 rounded-3xl border-b-8 text-2xl text-center uppercase tracking-widest transition-all active:translate-y-2 active:border-b-0">
            Retour à l'Accueil
        </a>
    </div>

</main>


<!-- $rankings[1]: Prende il secondo elemento dell'array (in programmazione si conta da 0, quindi 1 è il secondo).

htmlspecialchars: È il tuo scudo. Se un utente si chiama <script>alert('Hacked')</script>, questa funzione lo trasforma in semplice testo, impedendo che il codice venga eseguito nel tuo sito. -->