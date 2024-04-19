<?php

#login data
$_db_host = "localhost";
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
