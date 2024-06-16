let questions;
let currentQuestionIndex = -1;
let questionsAnsweredRight = 0;

let quizFinished = false;

let realAnswers = [];
let givenAnswers = [];

let quizContainer = document.getElementById('quizContainer');
let currentQuestion = document.getElementById('currentQuestion');
let question = document.getElementById("question");
let questionImg = document.getElementById("questionImg");
let answerInputContainer = document.getElementById("answerInputContainer");
let answerContainerChoices = document.getElementById("answerContainerChoices");
let answerInput = document.getElementById("answerInput");

let timer = document.getElementById("timer");
let minutes = document.getElementById("minutes");
let seconds = document.getElementById("seconds");

let time = 50*60;

loadQuestions();

function loadQuestions() {
    let actChapter = JSON.parse(localStorage['actChapter'])
    fetch("../php/api/getQuestion.php?chapter=" + actChapter)  
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            questions = data.result;
            updateTimerString()
            showNextQuestion() 
        })
        .catch((error) => {
            console.log(error);
        });
}

function updateTimerString(){
    if(!quizFinished){
        minutes.innerHTML = formatTimerString(Math.floor(time/60))
        seconds.innerHTML = formatTimerString(time%60)

        if(time > 0) {
            setTimeout(() => {
                time--;
                updateTimerString();
            }, 1000);   
        } else {
            let answeredQuestions = currentQuestionIndex+1;
            checkAnswer();

            for(let i=answeredQuestions; i < questions.length; i++) {
                givenAnswers.push("");
                fetch(`../php/api/checkAnswer.php?question=${questions[i].id}&answer=`)  
                    .then((response) => response.json())
                    .then((data) => {
                        console.log(data);
                        realAnswers.push(data.answer);
                        if(i == questions.length-1){
                            showResult();
                        }
                    })
                    .catch((error) => {
                        console.log(error);
                    });
                }
            }
    }
}

let meterElement = document.getElementById('exampleMeter');
let meterElement2= document.getElementById("exampleMeter2")
let k
function showNextQuestion() {
    k=100/questions.length;

    meterElement2.style.width=k*d+"%";
    currentQuestionIndex++;
    if(currentQuestionIndex >= questions.length){
        showResult();
        return;
    }
    let currQuestion = questions[currentQuestionIndex];
    currentQuestion.innerHTML = "Aufgabe "+(currentQuestionIndex+1)+" von "+questions.length;
    question.innerHTML = currQuestion.question;

    if (currQuestion.image != null){
        questionImg.src = "."+currQuestion.image;
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
let d=0;
function checkAnswer() {
    d++;
    meterElement2.style.width=k*d+"%";
    if(currentQuestionIndex >= questions.length) {
        return;
    }
    let currQuestion = questions[currentQuestionIndex];
    let givenAnswer = "";
    if(currQuestion.choices.length > 0) {
        try{
            givenAnswer = document.querySelector('input[name="choice"]:checked').value;
        } catch(e){
            givenAnswer = "";
        }
    } else if(answerInput.value != undefined){
        givenAnswer = answerInput.value;
    }

    givenAnswers.push(givenAnswer);

    fetch(`../php/api/checkAnswer.php?question=${currQuestion.id}&answer=${givenAnswer}`)  
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            realAnswers.push(data.answer);
            showNextQuestion();
        })
        .catch((error) => {
            console.log(error);
        });
}


function showResult(){
    quizFinished = true;
    let answerStr = "";
    for (let i = 0; i < questions.length; i++) {
        answerStr += `
            <h3>${i+1}) ${questions[i].question}</h3>
        `
        if(questions[i].image != null){
            answerStr += `
                <img src=".${questions[i].image}" width="30%">
            `
        }
        answerStr += `
            <p>Deine Antwort: ${givenAnswers[i]}</p>
            <p>Richtige Antwort: ${realAnswers[i]}</p>
        `

        if(givenAnswers[i] == realAnswers[i]){
            questionsAnsweredRight++;
            answerStr += `
                <p style="color: green">Richtig!</p>
            `
        } else {
            answerStr += `
                <p style="color: red">Falsch!</p>
            `
        }
    }
    let procent = questionsAnsweredRight / questions.length;
    let score = "";
    if(procent < 0.50) score = "Nicht Genügend"
    else if(procent < 0.625) score = "Genügend"
    else if(procent < 0.75) score = "Befriedigend"
    else if(procent < 0.875) score = "Gut"
    else score = "Sehr Gut"
    answerStr += `
        <p style="font-size: 1.6em; text-align: center; color: black;">Deine Punktzahl: ${Math.floor(procent*100)}% <br>
        <span style="font-size: 1.8em; color:black;">${score}</span></p>
    `
    quizContainer.innerHTML = answerStr;
}

function formatTimerString(amount){
    if (amount < 10) {
        return "0" + amount;
    } else {
        return amount;
    }
}