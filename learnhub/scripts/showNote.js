showNote()

function showNote(){
    let actChapter = JSON.parse(localStorage['actChapter'])
    fetch(`../php/api/api.php?chapter=${actChapter}&note=`)   
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
        // Erstelle ein <object>-Element für das PDF
        var object = document.createElement('object');
        object.data = `.${data.result[0].image}`;
        object.type = 'application/pdf';
        object.width = '100%';
        object.height = '135%';
        object.style.marginTop = "38%"

        // Füge das <object>-Element dem Container in der Webseite hinzu
        var container = document.getElementById('contentShow');
        container.style.height = '150vh'
        container.appendChild(object);
    })
    .catch((error) => {
        console.log(error);
    });
}


function openExamPopup(){
    
}