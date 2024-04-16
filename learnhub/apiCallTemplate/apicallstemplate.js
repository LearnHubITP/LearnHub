


// get year

fetch("../php/api/years/")   // + yearname, if you want a specific year
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });


// get subject

fetch("../php/api/subjects/")   // + subjectname, if you want a specific subject
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });

// get chapter
// /chapters/subjectName/yearName/chapterName -> "" for all chapters of this subject and year
fetch("../php/api/chapters/Mathe/1. Jahrgang/")   // + chaptername, if you want a specific chapter
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });


// get note

fetch("../php/api/Funktionen/")   
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });