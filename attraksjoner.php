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

      <h1>Attraksjoner i New York.</h1>

        <?php
          include_once "kobling.php";
          //konf
          $offset = 5; //er også limiten

          //total
          $totalSql = 'SELECT COUNT(*) totalt FROM (SELECT count(*) tot FROM mydb.attraksjon_kat group by id) src;';
          $totalt = $kobling->query($totalSql) -> fetch_assoc() ["totalt"];
          echo "<div id='totalt'>{$totalt} resultater</div>";
        ?>

        <div class="Allfiltere">
        <h2 class="filterKnapp" onclick="filterTrykket()">Filtere</h2>
        <div class="filtere">

          <div class="filterBox">
            <h3>Bydel</h3>
            <?php
              $sql = "SELECT * FROM bydel ORDER BY navn ASC";
              $resultat = $kobling->query($sql);
              $num = 0;
              while ($rad = $resultat -> fetch_assoc()) {
                $bydel = $rad["navn"];
                
                //echo "<input type='checkbox' name='$bydel' id='$bydel'><label for='$bydel'>$bydel</label>";
                echo "<label class='check'>{$bydel}
                        <input type='checkbox' name='$bydel' id='$bydel' onclick='endreBydel(`{$num}`, `{$bydel}`)'>
                        <span class='checkmark'></span>
                      </label><br>";
                $num ++;
              }
            ?>

            <button class="button" onclick="sokFilter()">Oppdater søk</button>
          </div>

          <!--
          <input type="range" name="min" id="min">
          <label for="min">min</label>
          
          <input type="range" name="storre" id="storre">
          <label for="storre">max</label>

          <input type="checkbox" name="hele" id="hele">
          <label for="hele">Åpen hele døgnet</label>

          <input type="time" name="aapningstid" id="aapningstid">
          <label for="aapningstid">Åpningstiden</label>

          <input type="time" name="stengetid" id="stengetid">
          <label for="stengetid">Stenge tid</label>

          <h4>Kategorier</h4>
          <?php
          /*
          $sql = "SELECT kategori FROM mydb.attraksjon_kat group by kategori ORDER BY kategori;";
          $resultat = $kobling->query($sql);

          while ($rad = $resultat -> fetch_assoc()) {
            $kategori = $rad["kategori"];

            echo "<input type='checkbox' name='$kategori' id='$kategori'><label for='$kategori'>$kategori</label>";
          }
          */
          ?>

          <button onclick="hentData()">Fetch</button>-->
        </div>
        </div>

        <?php
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
                    <a class='overLenke' href='{$lenk}'></a>
                    <div class='bilde'>
                        <img src='{$bilde}' alt='bilde av attraksjon'>
                    </div>
                    <div class='flex1'>
                        <h2>{$navn}</h2>
                        <p>Addresse: {$gatenr} {$addresse}, {$postnummer} {$poststed}</p>
                        <h4>{$bydel}</h4>
                        <p>{$tid}</p>
                        <div class='col'>
                          <p>Kategori: </p>{$katRekke}
                        </div>
                    </div>
                      </div>";
               }
              $katArray = [];
              $katRekke = '';
              $katArray[] = $kategori;
              $katRekke = $katRekke."<p>{$kategori}</p>";
              $forjeId = $id;
              
              //ny data
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
                    <a class='overLenke' href='{$lenk}'></a>
                    <div class='bilde'>
                        <img src='{$bilde}' alt='bilde av attraksjon'>
                    </div>
                    <div class='flex1'>
                        <h2>{$navn}</h2>
                        <p>Addresse: {$gatenr} {$addresse}, {$postnummer} {$poststed}</p>
                        <h4>{$bydel}</h4>
                        <p>{$tid}</p>
                        <div class='col'>
                          <p>Kategori: </p>{$katRekke}
                        </div>
                    </div>
                      </div>";
          
        ?>
        
      </div>
    </main>

    <script src="js/attraksjon.js"></script>
  </body>
</html>
