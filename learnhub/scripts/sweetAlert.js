function alertTeam(imgUrl, name, age, school){
    Swal.fire({
        title: `${name}`,
        html: `${school}</br>Alter: ${age}`,
        imageUrl: `./img/personen/${imgUrl}.jpg`,
        imageWidth: 200,
        imageHeight: 200,
        showCloseButton: true,
        showConfirmButton: false
      });
}

function alertExam(Chapter){
  Swal.fire({
    title: `Prüfungsmodus`,
    html: `<p>Aufgaben müssen in einer vorgegebenen Zeit gelöst werden -> Lösungen und Lösungswege erfährt man erst danach.</p>`,
    imageUrl: `../img/content/prüfen.png`,
    imageWidth: 200,
    imageHeight: 200,
    showCloseButton: true,
    showConfirmButton: true
  });
}