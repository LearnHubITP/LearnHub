let form = document.getElementById("form");
let inputs = [];

let currentMultipleId = 1;
function addMultipleChoice(){
    event.preventDefault();
    for (let i = 1; i < currentMultipleId; i++) {
        inputs = []
        let element = document.getElementById("multipleInp"+(i));
        if(element != null && element.value != undefined){
            inputs.push(element.value);
        }
        else if(element != null && element.value == undefined){
            inputs.push("");
        }
    }

    form.innerHTML += `
        <div style="display: flex" id="multiple${currentMultipleId}">
            <input type="text" name="multipleChoice[]" id="multipleInp${currentMultipleId}"></input>
            <p style="margin: 0" onclick="deleteChoice(${currentMultipleId})">Delete</p>
        </div>
        `
    currentMultipleId++;

    console.log(inputs)
    let currentArrayIndex = 0;
    for (let i = 0; i < currentMultipleId-1; i++) {
        let element = document.getElementById("multiple"+(i+1));
        if(element != null){
            element.value = inputs[currentArrayIndex];
        }
    }
}

function deleteChoice(id){
    document.getElementById("multiple"+id).innerHTML = "";
    choice.parentNode.removeChild(choice);
}