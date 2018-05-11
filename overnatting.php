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
        height: 350px;
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
      <div class="nav">
        <a href="index.php" class="btn">Hjem</a>
        <a href="overnatting.php" class="btn">Overnatting</a>
        <a href="reisedit.php" class="btn">Reise dit</a>
        <a href="attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="spisested.php" class="btn">Spisesteder</a>
        <a href="about.php" class="btn">Om oss</a>
        <a href="admin/adminindex.php" class="btn">Admin</a>
      </div>
      <?php 
        include_once("kobling.php");

        $sorter = isset($_GET["sorter"]) ? $_GET["sorter"] : "navn ASC";
        $sorter = mysqli_real_escape_string($kobling, $sorter);
      ?>

      <h1>Våre utvalgte hoteller i New York.</h1>
      <p>Sorter etter
        <form action="" method="get">
          <div class="col">
          <select name="sorter" id="sorter">
            <option value="navn ASC" <?php if($sorter == "navn ASC") { echo "selected"; } ?>>Navn stigende</option>
            <option value="navn DESC" <?php if($sorter == "navn DESC") { echo "selected"; } ?>>Navn synkende</option>

            <option value="pris ASC" <?php if($sorter == "pris ASC") { echo "selected"; } ?>>Pris stigende</option>
            <option value="pris DESC" <?php if($sorter == "pris DESC") { echo "selected"; } ?>>Pris synkende</option>

            <option value="stjerner ASC" <?php if($sorter == "stjerner ASC") { echo "selected"; } ?>>Stjerner stigende</option>
            <option value="stjerner DESC" <?php if($sorter == "stjerner DESC") { echo "selected"; } ?>>Stjerner synkende</option>
          </select>
          <input type="submit" value="sorter" class="btn">
          </div>
        </form>
      </p>
      <?php
        $sql = "SELECT * FROM mydb.overnatting_bilder group by id ORDER BY $sorter;";
        $resultat = $kobling->query($sql);
        
          while($rad = $resultat->fetch_assoc()) {
              $id = $rad["id"];
              $bildelink = $rad["bilde"];
              $navn = $rad["navn"];
              $bydel = $rad["bydel"];
              $stjerner = $rad["stjerner"];
              $beskrivelse = $rad["beskrivelse"];
              $pris = $rad["pris"];
              $adresse = $rad["addresse"];
              $gatenr = $rad["gatenr"];

              
              $reg = "SELECT ROUND(AVG(idrangering), 2) as gjen FROM mydb.tips_overnatting where overnatting_idovernatting = {$id};";
              $gjen = $kobling->query($reg)->fetch_assoc()["gjen"];

      ?> 
      <div class="overnatting">
        <div class="overnattingbox">
          <?php 
            echo "<a class='overLenke' href='overnattingDetalje.php?id=$id'></a>"
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
            echo "$adresse $gatenr, $bydel";
          ?>
         </div> 
        <div class="overnattingstjerner">
          <?php
            echo "$stjerner stjerner";
          ?>
        </div>
        <div class="overnattingstjerner">
          <?php
            echo "<br>$pris kr pr. natt";
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
  </body>
</html>
