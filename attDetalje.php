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

        <div class="melding">
            <div id="text"></div>
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

                $sql = "SELECT * FROM mydb.attraksjon_kat where id={$id};";
                $resultat = $kobling->query($sql);
                $forste = true;
                $katRekke = '';
                while ($rad = $resultat->fetch_assoc()){
                    $kategori = $rad["kategori"];
                    $katRekke = $katRekke."<p>{$kategori}</p>";

                    if($forste) {
                        $forste = false;

                        $navn = $rad["Navn"];
                        $aapningstid = $rad["aapningstid"];
                        $stengetid = $rad["stengetid"];
                        $addresse = $rad["addresse"];
                        $gatenr = $rad["gatenr"] == 0 ? '' : $rad["gatenr"];
                        $beskrivelse = $rad["beskrivelse"];
                        $pris = $rad["pris"] == 0 ? 'gratis' : $rad["pris"]." kr";
                        $bydel = $rad["bydelNavn"];
                        $postnummer = $rad["postnummer"];
                        $poststed = $rad["Poststed"];

                        if ($aapningstid == '00:00:00' && $stengetid == '00:00:00') {
                            $tid = 'Alltid åpen';
                        } else {
                            $tid = "{$aapningstid} - {$stengetid}";
                        }
                    }
                }

                $sql = "SELECT * FROM mydb.tips where attraksjonsnummer = {$id};";
                $resultat = $kobling->query($sql);
                $reisetips = '';
                while ($rad = $resultat->fetch_assoc()) {
                    $tips = $rad["beskrivelse"];
                    $reisetips = $reisetips."<div class='tips'>$tips</div>";
                }

                //skriv html for resten under her.
        ?>

        <div class="info">
            <h1 class="navn"><?php echo $navn; ?></h1>
            <div class="col">
                <h3>Pris: <?php echo $pris; ?></h3>
                <h3>Åpningstid: <?php echo $tid; ?></h3>
            </div>
            <h3>Adresse: <?php echo "{$gatenr} {$addresse}, {$postnummer} {$poststed} {$bydel}"; ?></h3>
            <div class="besBoks">
                <p><?php echo $beskrivelse; ?></p>
            </div>

            <div class="space"></div>
            <div class="kats col">
                <?php echo $katRekke;?>
            </div>
        </div>

        <div class="space"></div>
        <div class="tip">
            <h2>Reisetips</h2>
            <div id="alleTips">
                <?php echo $reisetips; ?>
            </div>

            <textarea name="nyTips" id="nyTips" cols="30" rows="10" placeholder="Gi et reisetips"></textarea>
            <button class="button" onclick="sendTips('<?php echo $id;?>')">Send</button>
        </div>
        <?php
            }else {
                die("Du må velge en attraksjon.");
            }
        ?>

        <div class="space"></div>
        <div class="footer">Flere attraksjoner</div>

        <?php
            $sql = "SELECT * FROM mydb.attraksjon_kat group by id ORDER BY Rand() LIMIT 5;";
            $resultat = $kobling->query($sql);
            while($rad = $resultat ->fetch_assoc()){
                $navn = $rad["Navn"];
                $aapningstid = $rad["aapningstid"];
                $stengetid = $rad["stengetid"];
                $addresse = $rad["addresse"];
                $gatenr = $rad["gatenr"] == 0 ? '' : $rad["gatenr"];
                $beskrivelse = $rad["beskrivelse"];
                $pris = $rad["pris"];
                $bilde = $rad["bilde"];
                $bydel = $rad["bydelNavn"];
                $postnummer = $rad["postnummer"];
                $poststed = $rad["Poststed"];
                $lenk = "attDetalje.php?id={$rad['id']}";

                if ($aapningstid == '00:00:00' && $stengetid == '00:00:00') {
                    $tid = 'Alltid åpen';
                } else {
                    $tid = "{$aapningstid} - {$stengetid}";
                }

                echo "<div class='att'>
                            <a class='overLenke' href='{$lenk}'></a>
                            <div class='bilde'>
                                <img src='{$bilde}' alt='bilde av attraksjon'>
                            </div>
                            <div class='flex1'>
                                <h2>{$navn}</h2>
                                <p>Addresse: {$gatenr} {$addresse}, {$postnummer} {$poststed}</p>
                                <h4>{$bydel}</h4>
                                <p>{$tid}</p>
                            </div>
                            </div>";
            }
        ?>



        <div class="footer">
            <p>NYC-Reise &trade;</p>
        </div>
    </div>

    <script src="js/slideshow.js"></script>
    <script src="js/restTips.js"></script>
  </body>
</html>
