<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QuiZena - Le plaisir de jouer</title>


    <link href="https://fonts.googleapis.com/css2?family=Libre+Baskerville:wght@400;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/main.js" defer></script>
</head>

<body class="bg-[url('../imgs/bg-image.png')] bg-cover bg-center min-h-screen flex flex-col bg-fixed">


    <header class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 py-4 sm:px-6 lg:px-8">

            <a href="../index.php" class="relative group flex items-center">
                <img src="../assets/imgs/Hands Graduate.png" alt="Cappello"
                    class="absolute -top-5 -left-3 w-10 h-10 rotate-[-15deg] z-20 pointer-events-none">
                <span class="text-2xl md:text-3xl font-extrabold relative z-10">
                    <span class="text-[#33658A]">Qui</span><span class="text-[#FCC822]">Zena</span>
                </span>
            </a>

            <nav class="hidden md:flex items-center gap-6 lg:gap-8 text-base lg:text-lg font-bold text-[#33658A]">
                <a href="selection.php" class="hover:text-[#9571F6] transition-colors">Jeux</a>
                <a href="#" class="hover:text-[#9571F6] transition-colors">Créer</a>
                <a href="#" class="hover:text-[#9571F6] transition-colors">Classement</a>
                <a href="user.php"
                    class="bg-[#FCC822] text-black px-8 py-2 rounded-[25px] border border-black uppercase text-sm tracking-[0.15em] font-bold hover:bg-[#FCC822]/80 transition-all shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] active:shadow-none active:translate-x-0.5 active:translate-y-0.5">
                    Login
                </a>
            </nav>

            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-[#33658A] focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-100 px-4 py-6 space-y-4 shadow-lg">
            <a href="selection.php" class="block text-lg font-bold text-[#33658A] hover:text-[#9571F6]">Jeux</a>
            <a href="#" class="block text-lg font-bold text-[#33658A] hover:text-[#9571F6]">Créer</a>
            <a href="#" class="block text-lg font-bold text-[#33658A] hover:text-[#9571F6]">Classement</a>
            <hr class="border-gray-100">
            <a href="user.php" class="block w-full text-center bg-[#FCC822] text-black py-3 rounded-[20px] border border-black font-bold uppercase tracking-wider">
                Login
            </a>
        </div>
    </header>
  <main class="relative z-10 min-h-screen pb-60">