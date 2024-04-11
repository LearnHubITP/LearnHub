<?php

require "../connectToDB.php";

// DEFAULT ANSWER
$answer = array(
    "code" => 404,
    "result" => []
);

// REQUEST for ALL spells: /spells/
if (isset($_GET["id"]) && $_GET["id"] == "") {

    $sqlStatement = "SELECT * FROM subjects";

    for ($i = 0; $i < count($spellJson->spells); $i++) {
        $answer["code"] = 200;
        array_push($answer["result"], $spellJson->spells[$i]);
    }
}

// REQUEST for SINGLE spell: /spells/{id}
else if (isset($_GET["spellid"]) && filter_var($_GET["spellid"], FILTER_VALIDATE_INT) !== false && $_GET["spellid"] > 0) {
    $id = $_GET["spellid"];

    $data = file_get_contents("../data/spells.json");
    $spellJson = json_decode($data);

    if ($id <= count($spellJson->spells)) {
        $answer["code"] = 200;
        array_push($answer["result"], $spellJson->spells[$id - 1]);
    }

}

// SEND JSON
echo json_encode($answer);