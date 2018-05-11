<?php

include_once("../kobling.php");

if($_SERVER['REQUEST_METHOD'] == 'GET') {

    $beskrivelse = $_GET["sok"];
    $beskrivelse = mysqli_real_escape_string($kobling, $beskrivelse);
    $beskrivelse = htmlspecialchars($beskrivelse, ENT_QUOTES, 'UTF-8');
    $json = [];

    $sql = "SELECT Navn, pris, bilde, id FROM mydb.attraksjon_kat where navn LIKE '%$beskrivelse%' OR kategori LIKE '%$beskrivelse%' group by id  LIMIT 4;";

    $resultat = $kobling->query($sql);
    while ($rad = $resultat -> fetch_assoc()) {
        $json[] = $rad;
    }

    print_r(json_encode($json));

}else{
    http_response_code(405);
}