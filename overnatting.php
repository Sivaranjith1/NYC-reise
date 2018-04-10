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
        <a href="about.php>" class="btn">Om oss</a>
        <a href="admin/adminindex.php" class="btn">Admin</a>
      </div>

      <?php
        include_once("kobling.php");

        $sql = "SELECT * FROM mydb.overnatting_bilder group by id;";
        $resultat = $kobling->query($sql);
        
          while($rad = $resultat->fetch_assoc()) {
              $bildelink = $rad["bilde"];
              $navn = $rad["navn"];
              $bydel = $rad["bydel"];
              $stjerner = $rad["stjerner"];
              $beskrivelse = $rad["beskrivelse"];
              $pris = $rad["pris"];

          echo "<table>";
          echo "<tr>";
          echo "<td><img src='$bildelink' height='200px'></td>";
          echo "<td>$navn</td>";
          echo "<td>$stjerner</td>";
          echo "</tr>";
          echo "</table>";
            
        }
      ?>

    </div>
    </main>
  </body>
</html>
