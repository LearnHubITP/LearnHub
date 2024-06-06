let questions;
let currentQuestionIndex = 0;

let currentQuestion = document.getElementById('currentQuestion');
let question = document.getElementById("question");
let questionImg = document.getElementById("questionImg");
let answerInputContainer = document.getElementById("answerInputContainer");
let answerContainerChoices = document.getElementById("answerContainerChoices");
let answerInput = document.getElementById("answerInput");

loadQuestions();

function loadQuestions() {
    let actChapter = JSON.parse(localStorage['actChapter'])
    fetch("../php/api/getQuestion.php?chapter=" + actChapter)  
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            questions = data.result;
            showNextQuestion() 
        })
        .catch((error) => {
            console.log(error);
        });
}


function showNextQuestion() {
    let currQuestion = questions[currentQuestionIndex];
    currentQuestion.innerHTML = "Aufgabe " + (currentQuestionIndex+1);
    question.innerHTML = currQuestion.question;

    if (currQuestion.img != null){
        questionImg.src = currQuestion.img;
        questionImg.style.display = "block";
    } else {
        questionImg.src = "";
        questionImg.style.display = "none";
    }

    if (currQuestion.choices.length > 0){
        answerInputContainer.style.display = "none";
        answerContainerChoices.style.display = "block";
    } else {
        answerContainerChoices.style.display = "none";
        answerInputContainer.style.display = "flex";
    }

    answerInput.value = "";
}