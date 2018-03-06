<?php
  $tjener = 'localhost';
  $brukernavn = "root";
  $passord = "";
  $database = "mydb";

  $kobling = new mysqli($tjener, $brukernavn, $passord, $database);

  if ($kobling->connect_error){
    die("noe gikk galt:".$kobling->connect_error);
  }
  else {
    $kobling->set_charset("utf8");
  }

 ?>
