<?php

session_start();

if(isset($_SESSION["brukernavn"])){
    $brukernavn = $_SESSION["brukernavn"];
    $fornavn = $_SESSION["fornavn"];
    $etternavn = $_SESSION["etternavn"];
} else {
    header("Location: adminindex.php");
}