<?php
ini_set('display_errors', 1);
// API > login
// Javier Valverde Lozano
// Classes necesàries
require ('../../utils/errors.php');
require ('../../utils/Database.php');
$db = new Database();

// Rebem les peticions de l'usuari
header("Content-Type: application/json");
switch($_SERVER["REQUEST_METHOD"]){
    
    case 'POST':
        
        if(isset($_POST["usuari"])){
            if(isset($_POST["password"])){
                $login = $db->login($_POST["usuari"],$_POST["password"]);
                if(!is_null($login)){
                   
                     // Creem el token
                    $token = $db->generarToken($login["id"]);
                    
                    echo '{';
                        echo '"codi_error":"0",';
                        echo '"id":"'.$login["id"].'",';
                        echo '"tipus":"'.$login["tipus"].'",';
                        echo '"email":"'.$login["email"].'",';
                        echo '"password":"'.$login["password"].'",';
                        echo '"nom":"'.$login["nom"].'",';
                        echo '"cognom1":"'.$login["cognom1"].'",';
                        echo '"cognom2":"'.$login["cognom2"].'",';
                        echo '"telefon":"'.$login["telefon"].'",';
                        echo '"actiu":"'.$login["actiu"].'",';
                        echo '"token":"'.$token.'"';
                    echo '}';
                    
                }else{ echo $errors["25"]; }
             }else{ echo $errors["24"]; }
        }else{ echo $errors["23"]; }
        
    break;
    
    default:
        echo $errors["1"];
    break;
    
}

?>