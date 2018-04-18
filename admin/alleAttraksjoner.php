<?php
    include_once "../kobling.php";
    $lagt_til = false;
    $altVirker = true;
    if(isset($_POST["slett"])) {
        $slett_id = $_POST["id"];
        $error = '';

        $sql = "DELETE FROM tips WHERE attraksjonsnummer ='$slett_id'";
        if($kobling->query($sql)) {
        }else {
          $error = $kobling->error;
          $altVirker = false;
        }

        if($altVirker){
          $sql = "DELETE FROM bilde WHERE attraksjonsnummer ='$slett_id'";
          if($kobling->query($sql)) {
          }else {
            $error = $kobling->error;
            $altVirker = false;
          }
        }

        if($altVirker){
          $sql = "DELETE FROM slide WHERE attraksjonsnummer ='$slett_id'";
          if($kobling->query($sql)) {
          }else {
            $error = $kobling->error;
            $altVirker = false;
          }
        }

        if($altVirker){
          $sql = "DELETE FROM kategori_attraksjon WHERE attraksjonsnummer ='$slett_id'";
          if($kobling->query($sql)) {
          }else {
            $error = $kobling->error;
            $altVirker = false;
          }
        }

        if($altVirker){
          $sql = "DELETE FROM attraksjon WHERE attraksjon_nummer ='$slett_id'";
          if($kobling->query($sql)) {
            $lagt_til = true;
          }else {
            $error = $kobling->error;
            $altVirker = false;
          }
        }

    }
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

      <h1>Attraksjoner i New York.</h1>
        <div class="varsel">
          <?php
            if($altVirker == false){
              echo "<div class='red'><h1>";
              echo "<strong>Varsel:</strong>";
              echo $error;
              echo "</h1></div>";
            } else if($lagt_til){
              echo "<div class='green'><h1>";
              echo "Attraksjon ble slettet";
              echo "</h1></div>";
            }
          ?>
        </div>

        <?php
          //select ider
          $sqlArray = '';
          $sql = "SELECT id FROM mydb.attraksjon_kat group by id ORDER BY navn;";
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
          $forjeId = 0;
          $katArray = [];
          $katRekke = '';
          $sql = "SELECT * FROM mydb.attraksjon_kat {$nyArray} ORDER BY navn";
          $resultat = $kobling->query($sql);
          while ($rad = $resultat -> fetch_assoc()) {
            $id = $rad["id"]; //id
            $kategori = $rad["kategori"]; //kat

            if($id == $forjeId) {
              $katArray[] = $kategori;
              $katRekke = $katRekke."<p>{$kategori}</p>";
            } else {
              if( isset($ut) ){ 
                echo "<div class='att'>
                    <div class='bilde'>
                        <img src='../{$bilde}' alt='bilde av attraksjon'>
                    </div>
                    <div class='flex1'>
                        <h2>{$navn}</h2>
                        <p>Addresse: {$gatenr} {$addresse}, {$postnummer} {$poststed}</p>
                        <h4>{$bydel}</h4>
                        <p>{$tid}</p>
                        <div class='kats col'>
                          {$katRekke}
                        </div>

                        <form method='POST'>
                        <input type='hidden' name='id' value='{$gammelId}'>
                        <input type='submit' style='z-index: 90;' value='slett' name='slett'>
                        </form>
                        <form method='GET' action='attEndre.php'>
                        <input type='hidden' name='id' value='{$gammelId}'>
                        <input type='submit' style='z-index: 90;' value='endre' name='endre'>
                        </form>
                    </div>
                      </div>";
               }
              $katArray = [];
              $katRekke = '';
              $katArray[] = $kategori;
              $katRekke = $katRekke."<p>{$kategori}</p>";
              $forjeId = $id;
              
              //ny data
              $gammelId = $rad["id"];
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
              
              $ut = true;
            }
          }
          echo "<div class='att'>
                    <div class='bilde'>
                        <img src='../{$bilde}' alt='bilde av attraksjon'>
                    </div>
                    <div class='flex1'>
                        <h2>{$navn}</h2>
                        <p>Addresse: {$gatenr} {$addresse}, {$postnummer} {$poststed}</p>
                        <h4>{$bydel}</h4>
                        <p>{$tid}</p>
                        <div class='kats col'>
                          {$katRekke}
                        </div>
                        <form method='POST'>
                        <input type='hidden' name='id' value='{$gammelId}'>
                        <input type='submit' style='z-index: 90;' value='slett' name='slett'>
                        </form>
                        <form method='GET' action='attEndre.php'>
                        <input type='hidden' name='id' value='{$gammelId}'>
                        <input type='submit' style='z-index: 90;' value='endre' name='endre'>
                        </form>
                    </div>
                      </div>";
          
        ?>
      </div>
    </main>
  </body>
</html>
