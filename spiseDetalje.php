<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
      .overnattingbox {
        height: 327px;
      }
      
      select {
        padding: 8px 14px;
      }

      input[type=submit] {
        width: 20%;
      }

      input[type=submit]:hover {
        padding: 14px 20px;
      }

      form {
        width: 81%;
        display: block;
        margin: auto;
      }
    </style>
  </head>
  <body>
    <div class="container">
        <?php include_once "vanligNav.php"?>

        <div class="melding">
            <div id="text"></div>
        </div>

        <?php
            include_once 'kobling.php';

            if (isset($_GET["id"])) {
                $id = $_GET["id"];

                $sql = "SELECT ROUND(AVG(idrangering), 2) as gjen, count(idrangering) as antall FROM mydb.tips_spisested where spisested_idspisested = {$id};";
                $resultat = $kobling->query($sql);
                while ($rad = $resultat->fetch_assoc()) {
                    $gjenom = $rad["gjen"];
                    $antallTips = $rad["antall"];
                }
                if($gjenom){
                    $rang = "<h2>Brukerrangering: $gjenom<span class='fa fa-star checked'></span></h2><p>($antallTips anmeldelser)</p>";
                } else { $rang = ""; }


                $sql = "SELECT * FROM mydb.bilde_spise JOIN spisested ON spisested_idspisested=idspisested JOIN poststed ON spisested.poststed=postnummer Join bydel on poststed.idbydel = bydel.idbydel where idspisested = {$id} ORDER BY resturant_navn DESC;";
                $resultat = $kobling->query($sql);
                
                //$bildeArray = [];
                $forst = true;
                $n = 0;
                echo "<div id='slideshow'>";
                echo '<div class="arrow-left" onclick="slideVenstre()"></div>';
                echo '<div class="arrow-right" onclick="slideHoyre()"></div>';
                echo "<div class='alleSlides'>";
                while ($rad = $resultat->fetch_assoc()){
                    $bilde = $rad["bilde"]; //bilde
                    //$bildeArray[] = $bilde;

                    //$erActiv = $forst ? 'active' : '';
                    $left= 100*$n;
                    $n ++;

                    echo "<div class='slide' style='left: {$left}%;'><img src='$bilde' alt='bilde av spisested'></div>";

                    if($forst) {
                        $navn = $rad["resturant_navn"];
                        $pris = $rad["pris"] == 0 ? 'gratis' : $rad["pris"]." kr";
                        $addresse = $rad["addresse"];
                        $gatenr = $rad["gatenr"] == 0 ? '' : $rad["gatenr"];
                        $beskrivelse = $rad["beskrivelse"];
                        $bydel = $rad["navn"];
                        $postnummer = $rad["postnummer"];
                        $poststed = $rad["Poststed"];
                    }
                    $forst = false;
                }
                echo "</div></div>";

                //skriv html for resten under her.
        ?>

        <div class="info">
            <h1 class="navn"><?php echo $navn; ?></h1>
            <div class="col">
                <h3>Pris: <?php echo $pris; ?></h3>
            </div>
            <?php echo $rang ?>
            <h3>Adresse: <?php echo "{$gatenr} {$addresse}, {$postnummer} {$poststed} {$bydel}"; ?></h3>
            <div class="besBoks">
                <p><?php echo $beskrivelse; ?></p>
            </div>
        </div>

        <div class="space"></div>
        
        <?php
            }else {
                die("Du må velge et spisested.");
            }
        ?>
        <?php 
            $sql = "SELECT * FROM mydb.tips_spisested where spisested_idspisested = {$id};";
            $resultat = $kobling->query($sql);
            $reisetips = '';
            while ($rad = $resultat->fetch_assoc()) {
                $tips = $rad["beskrivelse"];
                $antall = $rad["idrangering"];
                $stjerneDiv = "<div class='stjernerAll'>";
                for($i = $antall; $i > 0; $i--) {
                    $stjerneDiv = $stjerneDiv."<span class='fa fa-star'></span>";
                }
                $stjerneDiv = $stjerneDiv."</div>";
                $reisetips = $reisetips."<div class='tips'><div class='flex1'>$tips</div>
                $stjerneDiv
                </div>";
            }
        ?>
        <div class="space"></div>
        <div class="tip">
            <h2>Reisetips</h2>
            <div id="alleTips">
                <?php echo $reisetips; ?>
            </div>

            <textarea name="nyTips" id="nyTips" cols="30" rows="10" placeholder="Gi et reisetips"></textarea>
            <div class="col">
                <div class="stjerner">
                    <span class="fa fa-star" onclick="stjerneTrykk(1)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(2)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(3)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(4)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(5)"></span>
                </div>
                <button class="button" onclick="sendTips('<?php echo $id;?>')">Send</button>
            </div>
        </div>

        <div class="space"></div>
        <div class="footer">Flere spisesteder</div>


        <?php

        $sql = "SELECT * FROM mydb.bilde_spise JOIN spisested ON spisested_idspisested=idspisested  where idspisested != {$id} group by idspisested ORDER BY RAND() LIMIT 3;";
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
            echo "<a class='overLenke' href='spiseDetalje.php?id=$id'></a>"
          ?>
        <div class="overnattingbilde">
          <?php 
            echo "<img src='$bildelink' height='200px' width='300px'>";
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
        </div>
      </div>
      

        <?php      
            }
        ?>

        <div class="footer">
            <p>NYC-Reise &trade;</p>
        </div>
    </div>

    <script src="js/slideshow.js"></script>
    <script src="js/restTips_spisested.js"></script>
  </body>
</html>
