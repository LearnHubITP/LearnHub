<?php
require "../connectToDB.php";

// DEFAULT ANSWER
$answer = array(
    "code" => 404,
    "result" => false,
    "answer" => ""
);

// GET QUESTIONS FOR CHAPTER NAME
if (isset($_GET["question"]) && isset($_GET["answer"])){
    $givenAnswer = $_GET["answer"];
    $sqlStatement = "SELECT * FROM answers WHERE question = '" . $_GET["question"] . "'";
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            $actualAnswer = $res->fetch_assoc()["answer"];

            $answer["answer"] = $actualAnswer;
            if($givenAnswer == $actualAnswer){
                $answer["result"] = true;
            }

        }
    }
}

echo json_encode($answer);