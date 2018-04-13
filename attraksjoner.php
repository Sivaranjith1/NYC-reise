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

      <h1>Test div</h1>    
      <div class="att" style="background-color: hotpink;">
        <img src="bilder/empire_state/night.jpg" alt="bilde av attraksjon">
        <h2>Empire state Building</h2>
        <p>Addresse: 350 5th Ave, 10118 NY</p>
        <h4>Manhattan</h4>
        <p>08:00 - 02:00</p>
        <div class="kats">
          <p>Utsiktspunkt</p><p>Skyskraper</p>
        </div>
      </div>
        
      <h1>Attraksjoner i New York.</h1>

        <?php
          include_once "kobling.php";
          //konf
          $offset = 5; //er også limiten

          //total
          $totalSql = 'SELECT COUNT(*) totalt FROM (SELECT count(*) tot FROM mydb.attraksjon_kat group by id) src;';
          $totalt = $kobling->query($totalSql) -> fetch_assoc() ["totalt"];
          echo "<div id='totalt'>{$totalt}</div>";
          echo "<div id='offset'>{$offset}</div>";

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
          $sql = "SELECT * FROM mydb.attraksjon_kat {$nyArray} ORDER BY navn";
          $resultat = $kobling->query($sql);
          while ($rad = $resultat -> fetch_assoc()) {
            $id = $rad["id"]; //id
            $kategori = $rad["kategori"]; //kat

            if($id == $forjeId) {
              $katArray[] = $kategori;
            } else {
              if( isset($ut) ){ echo $ut; }
              var_dump($katArray);
              $katArray = [];
              $katArray[] = $kategori;
              $forjeId = $id;
              
              //ny data
              $navn = $rad["Navn"];
              $aapningstid = $rad["aapningstid"];
              $stengetid = $rad["stengetid"];
              $addresse = $rad["addresse"];
              $gatenr = $rad["gatenr"];
              $beskrivelse = $rad["beskrivelse"];
              $pris = $rad["pris"];
              $bilde = $rad["bilde"];
              $bydel = $rad["bydelNavn"];
              $postnummer = $rad["postnummer"];
              $poststed = $rad["Poststed"];
              
              $ut = $id.' '.$navn.'<br>';
            }
          }
          echo $ut;
          var_dump($katArray);
          
        ?>

        <h2>Filtere</h2>
        <h4>Bydel</h4>
        <?php
        $sql = "SELECT * FROM bydel ORDER BY navn ASC";
        $resultat = $kobling->query($sql);

        while ($rad = $resultat -> fetch_assoc()) {
          $bydel = $rad["navn"];

          echo "<input type='checkbox' name='$bydel' id='$bydel'><label for='$bydel'>$bydel</label>";
        }
        ?>

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
        $sql = "SELECT kategori FROM mydb.attraksjon_kat group by kategori ORDER BY kategori;";
        $resultat = $kobling->query($sql);

        while ($rad = $resultat -> fetch_assoc()) {
          $kategori = $rad["kategori"];

          echo "<input type='checkbox' name='$kategori' id='$kategori'><label for='$kategori'>$kategori</label>";
        }
        ?>

      <button onclick="hentData()">Fetch</button>
      </div>
    </main>

    <script>
      let ikkeHenter = true;
      let offset = document.querySelector('#offset').innerHTML;
      let total = document.querySelector('#totalt').innerHTML;
      let igjen = total;

      window.onscroll = function(ev) {
      if ((window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 100) && ikkeHenter) {
          console.log("buttom");
          ikkeHenter = false;
          console.info(ikkeHenter);
      }
      };

      function hentData() {
        fetch("http://127.0.0.1/NYC-reise/rest/attraksjon.php")
          .then(function(response) {
            return response.json();
            })
          .then(data => console.log(data))
      }
    </script>
  </body>
</html>
