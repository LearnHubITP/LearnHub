<?php

require "../learnhub/php/connectToDB.php";

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $image = $conn->real_escape_string($_POST["image"]);
    $subject = $conn->real_escape_string($_POST["subjectName"]);

    $getImageStatement = "SELECT id from images 
                            WHERE path LIKE './img/uploadedImages/$image'";
    $imageResult = $conn->query($getImageStatement);

    if ($imageResult === FALSE || $imageResult->num_rows == 0) {
        echo "Image not found";
        include("addSubject.html");
        exit;
    }

    $imageRow = $imageResult->fetch_assoc();
    $imageId = $imageRow['id'];

    # Statement for inserting values into new subject
    $insertStatement= "INSERT INTO subjects (name, image)
                VALUES ('$subject', '$imageId');";

    if($_res = $conn->query($insertStatement)){
        echo "<br>Subject $subject has been added to the database.";
        include("addSubject.html");
    }
    else{
        echo "<br> Something went wrong";
        include("addSubject.html");
    }
}
else{
    include("addSubject.html");
}
