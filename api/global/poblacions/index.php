<?php
// API > global > poblacions
// Javier Valverde Lozano

// Classes necesàries
require ('../../../utils/errors.php');
require ('../../../utils/Database.php');
$db = new Database();

// Rebem les peticions de l'usuari
header("Content-Type: application/json");

switch($_SERVER["REQUEST_METHOD"]){

    // Opció POST, correcta.
    case 'POST':
        
        if(isset($_POST["provincia"])){ $provincia =  $_POST["provincia"]; }else{ $provincia = null; } 
         
        $llistaPoblacions = $db->llistaPoblacions($provincia);
        if(!is_null($llistaPoblacions)){
           echo $llistaPoblacions;
        }else{
           echo $errors["21"];
        }
        
        
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>