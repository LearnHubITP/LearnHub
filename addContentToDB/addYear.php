<?php

require "connectToDB.php";

#Connected to database
if(!empty($_POST["submit"])){
    #get data from POST array and parse database special characters
    $year = $conn->real_escape_string($_POST["year"]);

    # Statement for inserting values into new subject
    $insertStatement= "INSERT INTO years (name)
                VALUES ('$year');";

    if($_res = $conn->query($insertStatement)){
        echo "<br>Year $year has been added to the database.";
        include("addYear.html");
    }
    else{
        echo "<br> Something went wrong";
        include("addYear.html");
    }
}
else{
    include("addYear.html");
}
