<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="../stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      .overnattingbox {
        height: 400px;
      }
      
      select {
        padding: 8px 14px;
      }

      input[type=submit] {
        width: 40%;
      }

      input[type=submit]:hover {
        padding: 14px 20px;
      }

      form {
        width: 81%;
        display: block;
        margin: auto;
      }

      .inline{
          display: inline;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <?php 
        include_once "vanligNav.php";
        include_once("../kobling.php");

        $lagt_til = false;
        $altVirker = true;
        if(isset($_POST["slett"])) {
            $slett_id = $_POST["id"];
            $error = '';

            $sql = "DELETE FROM tips_spisested WHERE spisested_idspisested ='$slett_id'";
            if($kobling->query($sql)) {
            }else {
            $error = $kobling->error;
            $altVirker = false;
            }

            if($altVirker){
            $sql = "DELETE FROM bilde_spise WHERE spisested_idspisested ='$slett_id'";
            if($kobling->query($sql)) {
            }else {
                $error = $kobling->error;
                $altVirker = false;
            }
            }

            if($altVirker){
            $sql = "DELETE FROM spisested WHERE idspisested ='$slett_id'";
            if($kobling->query($sql)) {
                $lagt_til = true;
            }else {
                $error = $kobling->error;
                $altVirker = false;
            }
            }

        }

      ?>

      <div class="varsel">
          <?php
            if($altVirker == false){
              echo "<div class='red'><h1>";
              echo "<strong>Varsel:</strong>";
              echo $error;
              echo "</h1></div>";
            } else if($lagt_til){
              echo "<div class='green'><h1>";
              echo "Spisested ble slettet";
              echo "</h1></div>";
            }
          ?>
        </div>

      <h1>Våre utvalgte spisesteder i New York.</h1>
      <?php
        $sql = "SELECT * FROM mydb.bilde_spise JOIN spisested ON spisested_idspisested=idspisested group by idspisested ORDER BY resturant_navn ASC;";
        $resultat = $kobling->query($sql);
        
          while($rad = $resultat->fetch_assoc()) {
              $bildelink = $rad["bilde"];
              $navn = $rad["resturant_navn"];
              $beskrivelse = $rad["beskrivelse"];
              $pris = $rad["pris"];
              $adresse = $rad["addresse"];
              $gatenr = $rad["gatenr"];
              $id = $rad["idspisested"];

              $reg = "SELECT ROUND(AVG(idrangering), 2) as gjen FROM mydb.tips_spisested where spisested_idspisested = {$id};";
              $gjen = $kobling->query($reg)->fetch_assoc()["gjen"];

      ?> 
      <div class="overnatting">
        <div class="overnattingbox">
          <?php 
            //echo "<a class='overLenke' href='overnattingDetalje.php?id=$id'></a>"
          ?>
        <div class="overnattingbilde">
          <?php 
            echo "<img src='../$bildelink' height='200px' width='300px'>";
          ?>
        </div>
        <div class="overnattingnavn">
          <?php
            echo "$navn";
          ?>
        </div>
        <div class="overnattingadresse">
          <?php
            echo "$adresse $gatenr";
          ?>
         </div> 
        <div class="overnattingstjerner">
          <?php
            echo "<br>$pris kr";
          ?>
        </div>
        <div class="overnattingstjerner">
          <?php
            if($gjen){
              echo "<br>Brukerrangering $gjen<span class='fa fa-star checked'></span>";
            }
          ?>
        </div>
        <div class="overnattingstjerner">
          <?php
            echo "<form method='POST' class='inline'>
            <input type='hidden' name='id' value='{$id}'>
            <input type='submit' style='z-index: 90;' value='slett' name='slett'>
            </form>
            <form method='GET' action='spisestedEndre.php' class='inline'>
            <input type='hidden' name='id' value='{$id}'>
            <input type='submit' style='z-index: 90;' value='endre' name='endre'>
            </form>";
          ?>
        </div>
        </div>
      </div>

      <?php      
        }
      ?>

      <div class="footer">
       <p>NYC-Reise &trade;</p>
      </div>

    </div>
  </body>
</html>
