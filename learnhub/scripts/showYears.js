chooseYear()
function chooseYear(){
    fetch("../php/api/api.php?year=")  
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        let html_code = ``
        html_code += `<div id="chooseYear">
                        <div id="alignYear">
                            <div id="yearContainer">`
            for(let i = 0; i < data.result.length; i++){
                html_code += `<div onclick="chooseChapter(${data.result[i].name})" class="year">${data.result[i].name}. Jahrgang</div>`
            }
                                
        html_code +=         `</div>
                        </div>
                    </div>`
        document.getElementById('contentShow').innerHTML = html_code;
        
    })
    .catch((error) => {
        console.log(error);
    });
}

// localstorage speichern, aktuelle daten

function saveYear(actYear){
    localStorage['actYear'] = JSON.stringify(actYear);
    window.open('../contentOutputHTML/chooseChapter.html', '_self');
}