<?php
ini_set('display_errors', 1);

// Rebem les peticions de l'usuari
//header("Content-Type: application/json");
switch($_SERVER["REQUEST_METHOD"]){
    case 'POST':
        echo $_POST["opcio"];
        echo $_POST["nom"];
        /*echo 'Entra|';
        echo $data.'1|';
        echo $json.'2|';
        echo $json[0].'4|';
        echo $json[1].'3|';
        */
        /*if(isset($_GET["opcio"])){
        }else{
            echo '{"codi_error":"1","error":"No s\'ha determinat el tipus d\'acció a realitzar."}';
        }*/
    break;
}

?>