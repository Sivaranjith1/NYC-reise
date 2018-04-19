<?php
    include_once "../kobling.php";
    include_once "../bruker/register.php";
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
    <main>
      <div class="container">
      <div class="nav">
        <a href="../index.php" class="btn">Hjem</a>
        <a href="../overnatting.php" class="btn">Overnatting</a>
        <a href="../reisedit.php" class="btn">Reise dit</a>
        <a href="../attraksjoner.php" class="btn">Attraksjoner</a>
        <a href="../about.php" class="btn">Om oss</a>
        <a href="../admin/adminindex.php" class="btn">Admin</a>
      </div>

        <h1>Legg til ny administrator</h1>

         <div class="varsel">
          <?php
            if($error !== ''){
              echo "<div class='red'><h1>";
              echo "<strong>Varsel:</strong>";
              echo $error;
              echo "</h1></div>";
            } else if($lagt_til){
              echo "<div class='green'><h1>";
              echo "Ny administrator lagt til";
              echo "</h1></div>";
            }
          ?>
        </div>

        <?php 
            echo $form;
        ?>
      </div>
    </main>
  </body>
</html>
