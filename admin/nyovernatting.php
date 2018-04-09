<!DOCTYPE html>
<?php 
  include "../kobling.php"; 
  $altVirker = true;
  $error = '';
  $lagt_til = false;

  if(isset($_POST["submit"])) {
    $egenPost = (isset($_POST["egenPost"]) ? true : false);
    $poststed = $_POST["poststed"];
    $addresse = $_POST["adress"];
    $gatenr = (isset($_POST["gatenr"]) ? $_POST["gatenr"] : null);
    $beskrivelse = $_POST["beskrivelse"];
    $pris = $_POST["pris"];
    $navn = $_POST["navn"];
    $stjerne = $_POST["stjerne"];


    //postadresse
    if ($egenPost) {
      $bydel = $_POST["bydel"];
      $postnum = $_POST["postnum"];
      $postst = $_POST["postst"];
      $sql = "INSERT INTO `poststed` (`postnummer`, `Poststed`, `idbydel`) 
              VALUES ('".$postnum."', '".$postst."', '".$bydel."')";

      if ($kobling->query($sql)) {
        $poststed = $kobling->insert_id;
      } else {
        $error = $kobling->error;
        $altVirker = false;
      }

    }

    //registere stjerne
    if ($altVirker && $stjerne=="egen"){
      $egenStjerne = $_POST["egenStjerne"];
      $sql = "INSERT INTO `stjerner` (`stjerner`) VALUES ('".$egenStjerne."');";

      if ($kobling->query($sql)) {
        $stjerne = $kobling->insert_id;
      } else {
        $error = $kobling->error;
        $altVirker = false;
      }
    }

    //legge til overnatting
    if($altVirker) {
      $sql = "INSERT INTO `overnatting` (`navn`, `pris`, `stjerner`, `beskrivelse`, `addresse`, `gatenr`, `poststed`)
              VALUES ('".$navn."', '".$pris."', '".$stjerne."', '".$beskrivelse."', '".$addresse."', '".$gatenr."', '".$poststed."');";

      if ($kobling->query($sql)) {
        $attID = $kobling->insert_id;
        $lagt_til = true;
      } else {
        $error = $kobling->error;
        $altVirker = false;
      }
    }

    //legg til bilde
    if ($altVirker) {
      $target_dir = "../bilder/";
      $antallBilder = count($_FILES["bilde"]["name"]);

      for($i = 0; $i < $antallBilder; $i++){
        $target_file = $target_dir . basename($_FILES["bilde"]["name"][$i]);
        $maal_plass = "bilder/" . basename($_FILES["bilde"]["name"][$i]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["bilde"]["tmp_name"][$i]);
        if($check !== false) {
            $altVirker = true;
            move_uploaded_file($_FILES["bilde"]["tmp_name"][$i], $target_file);

            $sql = "INSERT INTO `mydb`.`bilde` (`bilde`, `idovernatting`) VALUES ('".$maal_plass."', '".$attID."')";
            if ($kobling->query($sql)) {
            } else {
              $error = $kobling->error;
              $altVirker = false;
              break 1;
            }

        } else {
            $error = "filen er ikke et bilde";
            $altVirker = false;
            break 1;
        }
      }
    }
  }
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
        <a href="../about.php" class="btn">Om oss</a>
        <a href="../admin/adminindex.php" class="btn">Admin</a>
      </div>
      <div class="varsel">
        <?php
          if($altVirker == false){
            echo "<div class='red'><h1>";
            echo "<strong>Varsel:</strong>";
            echo $error;
            echo "</h1></div>";
          } else if($lagt_til){
            echo "<div class='green'><h1>";
            echo "Ny Overnatting registret";
            echo "</h1></div>";
          }
        ?>
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
      <p>Register nytt postnummer</p>
      <label class="switch">
        <input type="checkbox" name="egenPost">
        <span class="slider round"></span>
      </label>

      <div class="post">
        <div id="selectPost">
          <label for="poststed">Bydel</label>
          <select name="poststed" id="poststed">
            <?php
              $sql = "SELECT * FROM poststed JOIN bydel ON poststed.idbydel = bydel.idbydel";
              $resultat = $kobling->query($sql);

              while ($rad = $resultat -> fetch_assoc()) {
                $postnummer = $rad["postnummer"];
                $poststed = $rad["Poststed"];
                $bydel = $rad["navn"];

                echo '<option value="'.$postnummer.'">'.$postnummer.', '.$poststed.' i '.$bydel.'</option>';
              }
            ?>
          </select>
        </div>
        
        <div id="egenPost">
          <select name="bydel" id="bydel">
            <?php
                $sql = "SELECT * FROM bydel";
                $resultat = $kobling->query($sql);

                while ($rad = $resultat -> fetch_assoc()) {
                  $bydel = $rad["navn"];
                  $idbydel = $rad["idbydel"];

                  echo '<option value="'.$idbydel.'">'.$bydel.'</option>';
                }
            ?>
          </select>

          <label for="postnum">Postnummer</label>
          <input type="number" name="postnum" id="postnum">
          <br><br>
          <label for="postst">Poststed</label>
          <input type="text" name="postst" id="postst" value="NY">
        </div>
      </div>
      
        <label for="navn">Navn på overnatting</label>
        <input type="text" name="navn" id="navn">

        <label for="pris">pris</label>
        <input type="number" name="pris" id="pris">

        <label for="adresse">Adresse</label>
        <input type="text" name="adress" id="adresse">

        <label for="gatenr">Gate nummer</label>
        <input type="text" name="gatenr" id="gatenr">

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
            <option value="egen">Legg til egen</option>
        </select>

        <label for="egenStjerne">Eget antall stjerne</label>
        <input type="text" name="egenStjerne" id="egenStjerne">

        <label for="beskrivelse">Beskrivelse</label>
        <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse"></textarea>

        <h2>Bilder</h2>
        <h3>Legg til minst et bilde</h3>
        <div id="bildeID"> 
          <div class="bildeBoks">
          <input class="button" type="file" name="bilde[]" required>
          </div>

          <button type="button" class="button" id="leggTilBildeKnapp" onclick="leggTilBilde()">Legg til flere bilder</button>
        </div>
        
        <input type="submit" name="submit" value="Legg til overnatting">
      </form>
    </div>
    </main>

    <script src="leggtil.js"></script>
  </body>
</html>
