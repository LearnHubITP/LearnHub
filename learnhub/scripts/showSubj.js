const MAX_SUBJECTS_TO_SHOW = 2;
startValue = 0;
chooseSubject()
function chooseSubject(){
    fetch("./php/api/api.php?subject=")   // + subjectname, if you want a specific subject
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        console.log(data.result.length)
        //outp subjects
        let html_code = ``
        html_code += `<div id="alignShowing">
                        <div id="course">
                            <div id="gridWhatLearnhub">`
        for(let i = startValue; i < startValue + MAX_SUBJECTS_TO_SHOW; i++){
            if(i >= 0){
                if(i >= data.result.length){
                    i = 0;
                }
                html_code += `<div>
                <img src='./${data.result[i].image}' alt="" srcset="">
                <h1 style="margin-bottom: 5%;">${data.result[i].name}</h1>
                <p class="lead">
                    <a onclick="saveSubj('${data.result[i].name}') " class="learnMore3">Los geht's</a>
                </p>
            </div>`

            }
            
        }
        html_code +=    `   </div>
                        </div>
                    </div>`
        document.getElementById('contentShow').innerHTML = html_code;

    })
    .catch((error) => {
        console.log(error);
    });
    
}



// localstorage speichern, aktuelle daten

function saveSubj(actSubject){
    localStorage['actSubject'] = JSON.stringify(actSubject);
    window.open('./contentOutputHTML/chooseYear.html', '_self');
}