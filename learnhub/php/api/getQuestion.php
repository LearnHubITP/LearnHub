<?php
require "../connectToDB.php";

// DEFAULT ANSWER
$answer = array(
    "code" => 404,
    "result" => []
);

// GET QUESTIONS FOR CHAPTER NAME
if (isset($_GET["chapter"])){

    $sqlStatement = "SELECT * FROM chapters WHERE name = '" . $_GET["chapter"] . "'";
    if($res =$conn->query($sqlStatement)){
        if($res->num_rows > 0){

            $answer["code"] = 200;
            $chapter = $res->fetch_assoc();
            $chapterId = $chapter["id"];
            
            $sqlStatement = "SELECT * FROM questions WHERE chapter = '$chapterId'";
            if($res =$conn->query($sqlStatement)){
                if($res->num_rows > 0){

                    while($question = $res->fetch_assoc()){
                        $imageId = $question["image"];

                        $sqlStatement = "SELECT * FROM images WHERE id = '$imageId'";
                        if($imageId != null && $res2 =$conn->query($sqlStatement)){
                            if($res2->num_rows > 0){
                                
                                $image = $res2->fetch_assoc();
                                $imagePath = $image["path"];
                                $question["image"] = $imagePath;

                            }
                        } 
                        
                        $choices = [];
                        if($question["multipleChoice"] != 0){
                            $sqlStatement = "SELECT * FROM choices WHERE question = " . $question["id"];
                            if($res2 =$conn->query($sqlStatement)){
                                if($res2->num_rows > 0){
                                    
                                    while($choice = $res2->fetch_assoc()){
                                        array_push($choices, $choice["choice"]);
                                    }

                                }
                            }
                        }
                        $question["choices"] = $choices; 

                        array_push(
                            $answer["result"], 
                            $question
                        );
                        echo json_encode($answer);

                    }

                }
            }

        }
    }
}

echo json_encode($answer);