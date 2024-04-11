<?php

require "../learnhub/php/connectToDB.php";

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $subject = $conn->real_escape_string($_POST["subjectName"]);
    $year = $conn->real_escape_string($_POST["year"]);
    $chapterName = $conn->real_escape_string($_POST["chapterName"]);
    
    $subjectIdStatement = "SELECT id FROM subjects WHERE name = '$subject'";
    if($_res = $conn->query($subjectIdStatement)){
        if($_res->num_rows > 0){
            $subjectId = $_res->fetch_assoc();
            $subjectId = $subjectId["id"];
        }
        else{
            echo "Subject not found";
            include("addChapter.html");
            exit;
        }
    }
    else{
        echo "An error with the subject occurred";
        include("addChapter.html");
        exit;
    }

    $yearIdStatement = "SELECT id FROM years WHERE name = '$year'";
    if($_res = $conn->query($yearIdStatement)){
        if($_res->num_rows > 0){
            $yearId = $_res->fetch_assoc();
            $yearId = $yearId["id"];
        }
        else{
            echo "Year not found";
            include("addChapter.html");
            exit;
        }
    }
    else{
        echo "An error with the Year occurred";
        include("addChapter.html");
        exit;
    }

    # Statement for inserting values into new chapter
    $insertStatement= "INSERT INTO chapters (name, subject, year)
                VALUES ('$chapterName', '$subjectId', '$yearId');";

    if($_res = $conn->query($insertStatement)){
        echo "<br>Chapter $chapterName has been added to the database.";
        include("addChapter.html");
    }
    else{
        echo "<br> Something went wrong";
        include("addChapter.html");
    }
}
else{
    include("addChapter.html");
}
