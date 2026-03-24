// Aggiungi questo all'inizio per il calcolo del tempo (opzionale)
let startTime = Date.now();

document.querySelectorAll(".answer-btn").forEach((button) => {
  button.addEventListener("click", function () {
    // BLOCCO CLICK: Evita che l'utente clicchi più risposte insieme
    document
      .querySelectorAll(".answer-btn")
      .forEach((btn) => (btn.style.pointerEvents = "none"));

    let answerId = this.dataset.answerId;
    let timeTaken = Math.floor((Date.now() - startTime) / 1000);

    fetch("/quizena/process/api/ajax_quiz_questions.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        answer_id: answerId,
        time_taken: timeTaken, // Passiamo il tempo se vuoi usarlo
      }),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.isCorrect) {
          this.style.backgroundColor = "#4ADE80"; // Verde smeraldo
          this.style.color = "white";
        } else {
          this.style.backgroundColor = "#F87171"; // Rosso corallo
          this.style.color = "white";
        }

        setTimeout(() => {
          if (data.isFinished) {
            // !!! IMPORTANTE !!!
            // Vai al file PROCESS per salvare nel database, non alla pagina finale
            window.location.href = "/quizena/process/save_score.php";
          } else {
            location.reload();
          }
        }, 1000);
      });
  });
});


