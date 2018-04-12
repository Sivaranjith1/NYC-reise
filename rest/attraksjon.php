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

            $offset = isset($_GET["offset"]) ? $_GET["offset"] : 5;
            $sqlArray = '';
            $sql = "SELECT id FROM mydb.attraksjon_kat {$storreWhere} group by id ORDER BY navn LIMIT {$offset};";
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

                    if( isset($test) ){ 
                        $test["kat"] = $katArray;
                        $json[] = $test;
                    }
                    //var_dump($katArray);
                    
                    $test = $rad;

                    $katArray = [];
                    $katArray[] = $kategori;
                    $forjeId = $id;
                
                }
            }

            $test["kat"] = $katArray;
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
