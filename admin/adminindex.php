<?php 
  include_once "../kobling.php";
  //include_once "../include/session.php";
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="../stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
  </head>
  <body>

      <div class="container">
      <div class="nav">
        <a href="../index.php" class="btn">Tilbake</a>

        <div class="btn dropdown"><span>Attraksjon</span>
          <div class="dropdown-content">
            <a href="nyAttraksjon.php" class="btn">Legg til Attraksjon</a>
            <a href="alleAttraksjoner.php" class="btn">Endre / slett Attraksjon</a>
          </div>
        </div>

        <div class="btn dropdown"><span>Overnatting</span>
          <div class="dropdown-content">
            <a href="nyovernatting.php" class="btn">Ny Overnatting</a>
            <a href="alleAttraksjoner.php" class="btn">Endre / slett Overnatting</a>
          </div>
        </div>

        <div class="btn dropdown"><span>Spisested</span>
          <div class="dropdown-content">
            <a href="nyovernatting.php" class="btn">Ny Spisested</a>
            <a href="alleAttraksjoner.php" class="btn">Endre / slett Spisested</a>
          </div>
        </div>

        <a href="velgSlide.php" class="btn">bildefremvisning</a>
        <a href="nyAdmin.php" class="btn">Ny admin</a>
      </div>
        <div class="logo">
          <h1><u>Adminpanel</u></h1>
        </div>

        <?php

          if(isset($_POST["log"])) {
            session_unset(); 
            session_destroy(); 
          }

          include_once "../bruker/login.php";

          if(isset($_SESSION["brukernavn"])){
            
            $brukernavn = $_SESSION["brukernavn"];
            $fornavn = $_SESSION["fornavn"];
            $etternavn = $_SESSION["etternavn"];
            echo "<h1>Hei $fornavn $etternavn</h1>";
            echo '<form action="" method="post"><input type="submit" value="log ut" name="log"></form>';
            $loggetInn = true;
          } else {
            
            echo "<p>Her kan du legge til og endre attraksjoner og overnattingssteder.</p>";
            $loggetInn = false;
        }
        ?>

        

      <img src="../bilder/admin.png">

        <h1>Mest populære attraksjoner</h1>

        <?php
          if($loggetInn) {
          $sql = "SELECT Navn, Lattraksjonsnummer, count(*) as antall, count(*)/(select count(*) FROM logglinje WHERE Lattraksjonsnummer != 0) as faktor
                  FROM logglinje JOIN attraksjon 
                  ON Lattraksjonsnummer = attraksjon_nummer WHERE Lattraksjonsnummer !=0 
                  GROUP BY Lattraksjonsnummer ORDER BY antall DESC;";

          $resultat = $kobling -> query($sql);

          echo "<table border = 1>";
          echo "<tr>";
          echo "<th class='tabelNavn'>Navn</th>";
          echo "<th class='antall'>Antall</th>";
          echo "<th>Graf</th>";
          echo "</tr>";
          while ($rad = $resultat -> fetch_assoc()) {
            $navn = $rad["Navn"];
            $antall = $rad["antall"];
            $faktor = $rad["faktor"];
            $faktor = $faktor * 100;

            echo "<tr>";
            echo "<td>$navn</td>";
            echo "<td>$antall</td>";
            echo "<td class='graf'><div style='width: {$faktor}%;'></div></td>";
            echo "</tr>";
          }
          echo "</table>";
        ?>

        <div class="space"></div>

        <h1>Mest populære overnattingssteder</h1>

        <?php 
          $sql = "SELECT Lidovernatting, navn, count(*) as antall, count(*)/(select count(*) FROM logglinje WHERE Lidovernatting != 0) as faktor
                  FROM logglinje JOIN overnatting 
                  ON Lidovernatting = idovernatting WHERE Lidovernatting !=0 
                  GROUP BY Lidovernatting ORDER BY antall DESC;";

          $resultat = $kobling -> query($sql);

          echo "<table border = 1>";
          echo "<tr>";
          echo "<th class='tabelNavn'>Navn</th>";
          echo "<th class='antall'>Antall</th>";
          echo "<th>Graf</th>";
          echo "</tr>";
          while ($rad = $resultat -> fetch_assoc()) {
            $navn = $rad["navn"];
            $antall = $rad["antall"];
            $faktor = $rad["faktor"];
            $faktor = $faktor * 100;

            echo "<tr>";
            echo "<td>$navn</td>";
            echo "<td>$antall</td>";
            echo "<td class='graf'><div style='width: {$faktor}%;'></div></td>";
            echo "</tr>";
          }
          echo "</table>";
        }
        ?>

      </div>
    <div class="footer">
       <p>NYC-Reise &trade;</p>
    </div>
  </body>
</html>
