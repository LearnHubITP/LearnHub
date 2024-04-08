<?php

require "connectToDB.php";

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $subject = $conn->real_escape_string($_POST["subjectName"]);

    # Statement for inserting values into new subject
    $insertStatement= "INSERT INTO subjects (name)
                VALUES ('$subject');";

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
