<?php

require "../learnhub/php/connectToDB.php";

error_reporting(E_ALL);
ini_set('display_errors', 1);

# Connected to database
if (!empty($_POST["submit"])) {
    # Get data from POST array and parse database special characters
    $subject = $conn->real_escape_string($_POST["subject"]);
    $chapter = $conn->real_escape_string($_POST["chapter"]);
    $image = null;
    $question = $conn->real_escape_string($_POST["question"]);
    $answer = $conn->real_escape_string($_POST["answer"]);
    $multipleChoice = 0;

    if (isset($_POST["image"]) && $_POST["image"] != "") {
        $image = $conn->real_escape_string($_POST["image"]);
    }
    if (isset($_POST["multiple"])) {
        $multipleChoice = 1;
    }

    # Statement for getting ids of the values
    $getSubjectStatement = "SELECT id FROM subjects 
                            WHERE name LIKE '$subject'
                            LIMIT 1";
    $subjectResult = $conn->query($getSubjectStatement);

    if ($subjectResult === FALSE || $subjectResult->num_rows == 0) {
        echo "Subject not found";
        include("addQuestion.html");
        exit;
    }

    $subjectRow = $subjectResult->fetch_assoc();
    $subjectId = $subjectRow['id'];

    $getChapterStatement = "SELECT id FROM chapters 
                            WHERE name LIKE '$chapter'";
    $chapterResult = $conn->query($getChapterStatement);

    if ($chapterResult === FALSE || $chapterResult->num_rows == 0) {
        echo "Chapter not found";
        include("addQuestion.html");
        exit;
    }

    $chapterRow = $chapterResult->fetch_assoc();
    $chapterId = $chapterRow['id'];

    $imageId = null;
    if ($image !== null) {
        $getImageStatement = "SELECT id FROM images 
                                WHERE path LIKE './img/uploadedImages/$image'";
        $imageResult = $conn->query($getImageStatement);

        if ($imageResult === FALSE || $imageResult->num_rows == 0) {
            echo "Image not found";
            include("addQuestion.html");
            exit;
        }

        $imageRow = $imageResult->fetch_assoc();
        $imageId = $imageRow['id'];
    }

    

    # Statement for inserting values into new question
    $insertStatement = "INSERT INTO questions (subject, chapter, question, image, multipleChoice)
                        VALUES ('$subjectId', '$chapterId', '$question', '$imageId', '$multipleChoice')";

    if ($conn->query($insertStatement) === TRUE) {
        echo "<br>Question has been added to the database.";
    } else {
        echo "<br> Something went wrong";
        include("addQuestion.html");
        exit;
    }

    $getQuestionStatement = "SELECT id FROM questions
                            WHERE question LIKE '$question'";
    $questionResult = $conn->query($getQuestionStatement);

    if ($questionResult === FALSE || $questionResult->num_rows == 0) {
        echo "Question created but not found, HUCH?? Des deaf eig ned passieren oiso ka frog in Sysadmin";
        include("addQuestion.html");
        exit;
    }

    $questionRow = $questionResult->fetch_assoc();
    $questionId = $questionRow['id'];

    # Statement for inserting values into new answer
    $insertStatement = "INSERT INTO answers (question, answer)
                        VALUES ('$questionId', '$answer')";

    if ($conn->query($insertStatement) === TRUE) {
        echo "<br>Answer has been added to the database.";
    } else {
        echo "<br> Something went wrong while adding the answer";
        include("addQuestion.html");
        exit;
    }


    # Statement fo inserting values into multiplechoice
    if ($multiple = 1) {
        foreach ($_POST["multipleChoice"] as $value) {
            $multipleChoiceValue = $conn->real_escape_string($value);
            
            $insertStatement = "INSERT INTO choices (question, choice)
                            VALUES ('$questionId', '$multipleChoiceValue')";

            if ($conn->query($insertStatement) === TRUE) {
                echo "<br>Choice " . $multipleChoiceValue . " has been added to the database.";
            } else {
                echo "<br> Something went wrong while adding the choice " . $multipleChoiceValue;
            }
        }
    }

    include("addQuestion.html");
} else {
    include("addQuestion.html");
}

