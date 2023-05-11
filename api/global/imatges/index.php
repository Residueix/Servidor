<?php
// API > global > imatges
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
        
       echo "Imatge " . $_FILES["imatge"]["name"];
        
        $extension = new SplFileInfo($_FILES["imatge"]["name"]);
        
        $nomImatge = bin2hex(random_bytes(5));
        
       move_uploaded_file($_FILES["imatge"]["tmp_name"], "../../../img/" . $nomImatge . "." . $extension->getExtension());
       
       echo "NOm imatge : " . $nomImatge;
       
       echo "otros " . $_POST["description"];
        
    break;
    
    // Opció per defecte, no és cap de les anteriors. Error.
    default:
        echo $errors["8"];
    break;
    
}

?>