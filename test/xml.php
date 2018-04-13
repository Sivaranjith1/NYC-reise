<?php
    $xml=simplexml_load_file("https://www.yr.no/sted/USA/New_York/New_York/varsel.xml") or die("Error: Cannot create object");
    echo $xml -> location -> name. ", ".$xml -> location -> country ;
    //print_r ($xml -> forecast -> tabular);
    $dagnummer = 0;
    foreach($xml -> forecast -> tabular -> children() as $barn) {
        if ($dagnummer == 3) {
            break 1;
        }
        $periode = $barn -> attributes() -> period;
        if ($periode == 3){
            //dato
            $dato = $barn -> attributes() -> from;
            $da = explode("T", $dato)[0];
            $da_deler = explode("-", $da);
            $dato = $da_deler[2]." ".$da_deler[1]." ".$da_deler[0];

            //type
            $symbol = $barn -> symbol -> attributes() -> name;

            //tempratur
            $temperature = $barn -> temperature -> attributes() -> value;
            $enhet = $barn -> temperature -> attributes() -> unit;
            //echo $dato." ".$symbol." {$temperature} o {$enhet}";


            //print_r($barn);
            $dagnummer ++; 
        }
        $symbol = $barn -> symbol -> attributes() -> name;
        $num = $barn -> symbol -> attributes() -> number;
        echo $symbol.$num.'<br>';
        //print_r($barn -> attributes() -> period);
        
    }
?>