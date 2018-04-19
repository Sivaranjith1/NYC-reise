<?php
//include_once "../kobling.php";
include_once "../include/session.php";
$form ='<form action="" method="post">
        <input type="text" name="fornavn" placeholder="fornavn" required>
        <input type="text" name="etternavn" placeholder="etternavn">
        <input type="text" name="bruker" placeholder="brukernavn" required>
        <input type="password" name="pass" placeholder="passord" required>
        <input type="submit" value="submit">
      </form>';


$error = '';
$lagt_til = false;

if (isset($_POST["pass"])) {
    $fornavn = mysqli_real_escape_string($kobling, $_POST["fornavn"]);
    $fornavn = htmlspecialchars($fornavn, ENT_QUOTES, 'UTF-8');

    $etternavn = mysqli_real_escape_string($kobling, $_POST["etternavn"]);
    $etternavn = htmlspecialchars($etternavn, ENT_QUOTES, 'UTF-8');

    $bruker = mysqli_real_escape_string($kobling, $_POST["bruker"]);
    $bruker = htmlspecialchars($bruker, ENT_QUOTES, 'UTF-8');

    $pass = mysqli_real_escape_string($kobling, $_POST["pass"]);
    $pass = $bruker.$pass;

    $pid = password_hash($pass, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `mydb`.`adminbruker` (`fornavn`, `etternavn`, `brukernavn`, `passord`) 
            VALUES ('$fornavn', '$etternavn', '$bruker', '$pid');";

    if($kobling -> query($sql)) {
        $lagt_til = true;
    } else {
        $error = $kobling -> $error;
    }
}