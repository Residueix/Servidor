<?php
// API > global > tipusadherit
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
                        
                        $llistatTipusAdherit = $db-> llistatTipusAdherit();
                        echo $llistatTipusAdherit;
                        
            }else{ echo $errors["66"]; }
            
        }else{ echo $errors["15"]; }
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>