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

        <?php
            include_once 'kobling.php';

            if (isset($_GET["id"])) {
                $id = $_GET["id"];
                $sql = "SELECT bilde FROM mydb.attraksjon_bilder where attraksjon_nummer = $id;";
                $resultat = $kobling->query($sql);
                $n = 0;
                echo "<div id='slideshow'>";
                echo '<div class="arrow-left" onclick="slideVenstre()"></div>';
                echo '<div class="arrow-right" onclick="slideHoyre()"></div>';
                echo "<div class='alleSlides'>";
                while ($rad = $resultat->fetch_assoc()){
                    $bilde = $rad["bilde"]; //bilde
                    $left= 100*$n;
                    $n ++;

                    echo "<div class='slide' style='left: {$left}%;'><img src='$bilde' alt='bilde av overnatting'></div>";
                }
                echo "</div></div>";

                //skriv html for resten under her.
        ?>
        <?php
            }else {
                die("Du må velge et overnattingssted.");
            }
        ?>



        <div class="footer">
            <p>NYC-Reise &trade;</p>
        </div>
    </div>

    <script src="js/slideshow.js"></script>
  </body>
</html>
