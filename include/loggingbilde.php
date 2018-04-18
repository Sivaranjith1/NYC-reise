<?php
require_once('kobling.php');
$attID = NULL;
$overnattingID = NULL;
if (isset($_SERVER['REQUEST_URI'])) {
	$webside = $_SERVER['REQUEST_URI'] ;

	$splittet = explode("?", $webside);
	$sted = $splittet[0];
	$attribut = explode("=", $splittet[1])[1];

	if(preg_match('/attDetalje/', $sted)) {
		$attID = $attribut;
	} else if (preg_match('/overnattingDetalje/', $sted)){
		$overnattingID = $attribut;
	}
} else {
	$webside = "NULL";
}
if (isset($_SERVER["REMOTE_HOST"]) ) {
	$maskinadresse = $_SERVER["REMOTE_HOST"] ;
} else {
	$maskinadresse = "NULL";
}
if (isset($_SERVER["REMOTE_ADDR"])) {
	$ipadresse = $_SERVER["REMOTE_ADDR"];
} else {
	$ipadresse = "NULL";
}

$sql = "INSERT INTO logglinje (tidsstempel, ipadresse, webside, maskinadresse, Lattraksjonsnummer, Lidovernatting) VALUES (Now(), '$ipadresse', '$webside', '$maskinadresse', '$attID', '$overnattingID')";
if ($kobling->query($sql)) {
}
?>
