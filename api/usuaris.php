<?php

// Rebem les peticions de l'usuari
header("Content-Type: application/json");
switch($_SERVER["REQUEST_METHOD"]){
    case 'GET':
        if(isset($_GET["opcio"])){
            switch($_GET["opcio"]){
                case "alta":
                    echo '{"missatge":"alta","nom":"'.$_GET["nom"].'"}';
                break;
                default:
                    echo '{"codi_error":"2","error":"No s\'ha determinat el tipus d\'acció a realitzar."}';
                break;
            }
        }else{
            echo '{"codi_error":"1","error":"No s\'ha determinat el tipus d\'acció a realitzar."}';
        }
    break;
    case 'PUT':
        echo 'actualizar un usuario';
    break;
    case 'DELETE':
        echo 'eliminar usuario';
    break;

}

?>