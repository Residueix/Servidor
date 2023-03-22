<?php
// API > usuaris > llistat

// Classes necesàries
require ('../../../utils/errors.php');
require ('../../../utils/Database.php');
$db = new Database();

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
                        if(isset($_POST["filtre"])){ $filtre =  $_POST["filtre"]; }else{ $filtre = null; }
                        if(isset($_POST["parametre_filtre"])){ $parametreFiltre =  $_POST["parametre_filtre"]; }else{ $parametreFiltre = null; }
                        
                        $llistatUsuaris = $db-> llistatUsuaris($ordre,$filtre,$parametreFiltre);
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