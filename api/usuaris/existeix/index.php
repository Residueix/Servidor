<?php
// API > usuaris > existeix

// Classes necesàries
require ('../../../utils/errors.php');
require ('../../../utils/Database.php');
$db = new Database($errors);

// Rebem les peticions de l'usuari
header("Content-Type: application/json");

switch($_SERVER["REQUEST_METHOD"]){

    // Opció POST, correcta.
    case 'POST':
        
        if(isset($_POST["email"])){ $email =  $_POST["email"]; }else{ $email = null; } 
         
        $existeix = $db->existeixUsuariLogin($email);
        if(!is_null($existeix)){
           echo $existeix;
        }else{
           echo $errors["40"];
        }
        
        
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

                    
?>