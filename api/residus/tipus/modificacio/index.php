<?php
// API > residus > tipus > modificació
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
                    if(isset($_POST["nom"])){ $nom = $_POST["nom"]; if( trim($nom) == ""){ $nom = null; } }else{ $nom = null; }
                    if(isset($_FILES["imatge"])){ $imatge = true; }else{ $imatge = false; }
                    
                    if($permis == "1" || $permis == "2"){
                        
                        if((!is_null($id)) && (!is_null($nom))){
                            
                            if($imatge){
                                $extension = new SplFileInfo($_FILES["imatge"]["name"]);
                                $nomImatge = bin2hex(random_bytes(5));
                                $nomFinalImatge= $nomImatge . "." . $extension->getExtension();
                                if(move_uploaded_file($_FILES["imatge"]["tmp_name"], "/opt/lampp/htdocs/residueix/img/residus/tipus/" . $nomFinalImatge)){
                                    echo $db->modificarTipusResidu($id,$nom,$nomFinalImatge);
                                }else{
                                    echo $errors["44"];
                                }
                            }else{
                               echo $db->modificarTipusResidu($id,$nom,null); 
                            } 
                       }else{
                            echo $errors["47"];
                        }
                        
                    }else{
                        echo $errors["46"];
                    }
                    
                    
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