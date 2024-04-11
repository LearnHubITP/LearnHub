<?php

require "../connectToDB.php";

// DEFAULT ANSWER
$answer = array(
    "code" => 404,
    "result" => []
);

// REQUEST FOR CHAPTERS
if (isset($_GET["chapter"]) && isset($_GET["subject"]) && isset($_GET["year"])) {
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
    

    if($_GET["chapter"] == ""){
        $sqlStatement = "SELECT * FROM chapters WHERE subject = '$subjectId' AND year = '$yearId'";
    }
    else{
        $sqlStatement = "SELECT * FROM chapters WHERE id = " . $_GET["chapter"] . " AND subject = '$subjectId' AND year = '$yearId'";
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($chapter = $res->fetch_assoc()){
                array_push($answer["result"], array("name"=>$chapter["name"]));
            }

        }
    }
}
//REQUEST FOR NOTES
else if (isset($_GET["note"]) && isset($_GET["chapter"])) {
    
    $sqlStatement = "SELECT * FROM chapters WHERE id = " . $_GET["chapter"];
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            $chapter = $res->fetch_assoc();
            $chapterName = $chapter["name"];
            $chapterId = $chapter["id"];
            
            $sqlStatement = "SELECT * FROM notes WHERE chapter = '$chapterId'";
            if($res =$conn->query($sqlStatement)){
                if($res->num_rows > 0){

                    $note = $res->fetch_assoc();
                    $imageId = $note["image"];

                    $sqlStatement = "SELECT * FROM images WHERE id = '$imageId'";
                    if($res =$conn->query($sqlStatement)){
                        if($res->num_rows > 0){
                            
                            $image = $res->fetch_assoc();
                            $imagePath = $image["path"];
                            array_push(
                                $answer["result"], 
                                array(
                                    "chapter"=>$chapterName,
                                    "image"=>$imagePath
                                )
                            );

                        }
                    }

                }
            }

        }
    }
}
// REQUEST FOR SUBJECTS
else if (isset($_GET["subject"])) {
    if($_GET["subject"] == ""){
        $sqlStatement = "SELECT * FROM subjects";
    }
    else{
        $sqlStatement = "SELECT * FROM subjects WHERE name = " . $_GET["subject"];
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($subject = $res->fetch_assoc()){
                array_push($answer["result"], array("name"=>$subject["name"]));
            }

        }
    }
}
// REQUEST FOR YEARS
else if (isset($_GET["year"])) {
    if($_GET["year"] == ""){
        $sqlStatement = "SELECT * FROM years";
    }
    else{
        $sqlStatement = "SELECT * FROM years WHERE name = " . $_GET["year"];
    }

    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            while($year = $res->fetch_assoc()){
                array_push($answer["result"], array("name"=>$year["name"]));
            }

        }
    }
}

// SEND JSON
echo json_encode($answer);