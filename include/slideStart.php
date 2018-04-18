<?php
//include_once "../kobling.php";

$sql = "SELECT * FROM slide JOIN attraksjon_kat ON attraksjonsnummer = id group by id ORDER BY Navn;";
$resultat = $kobling -> query($sql);

$n = 2;
while ($rad = $resultat -> fetch_assoc()) {
    $id = $rad["id"];
    $navn = $rad["Navn"];
    $aapningstid = $rad["aapningstid"];
    $stengetid = $rad["stengetid"];
    $addresse = $rad["addresse"];
    $gatenr = $rad["gatenr"] == 0 ? '' : $rad["gatenr"];
    $beskrivelse = $rad["beskrivelse"];
    $pris = $rad["pris"] == 0 ? 'gratis' : $rad["pris"]." kr";
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

    $left= 100*$n;
    $n ++;
    echo "<div class='slide' style='left: {$left}%;background: #666;'>
        <img src='$bilde' alt='bilde av overnatting'>
        <div class='vearNy cols slideText'>
        <h2>$navn</h2> <h2>$pris</h2>
        </div>
        <button class='button slideButton'><a href='$lenk'></a>Besøk</button>
    </div>";
}
