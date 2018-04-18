<?php
require_once('../kobling.php');
if (isset($_SERVER["HTTP_REFERER"])) {
	$webside = $_SERVER["HTTP_REFERER"] ;
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

$sql = "INSERT INTO logglinje (tidsstempel, ipadresse, webside, maskinadresse) VALUES (Now(), '$ipadresse', '$webside', '$maskinadresse')";
if ($kobling->query($sql)) {
	header("Content-type: image/jpeg"); 	/* http-respons melding til browser om å vise et jpg-bilde */
	$file = fopen("loggingbilde.jpg","r");
	while ($linje=fgets($file)) {
		echo $linje;
	}
	fclose($file);
}
?>
