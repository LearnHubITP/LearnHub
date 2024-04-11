<?php
$target_dir = "../learnhub/img/uploadedImages/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

error_reporting(E_ALL);
ini_set('display_errors', 1);

$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if (isset($_POST["submit"])) {
    $allowed_types = array("image/jpeg", "image/png", "image/gif", "application/pdf");
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    $file_type = $_FILES["fileToUpload"]["type"];
    if ($check !== false || in_array($file_type, $allowed_types)) {
        if (in_array($file_type, $allowed_types)) {
            echo "File is valid - " . $file_type . ".";
        } else {
            echo "File is an image - " . $check["mime"] . ".";
        }
        $uploadOk = 1;
    } else {
        echo "File is not an image or PDF.";
        $uploadOk = 0;
    }
}

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if (
    $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif"
) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
        require "connectToDB.php";

        $insertStatement = "INSERT INTO images (path) VALUES ('./img/uploadedImages/" . basename($_FILES["fileToUpload"]["name"]) . "');";
        if ($_res = $conn->query($insertStatement)) {
            echo "<br>Image $target_file has been added to the database.";
        } else {
            echo "<br>NO insertion into database";
        }
        # close database
        $conn->close();
    }
    else{
        echo "<br>Error Moving File";
    }
}
include("uploadImage.html");