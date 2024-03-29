<?php
// API > global > poblacions
// Javier Valverde Lozano

// Classes necesàries
require ('../../../utils/errors.php');
require ('../../../utils/Database.php');
$db = new Database($errors);

// Rebem les peticions de l'usuari
header("Content-Type: application/json");

switch($_SERVER["REQUEST_METHOD"]){

    // Opció POST, correcta.
    case 'POST':
        
        // Control token
        if(isset($_POST["token"])){
            
            // Control token vàlid
            if($_POST["token"] == $db->getToken()){
                
                // Paràmetres opcionals
                if(isset($_POST["provincia"])){ $provincia =  $_POST["provincia"]; if($provincia==""){ $provincia = null;} }else{ $provincia = null; } 
                
                // Crida a la funció per mostrar el llistat
                echo $db->llistatPoblacions($provincia);
                
            }else{ echo $errors["66"]; }
            
        }else{ echo $errors["15"]; }
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>