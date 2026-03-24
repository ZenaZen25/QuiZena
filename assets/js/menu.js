// Aspetta che tutta la pagina sia caricata
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    // Verifichiamo che gli elementi esistano per evitare errori in console
    if (btn && menu) {
        btn.addEventListener('click', function() {
            menu.classList.toggle('hidden');
        });
    }
});


