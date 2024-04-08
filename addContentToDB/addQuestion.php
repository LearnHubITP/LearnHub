<?php

require "connectToDB.php";


error_reporting(E_ALL);
ini_set('display_errors', 1);

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $subject = $conn->real_escape_string($_POST["subject"]);
    $chapter = $conn->real_escape_string($_POST["chapter"]);
    $image = $conn->real_escape_string($_POST["image"]);
    $question = $conn->real_escape_string($_POST["question"]);
    $answer = $conn->real_escape_string($_POST["answer"]);
    $multipleChoice = 0;

    if(isset($_POST["multiple"])){
        $multipleChoice = 1;
    }

    # Statement for getting ids of the values
    $getSubjectStatement = "SELECT id from subjects 
                WHERE name LIKE '$subject'
                LIMIT 1";
    $subjectId = $conn->query($getSubjectStatement);

    if ($subjectId == FALSE){
        echo "Subject not found";
        include("addQuestion.html");
        exit;
    }

    $getChapterStatement = "SELECT id from chapters 
                WHERE name LIKE '$chapter'";
    $chapterId = $conn->query($getChapterStatement);

    if($chapterId == FALSE){
        echo "Chapter not found";
        include("addQuestion.html");
        exit;
    }

    $getImageStatement = "SELECT id from images 
                WHERE path LIKE './img/uploadedImages/$image'";
    $imageId = $conn->query($getImageStatement);

    if($imageId == FALSE){
        echo "Image not found";
        include("addQuestion.html");
        exit;
    }

    # Statement for inserting values into new question
    $insertStatement= "INSERT INTO questions (subject, chapter, question, answer, image, multipleChoise)
                VALUES ('$subjectId', '$chapterId'
                        '$question', '$answer', 
                        '$imageId', '$multipleChoice');";

    if($_res = $conn->query($insertStatement)){
        echo "<br>Question has been added to the database.";
        include("addQuestion.html");
    }
    else{
        echo "<br> Something went wrong";
        include("addQuestion.html");
    }
}
else{
    include("addQuestion.html");
}
