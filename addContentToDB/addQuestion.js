let multipleChoiceBox = document.getElementById("multipleChoiceBox");
let addBox = document.getElementById("+");
let inputs = [];

function showMultiples(element){
    if(element.checked){
        multipleChoiceBox.style.display = "block";
        addBox.style.display = "block";
    }
    else{
        multipleChoiceBox.style.display = "none";
        addBox.style.display = "none";
    }
}

let currentMultipleId = 2;
function addMultipleChoice(){
    event.preventDefault();
    inputs = []
    for (let i = 1; i < currentMultipleId; i++) {
        let element = document.getElementById(("multipleInp"+i));
        if(element != null && element.value != undefined){
            inputs.push(element.value);
        }
        else if(element != null && element.value == undefined){
            inputs.push("");
        }
    }

    multipleChoiceBox.innerHTML += `
        <div style="display: flex;  margin-top: 0.5%;" id="multiple${currentMultipleId}">
            <input type="text" name="multipleChoice[]" id="multipleInp${currentMultipleId}"></input>
            <p style="margin: 0 2%; cursor: pointer;"  onclick="deleteChoice(${currentMultipleId})">Delete</p>
        </div>
        `
    console.log(inputs)
    let currentArrayIndex = 0;
    for (let i = 1; i < currentMultipleId; i++) {
        let element = document.getElementById(("multipleInp"+i));
        if(element != null){
            element.value = inputs[currentArrayIndex];
            currentArrayIndex++;
        }
    }

    currentMultipleId++;
}

function deleteChoice(id){
    document.getElementById("multiple"+id).innerHTML = "";
    document.getElementById("multiple"+id).style.display = "none";
}