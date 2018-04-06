<!DOCTYPE html>
<?php 
  include "../kobling.php"; 
  $altVirker = true;
  $error = '';

?>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="../stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
  </head>
  <body>
    <main>
    <div class="container">
      <div class="nav">
        <a href="../index.php" class="btn">Hjem</a>
        <a href="../overnatting.php" class="btn">Overnatting</a>
        <a href="../reisedit.php" class="btn">Reise dit</a>
        <a href="../attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="../about.php>" class="btn">Om oss</a>
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
        <label for="navn">Navn på overnatting</label>
        <input type="text" name="navn" id="navn">

        <label for="pris">pris</label>
        <input type="number" name="pris" id="pris">

        <label for="stjerne">Stjerner</label>
        <select name="stjerne" id="stjerne">
            <?php
                $sql = "SELECT * FROM stjerner";
                $resultat = $kobling->query($sql);

                while ($rad = $resultat -> fetch_assoc()) {
                  $stjerner = $rad["stjerner"];

                  echo '<option value="'.$stjerner.'">'.$stjerner.'</option>';
                }
            ?>
        </select>
      </form>
    </div>
    </main>
  </body>
</html>
