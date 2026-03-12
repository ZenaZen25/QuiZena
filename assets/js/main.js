/**
 * assets/js/main.js
 */
let questions = [];
let current = 0;
let score = 0;

// Elementi del Timer
let timer = 20;
let interval;
const timerText = document.getElementById("timer-text");
const timerCircle = document.getElementById("timer-circle");
const circumference = 213; // Calcolato per r=34

document.addEventListener("DOMContentLoaded", () => {
    const bridge = document.getElementById("quiz-data-bridge");

    if (bridge && bridge.dataset.quiz) {
        try {
            questions = JSON.parse(bridge.dataset.quiz);
            if (questions.length > 0) {
                document.getElementById("total-questions").innerText = questions.length;
                showQuestion();
            } else {
                document.getElementById("question-text").innerText = "Nessuna domanda trovata.";
            }
        } catch (e) {
            console.error("Errore nel parsing dei dati:", e);
        }
    }
});

function showQuestion() {
    // 1. Reset e avvio Timer
    clearInterval(interval);
    timer = 20;
    updateTimerUI();
    interval = setInterval(handleTimer, 1000);

    const q = questions[current];

    // 2. AGGIORNAMENTO DINAMICO CATEGORIA E ICONA
    const categoryName = document.getElementById("category-name");
    const categoryIcon = document.getElementById("category-icon");

    if (q.category) {
        categoryName.innerText = q.category;
        
        // Cambia l'icona in base al testo della categoria
        const cat = q.category.toLowerCase();
        if (cat.includes('scien')) {
            categoryIcon.innerText = "🔬";
        } else if (cat.includes('hist') || cat.includes('storia')) {
            categoryIcon.innerText = "📜";
        } else if (cat.includes('geo')) {
            categoryIcon.innerText = "🌍";
        } else {
            categoryIcon.innerText = "🧠"; // Icona di default
        }
    }

    // 3. Aggiornamento Testi e Progress Bar
    document.getElementById("current-number").innerText = current + 1;
    document.getElementById("question-text").innerText = q.text;
    document.getElementById("next-btn").classList.add("hidden");

    const progress = (current / questions.length) * 100;
    document.getElementById("progress-bar").style.width = `${progress}%`;

    // 4. Generazione Risposte
    const grid = document.getElementById("answers-grid");
    grid.innerHTML = "";

    q.answers.forEach(ans => {
        const btn = document.createElement("button");
        btn.className = "p-5 bg-white rounded-2xl shadow border-[3px] border-[#B8D1E1] text-xl hover:scale-105 transition text-[#2D3436] font-bold text-left w-full";
        btn.innerText = ans.text;

        btn.onclick = () => {
            clearInterval(interval);
            grid.querySelectorAll('button').forEach(b => b.disabled = true);

            // Verifica correttezza (ans.is_correct)
            if (parseInt(ans.is_correct) === 1) {
                btn.classList.replace("border-[#B8D1E1]", "border-green-500");
                btn.classList.add("bg-green-100");
                score++;
            } else {
                btn.classList.replace("border-[#B8D1E1]", "border-red-500");
                btn.classList.add("bg-red-100");
                highlightCorrect(grid, q.answers);
            }
            document.getElementById("next-btn").classList.remove("hidden");
        };
        grid.appendChild(btn);
    });
}

function highlightCorrect(grid, answers) {
    const buttons = grid.querySelectorAll('button');
    answers.forEach((ans, index) => {
        if (ans.is_correct === 1) {
            buttons[index].classList.replace("border-[#B8D1E1]", "border-green-500");
            buttons[index].classList.add("bg-green-50");
        }
    });
}

function handleTimer() {
    timer--;
    updateTimerUI();
    if (timer <= 0) {
        clearInterval(interval);
        document.getElementById("answers-grid").querySelectorAll('button').forEach(b => b.disabled = true);
        document.getElementById("next-btn").classList.remove("hidden");
    }
}

function updateTimerUI() {
    if (timerText) timerText.innerText = timer;
    if (timerCircle) {
        const offset = circumference - (timer / 20) * circumference;
        timerCircle.style.strokeDashoffset = offset;
    }
}

document.getElementById("next-btn").onclick = () => {
    current++;
    if (current < questions.length) {
        showQuestion();
    } else {
        finishQuiz();
    }
};

function finishQuiz() {
    // Fermiamo il timer
    clearInterval(interval);
    
    // Prendiamo gli elementi dalla pagina (quelli che hai messo nel front)
    const resultScreen = document.getElementById("result-screen");
    const finalScoreText = document.getElementById("final-score");

    if (resultScreen && finalScoreText) {
        // Inseriamo il punteggio nel testo
        finalScoreText.innerText = `${score} / ${questions.length}`;
        
        // Togliamo la classe 'hidden' per far apparire la div
        resultScreen.classList.remove("hidden");
    } else {
        // Backup di sicurezza se la div non esiste nel front
        alert(`Quiz Terminé! Score: ${score} / ${questions.length}`);
    }
}