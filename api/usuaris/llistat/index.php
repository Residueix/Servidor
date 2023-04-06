<?php
// API > usuaris > llistat
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
        if(isset($_POST["id_usuari"])){
            $idUsuari = $_POST["id_usuari"];
            if(isset($_POST["token"])){
                $token = $_POST["token"];
                $tokenActiu = $db->validarToken($idUsuari,$token);
                if($tokenActiu == true){
                    
                    if(isset($_POST["permis"])){ $permis =  $_POST["permis"]; }else{ $permis = null; } 
                    // EL permís ha de ser 1 (usuari administrador)
                    if($permis == 1){
                        
                        if(isset($_POST["ordre"])){ $ordre =  $_POST["ordre"]; }else{ $ordre = null; }
                        if(isset($_POST["tipus"])){ $tipus =  $_POST["tipus"]; }else{ $tipus = null; }
                        if(isset($_POST["actiu"])){ $actiu =  $_POST["actiu"]; }else{ $actiu = null; }
                       
                        
                        $llistatUsuaris = $db-> llistatUsuaris($ordre,$tipus,$actiu);
                        echo $llistatUsuaris;
                        
                    }else { echo $errors["11"]; }
                    
                }else{ echo $errors["16"]; }
            }else{ echo $errors["15"]; }
        }else{ echo $errors["14"]; }
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>