<?php

#login data
$_db_host = "7.tcp.eu.ngrok.io:10359";
$_db_database = "learnhub";
$_db_username = "learnhub";
$_db_password = "learnhub";

error_reporting(E_ALL);
ini_set('display_errors', 1);

#open connection
$conn = mysqli_connect($_db_host, $_db_username, $_db_password, $_db_database);

#check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

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

    # Statement for inserting values into new chapter
    $insertStatement= "INSERT INTO chapters (name, subject, year)
                VALUES ('$chapterName', '$subjectId', '$year');";

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
