let answersButton = document.querySelectorAll(".answer-btn");
let elapsedTime = document.querySelector("#elapsed-time");

let timer;
let timeLeft = 20;

resetTimer();

function resetTimer() {
  console.log("HELLO");

  clearInterval(timer);
  timeLeft = 20;

  const text = document.querySelector("#timer-text");
  const circle = document.querySelector("#timer-circle");

  if (text) text.innerText = timeLeft;
  if (circle) circle.style.strokeDashoffset = 0;

  timer = setInterval(() => {
    timeLeft--;

    if (text) text.innerText = timeLeft;

    if (circle) {
      const offset = 220 - (220 * timeLeft) / 20;
      circle.style.strokeDashoffset = offset;
    }

    if (timeLeft <= 0) {
      clearInterval(timer);

      elapsedTime.classList.remove("opacity-0");

      answersButton.forEach((answerButton) => {
        answerButton.disabled = true;
      });

      let timeTaken = 20;

      fetch("/quizena/process/api/ajax_quiz_questions.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          time_elapsed: true,
          time_taken: timeTaken,
        }),
      })
        .then((res) => res.json())
        .then((data) => {
          answersButton.forEach((btn) => {
            if (btn.dataset.answerId == data.correctAnswer) {
              btn.style.backgroundColor = "#4ADE80";
              btn.style.color = "white";
            }
          });

          setTimeout(() => {
            if (data.isFinished) {
              window.location.href = "/quizena/process/save_score.php";
            } else {
              location.reload();
            }
          }, 1000);
        });
    }
  }, 1000); // ⬅️ CHIUSURA IMPORTANTE del setInterval
}