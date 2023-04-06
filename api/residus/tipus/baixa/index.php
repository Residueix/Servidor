<?php
// API > residus > tipus > baixa
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
        // Control token
        if(isset($_POST["id_usuari"])){
            $idUsuari = $_POST["id_usuari"];
            if(isset($_POST["token"])){
                $token = $_POST["token"];
                $tokenActiu = $db->validarToken($idUsuari,$token);
                if($tokenActiu == true){
                    
                    if(isset($_POST["permis"])){ $permis = $_POST["permis"]; }else{ $permis = null; }
                    if(isset($_POST["id"])){ $id = $_POST["id"]; }else{ $id = null; }
                    if($permis == "1" || $permis == "2"){
                        if((!is_null($id))){
                            echo $db->baixaTipusResidu($id);
                                // Dar de baja el tipo
                            }else{
                                echo $errors["58"];
                            }
                            
                        }else{
                            echo $errors["59"];
                        }
                        
                    }else{
                        echo $errors["60"];
                    }
                    
                    
                }else{ echo $errors["16"]; }
            }else{ echo $errors["15"]; }
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>
