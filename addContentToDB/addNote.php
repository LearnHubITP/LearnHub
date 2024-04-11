<?php

require "../learnhub/php/connectToDB.php";

# Connected to database
if (!empty($_POST["submit"])) {
    # Get data from POST array and parse database special characters
    $chapter = $conn->real_escape_string($_POST["chapter"]);
    $image = $conn->real_escape_string($_POST["image"]);

    # Statement for getting ids of the chapter and image
    $getChapterStatement = "SELECT id from chapters 
                            WHERE name LIKE '$chapter'
                            LIMIT 1";
    $chapterResult = $conn->query($getChapterStatement);

    if ($chapterResult === FALSE || $chapterResult->num_rows == 0) {
        echo "Chapter not found";
        include("addNote.html");
        exit;
    }

    $chapterRow = $chapterResult->fetch_assoc();
    $chapterId = $chapterRow['id'];

    $getImageStatement = "SELECT id from images 
                            WHERE path LIKE './img/uploadedImages/$image'";
    $imageResult = $conn->query($getImageStatement);

    if ($imageResult === FALSE || $imageResult->num_rows == 0) {
        echo "Image not found";
        include("addNote.html");
        exit;
    }

    $imageRow = $imageResult->fetch_assoc();
    $imageId = $imageRow['id'];

    # Statement for inserting values into new subject
    $insertStatement = "INSERT INTO notes (chapter, image)
                        VALUES ('$chapterId', '$imageId')";

    if ($conn->query($insertStatement) === TRUE) {
        echo "<br>Note has been added to the database.";
        include("addNote.html");
    } else {
        echo "<br> Something went wrong";
        include("addNote.html");
    }
} else {
    include("addNote.html");
}
?>
