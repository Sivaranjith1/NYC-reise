<!DOCTYPE html>
    
<?php 
  include "../kobling.php"; 
  include_once "../include/session.php";
  $altVirker = true;
  $error = '';
  $lagt_til = false;

  $target_dir = "../bilder/";
  if($altVirker && isset($_POST["submit"])) {
    $egenPost = (isset($_POST["egenPost"]) ? true : false);
    $poststed = $_POST["poststed"];
    $navn = $_POST["navn"];
    $aapningstid = $_POST["aapningstid"];
    $stengetid = $_POST["stengetid"];
    $addresse = $_POST["addresse"];
    $gatenr = (isset($_POST["gatenr"]) ? $_POST["gatenr"] : null);
    $beskrivelse = $_POST["beskrivelse"];
    $pris = (isset($_POST["pris"]) ? $_POST["pris"] : null);
    
    $kategori = (isset($_POST["kat"]) ? $_POST["kat"] : []);
    $bildeIder = [];

    //postadresse
    if ($egenPost) {
      $bydel = $_POST["bydel"];
      $postnum = $_POST["postnum"];
      $postst = $_POST["postst"];
      $sql = "INSERT INTO `poststed` (`postnummer`, `Poststed`, `idbydel`) 
              VALUES ('".$postnum."', '".$postst."', '".$bydel."')";

      if ($kobling->query($sql)) {
        $poststed = $postnum;
      } else {
        $error = $kobling->error;
        $altVirker = false;
      }

    }

    //insert attraksjon
    if($altVirker) {
      $sql = "INSERT INTO `attraksjon` (`Navn`, `aapningstid`, `stengetid`, `addresse`, `gatenr`, `poststed_postnummer`, `beskrivelse`, `pris`) 
              VALUES ('".$navn."', '".$aapningstid."', '".$stengetid."', '".$addresse."', '".$gatenr."', '".$poststed."', '".$beskrivelse."', '".$pris."')";

      if ($kobling->query($sql)) {
        $attID = $kobling->insert_id;
        $lagt_til = true;
      } else {
        $error = $kobling->error;
        $altVirker = false;
      }
    }

    //kategori
    if($altVirker && isset($_POST["nyKat"])){
      $nyKat = $_POST["nyKat"];

      foreach($nyKat as $key) {
        $sql = "INSERT INTO `kategori` (`navn`) VALUES ('".$key."')";

        if ($kobling->query($sql)) {
          $nyKatId = $kobling->insert_id;
          $kategori[] = $nyKatId;
        } else {
          $error = $kobling->error;
          $altVirker = false;
          break 1;
        }
      }
    }

    //insert attraksjon-kategori
    if($altVirker){
      foreach ($kategori as $key) {
        $sql = "INSERT INTO `kategori_attraksjon` (`attraksjonsnummer`, `idkategori`) VALUES ('".$attID."', '".$key."');";
        if ($kobling->query($sql)) {
        } else {
          $error = $kobling->error;
          $altVirker = false;
          break 1;
        }
      }
    }
    

    //bilder
    //må legge til senere
    if ($altVirker) {
      $antallBilder = count($_FILES["bilde"]["name"]);

      for($i = 0; $i < $antallBilder; $i++){
        $target_file = $target_dir . basename($_FILES["bilde"]["name"][$i]);
        $maal_plass = "bilder/" . basename($_FILES["bilde"]["name"][$i]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["bilde"]["tmp_name"][$i]);
        if($check !== false) {
            $altVirker = true;
            move_uploaded_file($_FILES["bilde"]["tmp_name"][$i], $target_file);

            $sql = "INSERT INTO `mydb`.`bilde` (`bilde`, `attraksjonsnummer`) VALUES ('".$maal_plass."', '".$attID."')";
            if ($kobling->query($sql)) {
              if($i == 0) {
                $hovedBilde = $kobling->insert_id;
              }
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

    //update hovedbilde
    if($altVirker) {
      $sql = "UPDATE `attraksjon` SET `hovedbilde`='".$hovedBilde."' WHERE `attraksjon_nummer`='".$attID."'";
      if ($kobling->query($sql)) {
      } else {
        $error = $kobling->error;
        $altVirker = false;
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
    <?php include_once "vanligNav.php"?>
      <div class="varsel">
        <?php
          if($altVirker == false){
            echo "<div class='red'><h1>";
            echo "<strong>Varsel:</strong>";
            echo $error;
            echo "</h1></div>";
          } else if($lagt_til){
            echo "<div class='green'><h1>";
            echo "Ny Attraksjon registret";
            echo "</h1></div>";
          }
        ?>
      </div>

      <form action="" method="POST" enctype="multipart/form-data">
      <p>Register nytt postnummer</p>
      <label class="switch">
        <input type="checkbox" name="egenPost" onclick="egenPostKnapp();">
        <span class="slider round"></span>
      </label>

      <div class="post">
        <div id="selectPost">
          <label for="poststed">Bydel</label>
          <select name="poststed" id="poststed">
            <?php
              $sql = "SELECT * FROM poststed JOIN bydel ON poststed.idbydel = bydel.idbydel ORDER BY postnummer ASC";
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
                $sql = "SELECT * FROM bydel ORDER BY navn ASC";
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

      <h2>Attraksjon</h2>

      <label for="navn">Navn</label>
      <input type="text" name="navn" id="navn" required>

      <label for="aapningstid">Åpningstid</label>
      <input type="time" name="aapningstid" id="aapningstid" required>

      <label for="stengetid">Stengetid</label>
      <input type="time" name="stengetid" id="stengetid" required>

      <label for="addresse">Adresse</label>
      <input type="text" name="addresse" id="addresse" required>

      <label for="gatenr">Gate nummer</label>
      <input type="number" name="gatenr" id="gatenr">

      <label for="beskrivelse">Beskrivelse</label>
      <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse" required></textarea>

      <label for="pris">Pris</label>
      <input type="number" name="pris" id="pris" min="0" step=".01">

      <h2>Bilder</h2>
      <h3>Legg til minst et bilde</h3>
      <div id="bildeID"> 
        <div class="bildeBoks">
        <input class="button" type="file" name="bilde[]" required>
        </div>

        <button type="button" class="button" id="leggTilBildeKnapp" onclick="leggTilBilde()">Legg til flere bilder</button>
      </div>

      <h2>Kategorier</h2>
      <div id="katID">
        <div class="kategorier" style="display: none;">
          <?php 
             $sql = "SELECT * FROM kategori ORDER BY navn ASC";
             $resultat = $kobling->query($sql);

             while ($rad = $resultat -> fetch_assoc()) {
               $id = $rad["idkategori"];
               $navn = $rad["navn"];

               echo '<p><span onclick="lagHidden('.$id.', `'.$navn.'`)">'.$navn.'</span></p>';
             }
          ?>
          <div class="ny">
            <input type="text" id="nyKat">
            <button type="button" class="button" onclick="leggTilNy()">Legg til</button>  
          </div>
        </div>
        <button type="button" class="button" id="leggTilKatKnapp" onclick="leggTilKat()">+</button>
      </div>

      <input type="submit" name="submit" value="Legg til attraksjon">
      </form>
    </div>
    </main>

    <script src="leggtil.js"></script>
  </body>
</html>
