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
          include_once "kobling.php";
          //konf
          $offset = 5; //er også limiten

          //total
          $totalSql = 'SELECT COUNT(*) totalt FROM (SELECT count(*) tot FROM mydb.attraksjon_kat group by id) src;';
          $totalt = $kobling->query($totalSql) -> fetch_assoc() ["totalt"];
          echo "<div id='totalt'>{$totalt}</div>";
          echo "<div id='offset'>{$offset}</div>";

          //select ider
          $sqlArray = '';
          $sql = "SELECT id FROM mydb.attraksjon_kat group by id ORDER BY navn LIMIT {$offset};";
          $resultat = $kobling->query($sql);
          while ($rad = $resultat -> fetch_assoc()) {
            $id = $rad["id"];
            $sqlArray = $sqlArray."'{$id}', ";
          }
          if ($sqlArray !== '') {
            $nyArray = rtrim($sqlArray,", ");
            $nyArray = "WHERE id IN (".$nyArray.")";
          } else {
            $nyArray = 'WHERE id = 0';
          }

          //selecter elementene
          $sql = "SELECT id FROM mydb.attraksjon_kat {$nyArray} ORDER BY navn";
          $resultat = $kobling->query($sql);
          while ($rad = $resultat -> fetch_assoc()) {
            $id = $rad["id"];
            echo $id.'<br>';
          }
          
        ?>

      </div>
    </main>
  </body>
</html>
