<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Besøksstatistikk</title>
  </head>
  <body>
    <h1>Beskøksstatistikk</h1>
    <h2>10 siste besøk:</h2>

    <?php
      require_once('kobling.php');

      $sql = "SELECT * FROM logglinje order by tidsstempel DESC LIMIT 10";

      $resultat = $kobling->query($sql);

      echo "<table border = 1>";
      echo "<tr>";
      echo "<th>tidsstempel</th>";
      echo "<th>webside</th>";
      echo "<th>ipadresse</th>";
      echo "<th>maskinadresse</th>";
      echo "</tr>";

      while ($rad = $resultat -> fetch_assoc()) {
        $tidsstempel = $rad["tidsstempel"];
        $webside = $rad["webside"];
        $ipaddresse = $rad["ipadresse"];
        $maskinadresse = $rad["maskinadresse"];
        echo "<tr>";
        echo "<td>$tidsstempel</td>";
        echo "<td>$webside</td>";
        echo "<td>$ipaddresse</td>";
        echo "<td>$maskinadresse</td>";
        echo "</tr>";
      }

      echo "</table>";

      $sql = "SELECT webside, count(*) as antall, count(*)/(select count(*) FROM logglinje WHERE webside is not null) as faktor
      FROM logglinje WHERE webside is not null GROUP BY webside ORDER BY antall DESC";

      $resultat = $kobling->query($sql);
      echo "<h2>Mest populær</h2>";

      echo "<table border = 1>";
      echo "<tr>";
      echo "<th>webside</th>";
      echo "<th>antall</th>";
      echo "<th>graf</th>";
      echo "</tr>";

      while ($rad = $resultat -> fetch_assoc()) {
        $webside = $rad["webside"];
        $antall = $rad["antall"];
        $faktor = $rad["faktor"];
        $faktor = $faktor * 250;
        echo "<tr>";
        echo "<td>$webside</td>";
        echo "<td>$antall</td>";
        echo "<td><img src='boks.jpg' width='$faktor' height='15' alt='graf'> </td>";
        echo "</tr>";
      }

      echo "</table>";
     ?>
  </body>
</html>
