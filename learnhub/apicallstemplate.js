


// get year

fetch("./php/api/api.php?year=")   // + yearname, if you want a specific year
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });


// get subject

fetch("./php/api/api.php?subject=")   // + subjectname, if you want a specific subject
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });

// get chapter
// /chapters/subjectName/yearName/chapterName -> "" for all chapters of this subject and year
fetch("./php/api/api.php?subject=Mathe&year=1&chapter=")   // + chaptername, if you want a specific chapter
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });


// get note

fetch("./php/api/api.php?chapter=Funktionen&note=")   //without specifying note
    .then((response) => response.json())
    .then((data) => {
        console.log(data);
    })
    .catch((error) => {
        console.log(error);
    });