<?php
    $error = '';
    include_once "../kobling.php";
    
    $sql = "SELECT attraksjonsnummer FROM mydb.slide;";
    $resultat = $kobling -> query($sql);

    $alleredeSlide = [];
    while($rad = $resultat -> fetch_assoc()) {
        $id = $rad["attraksjonsnummer"];
        $alleredeSlide[$id] = $id;
    }

    $inserted = []; 
    if(isset($_POST["check"])){
        foreach($_POST["check"] as $key => $value) {
            if(isset($alleredeSlide[$key])) {
                $inserted[$key] = $key;
            }else {
                $sql = "INSERT INTO `mydb`.`slide` (`attraksjonsnummer`) VALUES ('$key');";
                if ($kobling->query($sql)) {
                    $inserted[$key] = $key;
                } else {
                $error = $kobling->error;
                break 1;
                }

            }
            
        }

        foreach($alleredeSlide as $key => $value) {
            if(isset($inserted[$key])) {} else {
                $sql = "DELETE FROM `mydb`.`slide` WHERE `attraksjonsnummer`='$key';";
                if ($kobling->query($sql)) {
                } else {
                $error = $kobling->error;
                break 1;
                }
            }
        }
    } //endif
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
        <h1>Velg Attraksjon for bildefremvisningen</h1>

        <div class="varsel">
          <?php
            if($error !== ''){
              echo "<div class='red'><h1>";
              echo "<strong>Varsel:</strong>";
              echo $error;
              echo "</h1></div>";
            }
          ?>
        </div>



        <form action="" method="POST">
            <input type="submit" value="Lagre">
          

            <?php
            $sql = "SELECT attraksjonsnummer FROM mydb.slide;";
            $resultat = $kobling -> query($sql);
        
            $alleredeSlide = [];
            while($rad = $resultat -> fetch_assoc()) {
                $id = $rad["attraksjonsnummer"];
                $alleredeSlide[$id] = $id;
            }
            
            $sql = "SELECT id, Navn, bilde FROM mydb.attraksjon_kat group by id;";
            $resultat = $kobling -> query($sql);

            while($rad = $resultat -> fetch_assoc()) {
                $id = $rad["id"];
                $navn = $rad["Navn"];
                $bilde = $rad["bilde"];
                if(isset($alleredeSlide[$id])){
                    $checked = 'checked';
                }else {
                    $checked = '';
                }

            ?>
                <label class="overnatting slideSelect">
                    <input type="checkbox" name="check[<?php echo $id;?>]" <?php echo $checked;?>>
                    <div class="backSlide"></div>
                    <div class="overnattingbox">
                    <div class="overnattingbilde" style="object-fit: contain;">
                    <?php 
                        echo "<img src='../$bilde' height='200px' width='300px'>";
                    ?>
                    </div>
                    <div class="overnattingnavn">
                    <?php
                        echo "$navn";
                    ?>
                    </div>
                    </div>

            </label>
            <?php
            }
            
            
            ?>
            <input type="submit" value="Lagre">
        </form>
      
    </div>
    </main>
</body>
</html>
