<?php
ini_set('display_errors', 1);
// API > logout

// Classes necesàries
require ('../../utils/errors.php');
require ('../../utils/Database.php');
$db = new Database();

// Rebem les peticions de l'usuari
header("Content-Type: application/json");
switch($_SERVER["REQUEST_METHOD"]){
    
    case 'POST':
        
        if(isset($_POST["id"])){
            if(isset($_POST["token"])){
                $db->tancarToken($_POST["id"],$_POST["token"]);
                echo '{"codi_error":"0","accio":"logout","descripcio":"Ha tancat sessió correctament."}';
            }else{ echo $errors["26"]; }
        }else{ echo $errors["23"]; }
        
    break;
    
    default:
        echo $errors["1"];
    break;
    
}

?>