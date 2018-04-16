<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
  </head>
  <body>
    <div class="container">
      <div class="nav">
        <a href="index.php" class="btn">Hjem</a>
        <a href="overnatting.php" class="btn">Overnatting</a>
        <a href="reisedit.php" class="btn">Reise dit</a>
        <a href="attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="about.php" class="btn">Om oss</a>
        <a href="admin/adminindex.php" class="btn">Admin</a>
      </div>

      <h1>Våre utvalgte hoteller i New York.</h1>
      <?php
        include_once("kobling.php");

        $sql = "SELECT * FROM mydb.overnatting_bilder group by id ORDER BY stjerner DESC;";
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
