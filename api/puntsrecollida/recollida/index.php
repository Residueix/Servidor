<?php
// API > puntsrecollida > recollida
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
                    
                    
                    
                    // Recollim dades
                    if(isset($_POST["permis"])){ $permis = $_POST["permis"]; }else{ $permis = null; }
                    if(isset($_POST["recollida"])){ $recollida = $_POST["recollida"]; }else{ $recollida = null; }
                    
                    // Control permís
                    if($permis == "2"){
                        
                        // Control dades
                        if( !is_null($recollida) ){
                            
                            
                            $dades = json_decode($recollida);
                            
                            $idTransaccio = $db->altaTransaccio($dades->punt,$dades->usuari,$dades->total);
                            
                            $saldo = $db->afegirSaldo($dades->usuari,$dades->total);
                            
                            if($idTransaccio!="0"){
                                
                                if($saldo==true){
                                    
                                    // recorrem el json i anem ficant les dades a recollida
                                    $estat = true;
                                    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
                                    foreach ($dades->llistat as $residu) {
                                        try{
                                            $retorn = $db->altaRecollida($residu->id_residu,$residu->quantitat,$residu->valor,$idTransaccio);
                                            if(!$retorn){
                                                // Si hi ha error eliminem la transacció que hem ficat i mostrem error.
                                                echo $errors["81"];
                                                $db->baixaPermanentTransaccio($idTransaccio);
                                                $estat = false;
                                                break;    
                                            }
                                        } catch (Exception $exc) {
                                            // Si hi ha error eliminem la transacció que hem ficat i mostrem error.
                                            echo $errors["81"];
                                            $db->baixaPermanentTransaccio($idTransaccio);
                                            $estat = false;
                                            break;
                                        }
                                    }
                                    if($estat){
                                        echo '{"codi_error":"0","descripcio":"Recollida guardada correctament."}';
                                    }
                                    
                                    
                                    
                                }else{
                                    echo $errors["83"];
                                    $db->baixaPermanentTransaccio($idTransaccio);    
                                }
                                
                            }else{ echo $errors["80"]; }
                            
                        }else{ echo $errors["79"]; }
                        
                    }else{ echo $errors["78"]; }
                    
                    
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