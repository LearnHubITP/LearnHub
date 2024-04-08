<?php

require "connectToDB.php";

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $chapter = $conn->real_escape_string($_POST["chapter"]);
    $image = $conn->real_escape_string($_POST["image"]);

    # Statement for getting ids of the chapter and image
    $getChapterStatement = "SELECT id from chapters 
                WHERE name LIKE '$chapter'
                LIMIT 1";
    $chapterId = $conn->query($getChapterStatement);

    if ($chapterId == FALSE){
        echo "Chapter not found";
        include("addChapter.html");
        exit;
    }

    $getImageStatement = "SELECT id from images 
                WHERE path LIKE './img/uploadedImages/$image'";
    $imageId = $conn->query($getImageStatement);

    if($imageId == FALSE){
        echo "Image not found";
        include("addChapter.html");
        exit;
    }

    # Statement for inserting values into new subject
    $insertStatement= "INSERT INTO notes (chapter, image)
                VALUES ('$chapterId', '$imageId');";

    if($_res = $conn->query($insertStatement)){
        echo "<br>Note has been added to the database.";
        include("addNote.html");
    }
    else{
        echo "<br> Something went wrong";
        include("addNote.html");
    }
}
else{
    include("addNote.html");
}
