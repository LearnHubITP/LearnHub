let questions;
let currentQuestionIndex = -1;
let questionsAnsweredRight = 0;

let realAnswers = [];
let givenAnswers = [];

let quizContainer = document.getElementById('quizContainer');
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
    currentQuestionIndex++;
    if(currentQuestionIndex >= questions.length){
        showResult();
        return;
    }
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

        let choices = currQuestion.choices;
        let answerStr = "";
        for (let i = 0; i < choices.length; i++) {
            answerStr += `
                <input type="radio" name="choice" id="choice${i}" value="${choices[i]}">
                <label for="choice${i}">${choices[i]}</label><br>
            `
        }
        answerContainerChoices.innerHTML = answerStr;
    } else {
        answerContainerChoices.style.display = "none";
        answerInputContainer.style.display = "flex";
    }

    answerInput.value = "";
}

function checkAnswer() {
    if(currentQuestionIndex >= questions.length) {
        return;
    }
    let currQuestion = questions[currentQuestionIndex];
    let givenAnswer = "";
    if(currQuestion.choices.length > 0) {
        givenAnswer = document.querySelector('input[name="choice"]:checked').value;
    } else if(answerInput.value != undefined){
        givenAnswer = answerInput.value;
    }

    givenAnswers.push(givenAnswer);

    fetch(`../php/api/checkAnswer.php?question=${currQuestion.id}&answer=${givenAnswer}`)  
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            if(data.response) {
                questionsAnsweredRight++;
            }
            realAnswers.push(data.answer);
            showNextQuestion();
        })
        .catch((error) => {
            console.log(error);
        });
}


function showResult(){
    let answerStr = "";
    for (let i = 0; i < questions.length; i++) {
        answerStr += `
            <h2>Aufgabe ${i+1}</h2>
            <h3>${questions[i].question}</h3>
        `
        if(questions[i].img!= null){
            answerStr += `
                <img src="${questions[i].img}" width="200px">
            `
        }
        answerStr += `
            <p>Deine Antwort: ${givenAnswers[i]}</p>
            <p>Richtige Antwort: ${realAnswers[i]}</p>
        `

        if(givenAnswers[i] == realAnswers[i]){
            answerStr += `
                <p style="color: green">Richtig!</p>
            `
        } else {
            answerStr += `
                <p style="color: red">Falsch!</p>
            `
        }
    }
    quizContainer.innerHTML = answerStr;
}