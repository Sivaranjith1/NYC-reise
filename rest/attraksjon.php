<?php
    include_once("../kobling.php");
    

    switch($_SERVER['REQUEST_METHOD']){
        case "POST":
            echo "POST";
            http_response_code(200);
            break;

        case "GET":
            $storre = isset($_GET["storre"]) ? $_GET["storre"] : '';
            $storreWhere = $storre == '' ? '' : 'where pris < '.$storre;


            $sql = "SELECT * FROM mydb.overnatting_bilder ".$storreWhere." group by id;";
            $resultat = $kobling->query($sql);
            $json = [];
            while($rad = $resultat->fetch_assoc()) {
                $json[] = $rad;
            }
        
            echo json_encode($json);
            http_response_code(200);
            break;

        default:
            http_response_code(405);
    }
?>
