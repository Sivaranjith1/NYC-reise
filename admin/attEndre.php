<?php
    include_once "../kobling.php";
    include_once "../include/session.php";
    
    $lagt_til = false;
    $altVirker = true;
    $error = '';
    if(isset($_GET["endre"])) {

        $id = $_GET["id"];

        $sql = "SELECT * FROM mydb.attraksjon_kat where id={$id} group by id;";
        $resultat = $kobling->query($sql);
        $forste = true;
        while ($rad = $resultat->fetch_assoc()){
            $id = $rad["id"];
            $navn = $rad["Navn"];
            $aapningstid = $rad["aapningstid"];
            $stengetid = $rad["stengetid"];
            $addresse = $rad["addresse"];
            $gatenr = $rad["gatenr"];
            $beskrivelse = $rad["beskrivelse"];
            $pris = $rad["pris"];
        }

        //Endre hovedbilde

        //Redigere
        if (isset($_POST["submit"])){
            $navn = $_POST["navn"];
            $aapningstid = $_POST["aapningstid"];
            $stengetid = $_POST["stengetid"];
            $addresse = $_POST["addresse"];
            $gatenr = (isset($_POST["gatenr"]) ? $_POST["gatenr"] : null);
            $beskrivelse = $_POST["beskrivelse"];
            $pris = (isset($_POST["pris"]) ? $_POST["pris"] : null);


            $sql = "UPDATE `mydb`.`attraksjon` SET `Navn`='$navn', `aapningstid`='$aapningstid', `stengetid`='$stengetid', `addresse`='$addresse', `gatenr`='$gatenr',  `beskrivelse`='$beskrivelse', `pris`='$pris' WHERE `attraksjon_nummer`='$id';";

            if($kobling->query($sql)) {
                $lagt_til = true;
                header("Location: alleAttraksjoner.php");
            }else {
                $error = $kobling->error;
                $altVirker = false;
            }
        }


    } else {die("Du må velge en attraksjon");}

    
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
      <?php include_once "vanligNav.php"?>
      <h1>Endre <?php echo $navn; ?></h1>

      <div class="varsel">
          <?php
            if($altVirker == false){
              echo "<div class='red'><h1>";
              echo "<strong>Varsel:</strong>";
              echo $error;
              echo "</h1></div>";
            }
          ?>
        </div>

      <form action="" method="POST">
          <h1>ID: <?php echo $id; ?></h1>
          
          <label for="navn">Navn</label>
          <input type="text" name="navn" id="navn" value="<?php echo $navn; ?>" required>
          
          <label for="aapningstid">Åpningstid</label>
          <input type="time" name="aapningstid" id="aapningstid" value="<?php echo $aapningstid; ?>" required>
          
          <label for="stengetid">Stengetid</label>
          <input type="time" name="stengetid" id="stengetid" value="<?php echo $stengetid; ?>" required>
          
          <label for="addresse">Adresse</label>
          <input type="text" name="addresse" id="addresse" value="<?php echo $addresse; ?>" required>
          
          <label for="gatenr">Gate nummer</label>
          <input type="number" name="gatenr" id="gatenr" value="<?php echo $gatenr; ?>">
          
          <label for="beskrivelse">Beskrivelse</label>
          <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse" required><?php echo $beskrivelse; ?></textarea>
          
          <label for="pris">Pris</label>
          <input type="number" name="pris" id="pris" min="0" step=".01" value="<?php echo $pris; ?>">

          <input type="submit" name="submit" value="Oppdater <?php echo $navn; ?>">
        </form>
          
        </div>
    </main>
</body>
</html>
