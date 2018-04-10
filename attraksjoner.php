<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
  </head>
  <body>
    <main>
      <div class="container">
      <div class="nav">
        <a href="index.php" class="btn">Hjem</a>
        <a href="overnatting.php" class="btn">Overnatting</a>
        <a href="reisedit.php" class="btn">Reise dit</a>
        <a href="attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="about.php" class="btn">Om oss</a>
        <a href="admin/adminindex.php" class="btn">Admin</a>
      </div>    
        
      <h1>Ting å gjøre i New York</h1>

        <?php

          include "kobling.php";
          
          $sql = "SELECT * FROM attraksjon ORDER BY navn ASC";
          $resultat = $kobling->query($sql);

            while ($rad = $resultat->fetch_assoc()) {
              $attraksjonsnummer = $rad["attraksjon_nummer"];
              $poststed = $rad["poststed"];
              $navn = $rad["navn"];
              $aapningstid = $rad["aapningstid"];
              $stengetid = $rad["stengetid"];
              $addresse = $rad["addresse"];
              $gatenummer = $rad["gatenr"];
              $poststed_postnummer = $rad["poststed_postnummer"];
              $bilde = $rad["hovedbilde"];
              $pris = $rad["pris"];
              $beskrivelse = $rad["beskrivelse"];

            

          echo "<table>";
          echo "<tr>";
          echo "<td><img src='bilder/$bilde' alt = 'Attraksjonsbilde'></td>";
          echo "<td>$navn</td>";
          echo "<td>$adresse</td>";
          echo "<td>$poststed</td>";
          echo "</tr>";
          echo "</table>";

            }
        ?>

      </div>


    </main>
  </body>
</html>
