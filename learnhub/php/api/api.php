<?php

require "../connectToDB.php";

// DEFAULT ANSWER
$answer = array(
    "code" => 404,
    "result" => []
);

// REQUEST FOR SUBJECTS
if (isset($_GET["subjectId"])) {
    if($_GET["subjectId"] == ""){
        $sqlStatement = "SELECT * FROM subjects";
    }
    else{
        $sqlStatement = "SELECT * FROM subjects WHERE id = " . $_GET["subjectId"];
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($subject = $res->fetch_assoc()){
                array_push($answer["result"], $subject["name"]);
            }

        }
    }
}
// REQUEST FOR YEARS
else if (isset($_GET["yearId"])) {
    if($_GET["yearId"] == ""){
        $sqlStatement = "SELECT * FROM years";
    }
    else{
        $sqlStatement = "SELECT * FROM years WHERE id = " . $_GET["yearId"];
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($year = $res->fetch_assoc()){
                array_push($answer["result"], $year["name"]);
            }

        }
    }
}
// REQUEST FOR CHAPTERS
else if (isset($_GET["chapterId"]) && isset($_GET["subject"]) && isset($_GET["year"])) {
    $sqlStatement = "SELECT * FROM subjects WHERE name = " . $_GET["subject"];
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){
            $subject = $res->fetch_assoc();
            $subjectId = $subject["id"];
        }
        else{
            echo json_encode($answer);
            exit;
        }
    }
    else{
        echo json_encode($answer);
        exit;
    }

    $sqlStatement = "SELECT * FROM years WHERE name = " . $_GET["year"];
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){
            $year = $res->fetch_assoc();
            $yearId = $year["id"];
        }
        else{
            echo json_encode($answer);
            exit;
        }
    }
    else{
        echo json_encode($answer);
        exit;
    }
    

    if($_GET["chapterId"] == ""){
        $sqlStatement = "SELECT * FROM chapters WHERE subject = 'subjectId' AND year = 'yearId'";
    }
    else{
        $sqlStatement = "SELECT * FROM chapters WHERE id = " . $_GET["chapterId"] . " AND subject = 'subjectId' AND year = 'yearId'";
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($chapter = $res->fetch_assoc()){
                array_push($answer["result"], $chapter["name"]);
            }

        }
    }
}
// REQUEST FOR NOTES
else if (isset($_GET["noteId"]) && isset($_GET["subject"]) && isset($_GET["year"])) {
    $sqlStatement = "SELECT * FROM subjects WHERE name = " . $_GET["subject"];
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){
            $subject = $res->fetch_assoc();
            $subjectId = $subject["id"];
        }
        else{
            echo json_encode($answer);
            exit;
        }
    }
    else{
        echo json_encode($answer);
        exit;
    }

    $sqlStatement = "SELECT * FROM years WHERE name = " . $_GET["year"];
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){
            $year = $res->fetch_assoc();
            $yearId = $year["id"];
        }
        else{
            echo json_encode($answer);
            exit;
        }
    }
    else{
        echo json_encode($answer);
        exit;
    }
    

    if($_GET["chapterId"] == ""){
        $sqlStatement = "SELECT * FROM chapters WHERE subject = 'subjectId' AND year = 'yearId'";
    }
    else{
        $sqlStatement = "SELECT * FROM chapters WHERE id = " . $_GET["chapterId"] . " AND subject = 'subjectId' AND year = 'yearId'";
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($chapter = $res->fetch_assoc()){
                array_push($answer["result"], $chapter["name"]);
            }

        }
    }
}


// SEND JSON
echo json_encode($answer);