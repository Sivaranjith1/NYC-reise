<?php

include_once("../kobling.php");

if($_SERVER['REQUEST_METHOD'] == 'POST') {

    $postBody = file_get_contents("php://input");
    $postBody = json_decode($postBody);
    $beskrivelse = (string)$postBody->bes;
    $beskrivelse = mysqli_real_escape_string($kobling, $beskrivelse);
    $beskrivelse = htmlspecialchars($beskrivelse, ENT_QUOTES, 'UTF-8');
    $attID = mysqli_real_escape_string($kobling, $postBody->attID);
    

    $sql = "INSERT INTO `mydb`.`tips` (`beskrivelse`, `attraksjonsnummer`) 
            VALUES ('$beskrivelse', '$attID');";

    if ($kobling->query($sql)) {
        echo json_encode(['success' => '<strong>Nytt Tips</strong> har blitt registret.', 'beskrivels' => $beskrivelse]);
        http_response_code(200);
    } else {
        $error = $kobling->error;
        echo json_encode(['error' => $error]);
        http_response_code(409);
    }


}else{
    http_response_code(405);
}