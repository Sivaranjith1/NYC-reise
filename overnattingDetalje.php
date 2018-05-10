<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="stilark/style.css">
    <link href='https://fonts.googleapis.com/css?family=Text Me One' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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

        <div class="melding">
            <div id="text"></div>
        </div>

        <?php
            include_once 'kobling.php';

            if (isset($_GET["id"])) {
                $id = $_GET["id"];

                $sql = "SELECT ROUND(AVG(idrangering), 2) as gjen FROM mydb.tips_overnatting where overnatting_idovernatting = {$id};";
                $resultat = $kobling->query($sql);
                while ($rad = $resultat->fetch_assoc()) {
                    $gjenom = $rad["gjen"];
                }
                if($gjenom){
                    $rang = "<h2>Brukerrangering: $gjenom<span class='fa fa-star checked'></span></h2>";
                } else { $rang = ""; }


                $sql = "SELECT * FROM mydb.overnatting_bilder where id = $id;";
                $resultat = $kobling->query($sql);
                
                //$bildeArray = [];
                $forst = true;
                $n = 0;
                echo "<div id='slideshow'>";
                echo '<div class="arrow-left" onclick="slideVenstre()"></div>';
                echo '<div class="arrow-right" onclick="slideHoyre()"></div>';
                echo "<div class='alleSlides'>";
                while ($rad = $resultat->fetch_assoc()){
                    $bilde = $rad["bilde"]; //bilde
                    //$bildeArray[] = $bilde;

                    //$erActiv = $forst ? 'active' : '';
                    $left= 100*$n;
                    $n ++;

                    echo "<div class='slide' style='left: {$left}%;'><img src='$bilde' alt='bilde av overnatting'></div>";

                    if($forst) {
                        $navn = $rad["navn"];
                        $pris = $rad["pris"] == 0 ? 'gratis' : $rad["pris"]." kr";
                        $addresse = $rad["addresse"];
                        $gatenr = $rad["gatenr"] == 0 ? '' : $rad["gatenr"];
                        $beskrivelse = $rad["beskrivelse"];
                        $stjerne = $rad["stjerner"];
                        $bydel = $rad["bydel"];
                        $postnummer = $rad["postnummer"];
                        $poststed = $rad["Poststed"];
                    }
                    $forst = false;
                }
                echo "</div></div>";

                //skriv html for resten under her.
        ?>

        <div class="info">
            <h1 class="navn"><?php echo $navn; ?></h1>
            <div class="col">
                <h3>Pris: <?php echo $pris; ?></h3>
                <h3>Stjerner: <?php echo $stjerne; ?></h3>
            </div>
            <?php echo $rang ?>
            <h3>Adresse: <?php echo "{$gatenr} {$addresse}, {$postnummer} {$poststed} {$bydel}"; ?></h3>
            <div class="besBoks">
                <p><?php echo $beskrivelse; ?></p>
            </div>
        </div>


        <?php 
            $sql = "SELECT * FROM mydb.tips_overnatting where overnatting_idovernatting = {$id};";
            $resultat = $kobling->query($sql);
            $reisetips = '';
            while ($rad = $resultat->fetch_assoc()) {
                $tips = $rad["beskrivelse"];
                $antall = $rad["idrangering"];
                $stjerneDiv = "<div class='stjernerAll'>";
                for($i = $antall; $i > 0; $i--) {
                    $stjerneDiv = $stjerneDiv."<span class='fa fa-star'></span>";
                }
                $stjerneDiv = $stjerneDiv."</div>";
                $reisetips = $reisetips."<div class='tips'><div class='flex1'>$tips</div>
                $stjerneDiv
                </div>";
            }
        ?>
        <div class="space"></div>
        <div class="tip">
            <h2>Reisetips</h2>
            <div id="alleTips">
                <?php echo $reisetips; ?>
            </div>

            <textarea name="nyTips" id="nyTips" cols="30" rows="10" placeholder="Gi et reisetips"></textarea>
            <div class="col">
                <div class="stjerner">
                    <span class="fa fa-star" onclick="stjerneTrykk(1)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(2)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(3)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(4)"></span>
                    <span class="fa fa-star" onclick="stjerneTrykk(5)"></span>
                </div>
                <button class="button" onclick="sendTips('<?php echo $id;?>')">Send</button>
            </div>
        </div>

        <div class="space"></div>
        <div class="footer">Flere overnattingsteder</div>
        <?php
            }else {
                die("Du må velge et overnattingssted.");
            }
        ?>


        <?php
            $sql = "SELECT * FROM mydb.overnatting_bilder group by id ORDER BY RAND() LIMIT 3;";
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

        <?php
            include_once "include/loggingbilde.php";
        ?>
    </div>

    <script src="js/slideshow.js"></script>
    <script src="js/restTips_overnatting.js"></script>
  </body>
</html>
