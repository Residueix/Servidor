<?php
// API > esdeveniments > alta
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
                    if(isset($_POST["nom"])){ $nom = $_POST["nom"]; if($nom==""){ $nom = null; } }else{ $nom = null; }
                    if(isset($_POST["descripcio"])){ $descripcio = $_POST["descripcio"]; if($descripcio==""){ $descripcio = null; } }else{ $descripcio = null; }
                    if(isset($_FILES["imatge"])){ $imatge = true; }else{ $imatge = false; }
                    if(isset($_POST["valor"])){ $valor = $_POST["valor"]; if($valor==""){ $valor = null; } }else{ $valor = null; }
                    if(isset($_POST["aforament"])){ $aforament = $_POST["aforament"]; if($aforament==""){ $aforament = null; } }else{ $aforament = null; }                    
                    if(isset($_POST["data"])){ $data = $_POST["data"]; if($data==""){ $data = null; } }else{ $data = null; }
                    if(isset($_POST["hora"])){ $hora = $_POST["hora"]; if($hora==""){ $hora = null; } }else{ $hora = null; }                    
                    if(isset($_POST["poblacio"])){ $poblacio = $_POST["poblacio"]; if($poblacio==""){ $poblacio = null; } if($poblacio=="0"){ $poblacio = null; } }else{ $poblacio = null; }
                    if(isset($_POST["actiu"])){ $actiu = $_POST["actiu"]; if(($actiu!="0")&&($actiu!="1")){ $actiu = "0";} }else{ $actiu = "0"; }
                    
                    // Control permís
                    if($permis == "1"){
                        
                        // Control dades
                        if( (!is_null($nom)) && (!is_null($descripcio)) && (!is_null($valor)) && (!is_null($aforament)) && (!is_null($data)) && (!is_null($hora)) && (!is_null($poblacio)) && (!is_null($actiu)) && ($imatge != false) ){
                            
                            $extension = new SplFileInfo($_FILES["imatge"]["name"]);
                            $nomImatge = bin2hex(random_bytes(5));
                            $nomFinalImatge= $nomImatge . "." . $extension->getExtension();
                            
                            if(move_uploaded_file($_FILES["imatge"]["tmp_name"], "/opt/lampp/htdocs/residueix/img/esdeveniments/" . $nomFinalImatge)){
                                
                                echo $db->altaEsdeveniment($nom,$descripcio,$valor,$aforament,$data,$hora,$poblacio,$nomFinalImatge,$actiu);
                            
                                
                            }else{ echo $errors["88"]; }
                            
                        }else{ echo $errors["87"]; }
                        
                    }else{ echo $errors["86"]; }
                    
                    
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