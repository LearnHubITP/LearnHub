chooseChapter()

function chooseChapter(){
    let actSubject = JSON.parse(localStorage['actSubject'])
    let actYear = JSON.parse(localStorage['actYear'])
    console.log(actSubject + " " + actYear)
    fetch(`../php/api/api.php?subject=${actSubject}&year=${actYear}&chapter=`)   // + chaptername, if you want a specific chapter
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        let html_code = ``
        html_code += `<div id="chooseYear">
                        <div id="alignYear">
                            <div id="yearContainer">
                            <div>
                            <div><h3 id="headerYearSubj">${actYear}. Jahrgang: ${actSubject}</h3></div>`
            for(let i = 0; i < data.result.length; i++){
                html_code += `<div onclick="saveYear(${data.result[i].name})" class="year">${data.result[i].name}</div>`
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