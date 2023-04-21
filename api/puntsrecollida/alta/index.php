<?php
// API > puntsrecollida > alta
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
                    if(isset($_POST["latitud"])){ $latitud = $_POST["latitud"]; if($latitud==""){ $latitud = null; } }else{ $latitud = null; }
                    if(isset($_POST["longitud"])){ $longitud = $_POST["longitud"]; if($longitud==""){ $longitud = null; } }else{ $longitud = null; }
                    if(isset($_POST["carrer"])){ $carrer = $_POST["carrer"];  if($carrer==""){ $carrer = null; }}else{ $carrer = null; }
                    if(isset($_POST["cp"])){ $cp = $_POST["cp"]; if($cp==""){ $cp = null; } }else{ $cp = null; }
                    if(isset($_POST["poblacio"])){ $poblacio = $_POST["poblacio"]; if($poblacio==""){ $poblacio = null; } if($poblacio=="0"){ $poblacio = null; } }else{ $poblacio = null; }
                    if(isset($_POST["horari"])){ $horari = $_POST["horari"];  if($horari==""){ $horari = null; }}else{ $horari = null; }
                    if(isset($_POST["actiu"])){ $actiu = $_POST["actiu"]; if(($actiu!="0")&&($actiu!="1")){ $actiu = "0";} }else{ $actiu = "0"; }
                    
                    // Control permís
                    if($permis == "1"){
                        
                        // Control dades
                        if( (!is_null($nom)) && (!is_null($descripcio)) && (!is_null($actiu)) && ($imatge != false) ){
                            
                            $extension = new SplFileInfo($_FILES["imatge"]["name"]);
                            $nomImatge = bin2hex(random_bytes(5));
                            $nomFinalImatge= $nomImatge . "." . $extension->getExtension();
                            if(move_uploaded_file($_FILES["imatge"]["tmp_name"], "/opt/lampp/htdocs/residueix/img/punts/" . $nomFinalImatge)){
                                echo $db->altaPunt($nom,$descripcio,$nomFinalImatge,$latitud,$longitud,$carrer,$cp,$poblacio,$horari,$actiu);
                            }else{ echo $errors["71"]; }
                            
                        }else{ echo $errors["70"]; }
                        
                    }else{ echo $errors["69"]; }
                    
                    
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