<?php
    include_once("../kobling.php");

    switch($_SERVER['REQUEST_METHOD']){
        case "POST":
            echo "POST";
            http_response_code(200);
            break;

        case "GET":
            $storre = isset($_GET["storre"]) ? $_GET["storre"] : '';
            $storreWhere = $storre == '' ? '' : 'where pris <= '.$storre.' ';

            $json = [];
            //  $json[] = $rad;

            $nummer = isset($_GET["num"]) ? $_GET["num"] : 1;
            $offset = isset($_GET["offset"]) ? $_GET["offset"] : 5;
            $forskyvning = $offset * $nummer;
            $sqlArray = '';
            $sql = "SELECT id FROM mydb.attraksjon_kat {$storreWhere} group by id ORDER BY navn LIMIT {$offset} OFFSET {$forskyvning};";
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

                    if( isset($test) ){ 
                        $test["kat"] = $katArray;
                        $test["tid"] = $tid;
                        $test["lenk"] = $lenk;
                        $test["katRekke"] = $katRekke;
                        $json[] = $test;
                    }
                    //var_dump($katArray);
                    
                    $test = $rad;

                    $katArray = [];
                    $katRekke = '';
                    $katArray[] = $kategori;
                    $katRekke = $katRekke."<p>{$kategori}</p>";
                    $forjeId = $id;

                    $lenk = "attDetalje.php?id={$rad['id']}";

                    $aapningstid = $rad["aapningstid"];
                    $stengetid = $rad["stengetid"];
                    
                    if ($aapningstid == '00:00:00' && $stengetid == '00:00:00') {
                    $tid = 'Alltid åpen';
                    } else {
                    $tid = "{$aapningstid} - {$stengetid}";
                    }
                
                }
            }

            $test["kat"] = $katArray;
            $test["tid"] = $tid;
            $test["lenk"] = $lenk;
            $test["katRekke"] = $katRekke;
            $json[] = $test;
            //echo $ut;
            //var_dump($katArray);
        
            print_r(json_encode($json));
            http_response_code(200);
            break;

        default:
            http_response_code(405);
    }
?>
