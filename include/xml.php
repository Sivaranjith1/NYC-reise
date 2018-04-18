<?php
    $xml=simplexml_load_file("https://www.yr.no/sted/USA/New_York/New_York/varsel.xml") or die("Error: Cannot create object");
    //echo '<link rel="stylesheet" href="../stilark/style.css">';
    $dagnummer = 0;
    $tid = ["I dag", " I morgen", ""];
    foreach($xml -> forecast -> tabular -> children() as $barn) {
        if ($dagnummer == 3) {
            break 1;
        }
        $periode = $barn -> attributes() -> period;
        if ($periode == 3){
            $start = '';

            //dato
            $dato = $barn -> attributes() -> from;
            $da = explode("T", $dato)[0];
            $da_deler = explode("-", $da);
            $dato = $da_deler[2].".".$da_deler[1].".".$da_deler[0];

            //type
            $symbol = $barn -> symbol -> attributes() -> name;
            $num = $barn -> symbol -> attributes() -> number;

            //tempratur
            $temperature = $barn -> temperature -> attributes() -> value;

            //vind
            $vindRetning = $barn -> windDirection -> attributes() -> name;

            if($dagnummer == 0) {
                $bilde = 'bilder/vear/2.jpg';

                if ($num == 1) {
                    $bilde = 'bilder/vear/1.jpg';
                } else if ($num >= 9 && $num <= 12) {
                    $bilde = 'bilder/vear/9.jpg';
                }
                $by = $xml -> location -> name. ", ".$xml -> location -> country ;
                $start = "<div id='vearData'>
                            <img src='{$bilde}' alt='vær bilde'>
                            <h1 id='by'>{$by}</h1>
                            <div class='vearNy'>
                ";
            }

            $dagArray = $tid[$dagnummer];

            echo $start;
            echo "<div class='vear'>
                    <h1>{$dagArray} {$dato}</h1>
                    <h2>{$symbol}</h1>
                    <h2>{$temperature} &#8451;</h1>
                    <h4>Vind retning {$vindRetning}</h2>
                  </div>";

            $dagnummer ++; 
        }
        //$symbol = $barn -> symbol -> attributes() -> name;
        //$num = $barn -> symbol -> attributes() -> number;
        //echo $symbol.$num.'<br>';
        
    }
    echo '</div><div class="yr">Værdata fra yr.</div>';
    echo '</div>'
?>