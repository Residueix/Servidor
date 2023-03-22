<?php
// API > usuaris > baixa 

// Classes necesàries
require ('../../../utils/errors.php');
require ('../../../utils/Database.php');
$db = new Database();

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
        
                    if(isset($_POST["permis"])){ $permis =  $_POST["permis"]; }else{ $permis = null; } 
                    
                    if(isset($_POST["id"])){ $id =  $_POST["id"]; }else{ $id = null; } 
                    
                    switch($permis){
                        
                        // Administrador pot donar de baixa qualsevol usuari
                        case 1:
                            $db->baixaUsuari($id);
                            echo '{"codi_error":"0","accio":"baixa","descripcio":"S\'ha donat de baixa amb l\'id":"'.$id.'"}';
                            break;
                        
                        // Residuent/adherit pot donar de baixa el seu propi usuari
                        case 3 OR 4:
                            if($idUsuari == $id){
                                $db->baixaUsuari($id);
                                echo '{"codi_error":"0","accio":"baixa","descripcio":"S\'ha donat de baixa amb l\'id":"'.$id.'"}';
                            }else{
                              echo $errors["11"];  
                            }
                            break;
                        
                        // La resta no té permís.
                        default:
                            echo $errors["11"];
                            break;
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