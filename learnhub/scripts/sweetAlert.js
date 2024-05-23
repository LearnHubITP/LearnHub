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
  // do something with alert
}