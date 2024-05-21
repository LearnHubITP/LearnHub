chooseYear()
function chooseYear(){
    fetch("../php/api/api.php?year=")  
    .then((response) => response.json())
    .then((data) => {
        let actSubject = JSON.parse(localStorage['actSubject'])
        console.log(data);
        let html_code = ``
        html_code += `<div id="chooseYear">
                        <div id="alignYear">
                            <div id="yearContainer">
                            <div>
                            <div><h3 id="headerYearSubj">${actSubject}</h3></div>`
            for(let i = 0; i < data.result.length; i++){
                html_code += `<div onclick="saveYear(${data.result[i].name})" class="year">${data.result[i].name}. Jahrgang</div>`
            }
                                
        html_code +=         `</div>
        </div>
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
    window.open('../contentOutputHTML/outp.html', '_self');
}