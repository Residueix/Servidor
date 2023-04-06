<?php
ini_set('display_errors', 1);
// API Token
// Javier Valverde Lozano
// Classes necesàries
require ('../../utils/errors.php');
require ('../../utils/Database.php');
$db = new Database($errors);

// Rebem les peticions de l'usuari
header("Content-Type: application/json");
switch($_SERVER["REQUEST_METHOD"]){
    
    case 'POST':

                if(isset($_POST["usuari"])){
                    if(is_numeric($_POST["usuari"])){
                        // Select a usuarios para ver si existe.
                        $usuari = $db->getUsuari($_POST["usuari"]);
                        if(!is_null($usuari)){
                            // Generem el token per aquest usuari.
                            $token = $db->generarToken($usuari["id"]);
                            if(!is_null($token)){
                                echo '{"codi_error":"0","token":"'.$token.'"}';
                            }else{ echo $errors["7"]; }
                        }else{ echo $errors["6"]; }
                    }else{ echo $errors["5"]; }
                }else{ echo $errors["4"]; }

    break;
    
    default:
        echo $errors["1"];
    break;
    
}

?>