<!DOCTYPE html>
<?php 
    include "../kobling.php";
    include_once "../include/session.php"; 
    
    $lagt_til = false;
    $altVirker = true;
    $error = '';

    if(isset($_GET["endre"])) {

        $id = $_GET["id"];

        $sql = "SELECT * FROM mydb.spisested where idspisested={$id};";
        $resultat = $kobling->query($sql);
        while ($rad = $resultat->fetch_assoc()){
            $id = $rad["idspisested"];
            $navn = $rad["resturant_navn"];
            $pris = $rad["pris"];
            $addresse = $rad["addresse"];
            $gatenr = $rad["gatenr"];
            $beskrivelse = $rad["beskrivelse"];
        }


        if (isset($_POST["submit"])){
            $navn = $_POST["navn"];
            $pris = $_POST["pris"];
            $addresse = $_POST["addresse"];
            $gatenr = $_POST["gatenr"];
            $beskrivelse = $_POST["beskrivelse"];


            $sql = "UPDATE `mydb`.spisested SET `resturant_navn`='$navn', `addresse`='$addresse', `gatenr`='$gatenr',  `beskrivelse`='$beskrivelse', `pris`='$pris' WHERE `idspisested`='$id';";

            if($kobling->query($sql)) {
                $lagt_til = true;
                header("Location: alleSpisesteder.php");
            }else {
                $error = $kobling->error;
                $altVirker = false;
            }
        }
    } else {die("Du må velge et spisested");}
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
            echo "Spisested Endret";
            echo "</h1></div>";
          }
        ?>
      </div>
      
    <h2>Spisested</h2>
    <p>ID: <?php echo $id;?></p>
    <form action="" method="POST">
        <label for="navn">Navn på spisestedet</label>
        <input type="text" name="navn" id="navn" value="<?php echo $navn;?>">

        <label for="pris">pris</label>
        <input type="number" name="pris" id="pris" value="<?php echo $pris;?>">

        <label for="addresse">Adresse</label>
        <input type="text" name="addresse" id="adresse" value="<?php echo $addresse;?>">

        <label for="gatenr">Gate nummer</label>
        <input type="text" name="gatenr" id="gatenr" value="<?php echo $gatenr;?>">

        <label for="beskrivelse">Beskrivelse</label>
        <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse" required><?php echo $beskrivelse;?>"</textarea>
        
        <input type="submit" name="submit" value="Endre spisested">
      </form>
    </div>
    </main>
  </body>
</html>
