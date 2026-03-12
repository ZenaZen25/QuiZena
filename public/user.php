<?php
session_start();
$root = dirname(__DIR__);
require_once $root . "/utils/db_connect.php";
require_once $root . '/utils/is-connected.php';

$errors = [];
if (isset($_GET['error'])) {
    $errorMap = [
        'missing-value' => "Le pseudo est obligatoire.",
        'user-not-found' => "Pseudo introuvable.",
        'already-exists' => "Ce pseudo est déjà utilisé."
    ];
    $errors[] = $errorMap[$_GET['error']] ?? "Une erreur est survenue.";
}

include $root . '/partials/header.php';
?>





<section class="mt-20 flex flex-col items-center text-center max-w-7xl mx-auto mb-10 md:mb-16 px-4">
    <div class="bg-[#D9E9F2] px-4 md:px-6 py-2 rounded-full border border-[#B8D1E1] shadow-sm mb-6 md:mb-8">
        <p class="text-[#33658A] font-bold text-[10px] md:text-sm uppercase tracking-wider">Plus d'un million de parties jouées</p>
    </div>

    <div class="w-full mb-6">
        <h1 class="text-2xl md:text-5xl lg:text-[54px] font-bold leading-tight wrapbreak-words">
            <span class="text-[#33658A]">Qui</span><span class="text-[#FCC822]">Zena</span><span class="text-[#000000]"> : Le plaisir de jouer entre amis</span>
        </h1>

        <div class="text-lg md:text-4xl lg:text-[48px] font-bold italic mt-4 flex flex-wrap justify-center gap-2 md:gap-4">
            <span class="text-[#9571F6]">Jouez.</span>
            <span class="text-[#34C759]">Comparez.</span>
            <span class="text-[#33658A]">Recommencez.</span>
        </div>
    </div>

    <div class="w-full max-w-xs md:max-w-5xl h-0.5 mb-8 mt-6 relative">
        <div class="absolute inset-0 bg-linear-to-r from-transparent via-[#33658A] to-transparent opacity-50"></div>
    </div>

    <div class="max-w-4xl">
        <p class="text-base md:text-2xl lg:text-[30px] leading-snug md:leading-relaxed font-normal text-[#343131] font-baskerville opacity-80">
            Transformez chaque quiz en un défi explosif. Jouez, affrontez vos amis et grimpez au sommet du classement en un clic.
        </p>
    </div>
</section>

<section class="-mt-10 flex justify-center items-center py-6 md:py-10 w-full">
    <div class="flex gap-3 md:gap-8 z-20 relative">
        <img src="../assets/imgs/&é.png" class="w-12 h-12 md:w-24 md:h-24 animate-jump" style="animation-delay: 0s;">
        <img src="../assets/imgs/jeunSmile.png" class="w-12 h-12 md:w-24 md:h-24 animate-jump" style="animation-delay: 0.2s;">
        <img src="../assets/imgs/bleuSmile.png" class="w-12 h-12 md:w-24 md:h-24 animate-jump" style="animation-delay: 0.4s;">
        <img src="../assets/imgs/vertSmile.png" class="w-12 h-12 md:w-24 md:h-24 animate-jump" style="animation-delay: 0.6s;">
    </div>
</section>

<section class="w-full flex justify-center px-2 md:px-4 pb-20 relative">
    <div class="w-full max-w-[98%] md:max-w-3xl bg-[#FCC822]/5 border-[1.5px] md:border-2 border-black rounded-[20px] md:rounded-[25px] p-6 md:p-16 shadow-sm backdrop-blur-sm relative z-10">

        <div class="text-center mb-8 md:mb-10">
            <h2 class="text-2xl md:text-4xl font-bold font-baskerville">
                <span class="text-[#33658A]">Qui</span><span class="text-[#FCC822]">Zena</span>
            </h2>
        </div>

        <form action="../process/login_process.php" method="POST" class="flex flex-col items-center w-full">
            <div class="relative w-full max-w-lg mb-8">
                <input type="text" name="pseudo" placeholder="Entrez votre pseudo"
                    class="w-full pl-5 pr-12 py-3 md:py-4 bg-white border border-[#33658A] rounded-xl md:rounded-[15px] text-lg md:text-xl outline-none font-baskerville font-bold shadow-sm">
                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 scale-75 md:scale-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 md:h-8 md:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </span>
            </div>

            <div class="flex flex-col md:flex-row gap-4 md:gap-6 w-full max-w-lg mb-8 md:mb-12">
                <button type="submit" class="w-full md:flex-1 bg-[#FCC822] text-black font-bold py-3 md:py-4 rounded-full border border-black transition-all active:scale-95">
                    Me reconnecter
                </button>
                <button type="submit" class="w-full md:flex-1 bg-[#FCC822]/30 text-black font-bold py-3 md:py-4 rounded-full border border-black transition-all active:scale-95">
                    M'inscrire
                </button>
            </div>
        </form>

        <div class="flex flex-col items-center mt-4">
            <a href="#" class="text-xl md:text-2xl font-normal text-black mb-2 hover:underline">Pseudo oublié?</a>
            <div class="w-40 md:w-56 h-px bg-black opacity-60"></div>
        </div>
    </div>

    <div class="absolute -bottom-36 left-4 md:right-20 lg:right-40 z-10 hidden sm:block">
        <img src="../assets/imgs/Personnes.png" class="w-64 md:w-80 lg:w-88 object-contain">
    </div>
</section>


</body>
</main>

</html>