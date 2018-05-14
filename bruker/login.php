<?php

if(isset($_POST["pass"])) {
    $bruker = mysqli_real_escape_string($kobling, $_POST["bruker"]);
    $bruker = htmlspecialchars($bruker, ENT_QUOTES, 'UTF-8');

    $pass = mysqli_real_escape_string($kobling, $_POST["pass"]);
    $pass = $bruker.$pass;

    $sql = "SELECT * FROM mydb.adminbruker WHERE brukernavn = '$bruker';";
    $resultat = $kobling -> query($sql) ;
    $rad = $resultat -> fetch_assoc();
    $hash = $rad["passord"];

    if (password_verify($pass, $hash)) {
        echo 'Passordet er riktig!';
        $_SESSION["brukernavn"] = $rad["brukernavn"];
        $_SESSION["fornavn"] = $rad["fornavn"];
        $_SESSION["etternavn"] = $rad["etternavn"];
        
    } else {
        echo 'Passordet er feil.';
    }
}

if(isset($_SESSION["brukernavn"])){}else {
    echo '<h1>Logg inn</h1>';

    echo '<form action="" method="post">
            <input type="text" name="bruker" placeholder="brukernavn" required>
            <input type="password" name="pass" placeholder="passord" required>
            <input type="submit" value="submit">
        </form>';
}