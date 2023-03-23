<?php
// API > usuaris > consulta 
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
         if(isset($_POST["id_usuari"])){
            $idUsuari = $_POST["id_usuari"];
            if(isset($_POST["token"])){
                $token = $_POST["token"];
                $tokenActiu = $db->validarToken($idUsuari,$token);
                if($tokenActiu == true){
        
                    if(isset($_POST["permis"])){ $permis =  $_POST["permis"]; }else{ $permis = null; } 
                    
                    if(isset($_POST["id"])){ $id =  $_POST["id"]; }else{ $id = null; } 
                    
                    
                    switch($permis){
                        
                        // Administrador o treballador pot consultar qualsevol usuari.
                        case 1:
                        case 2:
                            $consulta = $db->consultaUsuari($id);
                            if(!is_null($consulta)){
                                echo $consulta;
                            }else{
                                echo $errors["39"];
                            }
                            break;
                        
                        // Residuent/adherit pot consultar el seu propi usuari
                        case 3:
                        case 4:
                            if($idUsuari == $id){
                                $consulta = $db->consultaUsuari($id);
                                if(!is_null($consulta)){
                                    echo $consulta;
                                }else{
                                    echo $errors["39"];
                                }
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