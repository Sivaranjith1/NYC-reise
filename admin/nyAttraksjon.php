<!DOCTYPE html>
<?php 
  include "../kobling.php"; 
  $altVirker = true;
  $error = '';

  $target_dir = "bilder/";
  $target_file = $target_dir . basename($_FILES["bilde"]["name"][0]);
  $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
  if(isset($_POST["submit"])) {
      $check = getimagesize($_FILES["bilde"][0]["tmp_name"]);
      if($check !== false) {
          $altVirker = true;
      } else {
          $error = "filen er ikke et bilde";
          $altVirker = false;
      }
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>NYC-reise</title>
    <link rel="stylesheet" href="../stilark/style.css">
  </head>
  <body>
    <main>

      <form action="" method="POST" enctype="multipart/form-data">
      <p>Register ny postnummer</p>
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

          <label for="postst">Poststed</label>
          <input type="text" name="postst" id="postst" value="NY">
        </div>
      </div>

      <h2>Attraksjon</h2>

      <label for="navn">Navn</label>
      <input type="text" name="navn" id="navn">

      <label for="aapningstid">Åpningstid</label>
      <input type="time" name="aapningstid" id="aapningstid">

      <label for="stengetid">Stengetid</label>
      <input type="time" name="stengetid" id="stengetid">

      <label for="addresse">Adresse</label>
      <input type="text" name="addresse" id="addresse">

      <label for="gatenr">Gate nummer</label>
      <input type="number" name="gatenr" id="gatenr">

      <label for="beskrivelse">Beskrivelse</label>
      <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse"></textarea>

      <label for="pris">Pris</label>
      <input type="number" name="pris" id="pris" min="0" step=".01">

      <h2>Bilder</h2>
      <h3>Legg til minst et bilde</h3>
      <div id="bildeID"> 
        <div class="bildeBoks">
        <input type="file" name="bilde[]">
        </div>

        <button type="button">+</button>
      </div>

      <h2>Kategorier</h2>
      <div id="katID">
        <div class="kategorier">
          <?php 
             $sql = "SELECT * FROM kategori";
             $resultat = $kobling->query($sql);

             while ($rad = $resultat -> fetch_assoc()) {
               $id = $rad["idkategori"];
               $navn = $rad["navn"];

               echo '<p><span class="id" style="visibility:hidden;">'.$id.'</span><span class="navn">'.$navn.'</span></p>';
             }
          ?>
        </div>
         <div class="katBoks">
            <input type="hidden" name="kat[]" value="3">
            <p>Skyskraper</p>
         </div>
         <button type="button">+</button>
      </div>

      <input type="submit" value="Legg til attraksjon">
      </form>
      <?php
      var_dump($_POST);
      ?>
    </main>
  </body>
</html>
