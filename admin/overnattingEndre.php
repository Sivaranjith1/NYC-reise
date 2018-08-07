<!DOCTYPE html>
<?php 
    include "../kobling.php";
    include_once "../include/session.php"; 
    
    $lagt_til = false;
    $altVirker = true;
    $error = '';

    if(isset($_GET["endre"])) {

        $id = $_GET["id"];

        $sql = "SELECT * FROM mydb.overnatting where idovernatting={$id};";
        $resultat = $kobling->query($sql);
        while ($rad = $resultat->fetch_assoc()){
            $id = $rad["idovernatting"];
            $navn = $rad["navn"];
            $pris = $rad["pris"];
            $stjerner = $rad["stjerner"];
            $addresse = $rad["addresse"];
            $gatenr = $rad["gatenr"];
            $beskrivelse = $rad["beskrivelse"];
        }


        if (isset($_POST["submit"])){
            $navn = $_POST["navn"];
            $pris = $_POST["pris"];
            $stjerner = $_POST["stjerne"];
            $addresse = $_POST["addresse"];
            $gatenr = $_POST["gatenr"];
            $beskrivelse = $_POST["beskrivelse"];


            $sql = "UPDATE `mydb`.overnatting SET `navn`='$navn', `addresse`='$addresse', `gatenr`='$gatenr',  `beskrivelse`='$beskrivelse', `pris`='$pris', `stjerner`='$stjerner' WHERE `idovernatting`='$id';";

            if($kobling->query($sql)) {
                $lagt_til = true;
                header("Location: alleOvernatting.php");
            }else {
                $error = $kobling->error;
                $altVirker = false;
            }
        }
    } else {die("Du må velge et overnattingsted");}
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
            echo "Overnatting Endret";
            echo "</h1></div>";
          }
        ?>
      </div>
      
    <h2>Overnatting</h2>
    <p>ID: <?php echo $id;?></p>
    <form action="" method="POST">
        <label for="navn">Navn på overnatting</label>
        <input type="text" name="navn" id="navn" value="<?php echo $navn;?>">

        <label for="pris">pris</label>
        <input type="number" name="pris" id="pris" value="<?php echo $pris;?>">

        <label for="addresse">Adresse</label>
        <input type="text" name="addresse" id="adresse" value="<?php echo $addresse;?>">

        <label for="gatenr">Gate nummer</label>
        <input type="text" name="gatenr" id="gatenr" value="<?php echo $gatenr;?>">

        <label for="stjerne">Stjerner</label>
        <select name="stjerne" id="stjerne" onchange="stjerneEgenSelect(this)">
            <?php
                $sql = "SELECT * FROM stjerner ORDER BY stjerner DESC";
                $resultat = $kobling->query($sql);

                while ($rad = $resultat -> fetch_assoc()) {
                  $stjerneVarianter = $rad["stjerner"];
                  if($stjerner == $stjerneVarianter){
                      $selected = 'selected';
                  } else {
                    $selected = '';
                  }

                  echo '<option value="'.$stjerneVarianter.'" '.$selected.'>'.$stjerneVarianter.'</option>';
                }
            ?>
        </select>

        <label for="beskrivelse">Beskrivelse</label>
        <textarea name="beskrivelse" id="beskrivelse" cols="30" rows="10" placeholder="Skriv en beskrivelse" required><?php echo $beskrivelse;?>"</textarea>
        
        <input type="submit" name="submit" value="Endre overnatting">
      </form>
    </div>
    </main>
  </body>
</html>
