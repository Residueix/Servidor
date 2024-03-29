<?php
// API > usuaris > alta > adherit
// Javier Valverde Lozano
// Classes necesàries
require ('../../../../utils/errors.php');
require ('../../../../utils/Database.php');
$db = new Database($errors);

// Rebem les peticions de l'usuari
header("Content-Type: application/json");

switch($_SERVER["REQUEST_METHOD"]){

    // Opció POST, correcta.
    case 'POST':
         if(isset($_POST["id_usuari"])){
            $idUsuari = $_POST["id_usuari"];
            if(isset($_POST["token"])){
                $token = $_POST["token"];
                $tokenActiu = $db->validarToken($idUsuari,$token);
                if($tokenActiu == true){
        
                    // Dades de l'usuari administrador pasades per paràmetre
                    if(isset($_POST["tipus"])){ $tipus =  $_POST["tipus"]; }else{ $tipus = null; } 
                    if(isset($_POST["email"])){ $email =  $_POST["email"]; }else{ $email = null; }
                    if(isset($_POST["password"])){ $password =  $_POST["password"]; }else{ $password = null; } 
                    if(isset($_POST["nom"])){ $nom =  $_POST["nom"]; }else{ $nom = null; } 
                    if(isset($_POST["cognom1"])){ $cognom1 =  $_POST["cognom1"]; }else{ $cognom1 = null; } 
                    if(isset($_POST["cognom2"])){ $cognom2 =  $_POST["cognom2"]; }else{ $cognom2 = null; } 
                    if(isset($_POST["telefon"])){ $telefon =  $_POST["telefon"]; }else{ $telefon = null; } 
                    if(isset($_POST["actiu"])){ $actiu =  $_POST["actiu"]; }else{ $actiu = "1"; } 
                    if(isset($_POST["carrer"])){ $carrer =  $_POST["carrer"]; }else{ $carrer = null; } 
                    if(isset($_POST["poblacio"])){ $poblacio =  $_POST["poblacio"]; }else{ $poblacio = null; } 
                    if(isset($_POST["cp"])){ $cp =  $_POST["cp"]; }else{ $cp = null; } 
                    if(isset($_POST["nom_adherit"])){ $nomAdherit =  $_POST["nom_adherit"]; }else{ $nomAdherit = null; } 
                    if(isset($_POST["horari"])){ $horari =  $_POST["horari"]; }else{ $horari = null; } 
                    if(isset($_POST["tipus_adherit"])){ $tipusAdherit =  $_POST["tipus_adherit"]; }else{ $tipusAdherit = null; } 
                    // control
                    if(isset($_POST["permis"])){ $permis =  $_POST["permis"]; }else{ $permis = null; } 
                    
                    if($permis == 1){
                        if( ($email != null) && ($password != null) && ($nom != null) && ($cognom1 != null) && ($tipus != null) && ($telefon != null) && ($carrer != null) && ($cp != null) && ($poblacio != null) && ($horari != null) && ($nomAdherit != null) && ($tipusAdherit != null)){
                            if($tipus == 4){
                            // Comprovem si aquest email ja té usuari
                                $existeix = $db->existeixUsuari($email);
                                    if(!$existeix){
                                    $idInsertat = $db->crearUsuariAdherit($email, $password, $nom, $cognom1, $cognom2, $telefon, $actiu, $tipus,$carrer,$poblacio,$cp,$nomAdherit,$horari,$tipusAdherit);
                                    echo '{"codi_error":"0","accio":"alta","descripcio":"S\'ha donat d\'alta l\'usuari: '.$email.'","id":"'.$idInsertat.'"}';
                                }else{ echo $errors["20"]; } 
                            }else{ echo $errors["28"]; }
                        }else{ echo $errors["18"]; } 
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