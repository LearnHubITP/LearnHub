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
