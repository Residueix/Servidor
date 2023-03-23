<?php
ini_set('display_errors', 1);

// Javier Valverde Lozano
Class Database{
    
    private $conn;
    
    public function __construct(){
        $this->conn = new mysqli('localhost', 'residueix', 'R3s1du31X', 'ResidueixDB'); 
    }
    
    /*
     * Mètode per loginarse
     * @Params: $usuari i $password: Id i password de l'usuari
    */
    public function login($usuari,$password){
        $select = "SELECT id, tipus, email, password, nom, cognom1, cognom2, telefon, actiu FROM usuaris WHERE email = '".$usuari."' AND password = '".$password."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return array(
                        "id"=>$rs["id"],
                        "tipus"=>$rs["tipus"],
                        "email"=>$rs["email"],
                        "password"=>$rs["password"],
                        "nom"=>$rs["nom"],
                        "cognom1"=>$rs["cognom1"],
                        "cognom2"=>$rs["cognom2"],
                        "telefon"=>$rs["telefon"],
                        "actiu"=>$rs["actiu"]
                   );
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per recuperar les dades s'un usuari concret.
     * @Params: $idUsuari (integer): Id de l'usuari a buscar. 
    */
    public function getUsuari($idUsuari){
        $select = "SELECT id, tipus, email, password, nom, cognom1, cognom2, telefon, actiu FROM usuaris WHERE id = '".$idUsuari."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return array("id"=>$rs["id"],"tipus"=>$rs["tipus"],"email"=>$rs["email"],"password"=>$rs["password"],"nom"=>$rs["nom"],"cognom1"=>$rs["cognom1"],"cognom2"=>$rs["cognom2"],"telefon"=>$rs["telefon"],"actiu"=>$rs["actiu"]);
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per veure si existeix un usuari al sistema
     * @Params: $email (varchar): email de l'usuari a buscar 
    */
    public function existeixUsuari($email){
        $select = "SELECT * FROM usuaris WHERE email = '".$email."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * Mètode per veure si existeix un usuari al sistema
     * @Params: $id (int): identificador de l'usuari
    */
    public function existeixUsuariId($id){
        $select = "SELECT * FROM usuaris WHERE id = '".$id."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }
    
    /*
     * Mètode per passar a inactiu si existeix l'usuari al sistema
     * @Params: $idUsuari (integer): Id de l'usuari a buscar.
    */
    public function baixaUsuari($idUsuari){
        $update = "UPDATE usuaris SET actiu = '0' WHERE id = '".$idUsuari."'";
        $this->conn->query($update);
    }
    
    /*
     * Mètode per consultar un usuari del sistema
     * @Params: $idUsuari (integer): Id de l'usuari a buscar.
    */
    public function consultaUsuari($idUsuari){
        
        $select = "SELECT ";
        $select .= "usu.id as id, ";
        $select .= "usu.email as email, ";
        $select .= "usu.password as password, ";
        $select .= "usu.nom as nom, ";
        $select .= "usu.cognom1 as cognom1, ";
        $select .= "usu.cognom2 as cognom2, ";
        $select .= "usu.telefon as telefon, ";
        $select .= "usu.actiu as actiu, ";
        $select .= "adr.carrer as carrer, ";
        $select .= "adr.cp as cp, ";
        $select .= "adr.poblacio as poblacio, ";
        $select .= "adh.nom as nomAdherit, ";
        $select .= "adh.horari as horari, ";
        $select .= "adh.tipus as tipusAdherit ";
        $select .= "FROM usuaris usu ";
        $select .= "LEFT JOIN adresa adr ON adr.usuari = usu.id ";
        $select .= "LEFT JOIN adherit adh ON adh.usuari = usu.id ";
        $select .= "WHERE usu.id = '".$idUsuari."'";
        $this->conn->query($select);
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return '{ "codi_error":"0","id":"'.$rs["id"].'","email":"'.$rs["email"].'","password":"'.$rs["password"].'","nom":"'.$rs["nom"].'","cognom1":"'.$rs["cognom1"].'","cognom2":"'.$rs["cognom2"].'","telefon":"'.$rs["telefon"].'","actiu":"'.$rs["actiu"].'","carrer":"'.$rs["carrer"].'","cp":"'.$rs["cp"].'","poblacio":"'.$rs["poblacio"].'","nomAdherit":"'.$rs["nomAdherit"].'","horari":"'.$rs["horari"].'","tipusAdherit":"'.$rs["tipusAdherit"].'" }';
        }else{
            return null;
        }
        
        
    }
    
    /*
     * Mètode per recuperar les poblacions (pot ser filtar pre provincia)
     * @Params: $provincia (opcional).
    */
    public function llistaPoblacions($provincia){
        if(is_null($provincia)){
            $select = "SELECT po.id as id, po.nom as nom, po.provincia as id_provincia, ";
            $select .= "pr.nom as nom_provincia ";
            $select .= "FROM poblacions po ";
            $select .= "LEFT JOIN provincies pr ON pr.id = po.provincia ";
            $select .= "ORDER BY po.nom";
        }else{
            $select = "SELECT po.id as id, po.nom as nom, po.provincia as id_provincia, ";
            $select .= "pr.nom as nom_provincia ";
            $select .= "FROM poblacions po ";
            $select .= "LEFT JOIN provincies pr ON pr.id = po.provincia ";
            $select .= "WHERE po.provincia = ".$provincia." ";
            $select .= "ORDER BY po.nom"; 
        }        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{"id":"'.$rs["id"].'","nom":"'.$rs["nom"].'","id_provincia":"'.$rs["id_provincia"].'","nom_provincia":"'.$rs["nom_provincia"].'"}';
            } 
            $json .= ']}';
            return $json;
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per recuperar els tipus d'usuari existents
     * @Params: sense.
    */
    public function llistatTipusUsuari(){
        $select = "SELECT id, nom ";
        $select .= "FROM tipus_usuari ";
        $select .= "ORDER BY id ASC";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{"id":"'.$rs["id"].'","nom":"'.$rs["nom"].'"}';
            } 
            $json .= ']}';
            return $json;
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per recuperar els tipus d'usuari existents
     * @Params: sense.
    */
    public function llistatTipusAdherit(){
        $select = "SELECT id, nom ";
        $select .= "FROM tipus_adherit ";
        $select .= "ORDER BY nom ASC";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{"id":"'.$rs["id"].'","nom":"'.$rs["nom"].'"}';
            } 
            $json .= ']}';
            return $json;
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per recuperar els usuaris
     * @Params: sense
    */
    public function llistatUsuaris($ordre,$tipus,$actiu){
        
        $select = "SELECT id, tipus, email, password, nom, cognom1, cognom2, telefon, actiu FROM usuaris ";
        
        // Comprovem si ens arriba tipus i actiu
        $filtres = "";
        if(!is_null($tipus)){ 
            if( ($tipus == "1") || ($tipus == "2") || ($tipus == "3") || ($tipus == "4")){
                $filtres .= "tipus";
            }
        }
        if(!is_null($actiu)){
            if( ($actiu == "0") || ($actiu == "1")){
                $filtres .= "actiu";
            } 
        }
        
        switch($filtres){
            case "tipus":
                 $select .= "WHERE tipus = '".$tipus."' ";
                break;
            case "tipusactiu":
                $select .= "WHERE tipus = '".$tipus."' AND actiu = '".$actiu."' ";
                break;
            case "actiu":
                $select .= "WHERE actiu = '".$actiu."' ";
                break;
            default:
                // Sense filtres
                break;
        }
        
        switch($ordre){
                case "nom":
                    $select .= "ORDER BY nom ASC";
                    break;
                case "cognoms":
                    $select .= "ORDER BY cognom1 ASC, cognom2 ASC, nom ASC";
                    break;
                case "email":
                    $select .= "ORDER BY email ASC";
                    break;
                default:
                    $select .= "ORDER BY nom ASC";
                    break;
        }
        
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{';
                $json .= '"id":"'.$rs["id"].'",';
                $json .= '"tipus":"'.$rs["tipus"].'",';
                $json .= '"email":"'.$rs["email"].'",';
                $json .= '"password":"'.$rs["password"].'",';
                $json .= '"nom":"'.$rs["nom"].'",';
                $json .= '"cognom1":"'.$rs["cognom1"].'",';
                $json .= '"cognom2":"'.$rs["cognom2"].'",';
                $json .= '"telefon":"'.$rs["telefon"].'",';
                $json .= '"actiu":"'.$rs["actiu"].'"';
                $json .= '}';
            } 
            $json .= "]}";
            return $json;
        }else{
            return '{"codi_error":"0","llistat":[]}';
        }
    }
    
    /*
     * Mètode per donar d'alta un usuari administrador.
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus (dades per donar d'alta un usuari).
    */
    public function crearUsuariAdministrador($email,$password,$nom,$cognom1,$cognom2,$telefon,$actiu,$tipus){
        
        $insert = "INSERT INTO usuaris (email,password,nom,cognom1,cognom2,telefon,tipus,actiu) VALUES ";
        $insert .= "(";
        $insert .= "'".$email."',";
        $insert .= "'".$password."',";
        $insert .= "'".$nom."',";
        $insert .= "'".$cognom1."',";
        if(!is_null($cognom2)){
            $insert .= "'".$cognom2."',";
        }else{
            $insert .= "'',";
        }
        $insert .= "'".$telefon."',";
        $insert .= "'".$tipus."',";
        $insert .= "'".$actiu."'";
        $insert .= ")";
        $this->conn->query($insert);
        return mysqli_insert_id($this->conn);
        
    }
    
    /*
     * Mètode per donar d'alta un usuari treballador del punt de recollida.
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus (dades per donar d'alta un usuari).
    */
    public function crearUsuariTreballador($email,$password,$nom,$cognom1,$cognom2,$telefon,$actiu,$tipus){
        
        $insert = "INSERT INTO usuaris (email,password,nom,cognom1,cognom2,telefon,tipus,actiu) VALUES ";
        $insert .= "(";
        $insert .= "'".$email."',";
        $insert .= "'".$password."',";
        $insert .= "'".$nom."',";
        $insert .= "'".$cognom1."',";
        if(!is_null($cognom2)){
            $insert .= "'".$cognom2."',";
        }else{
            $insert .= "'',";
        }
        $insert .= "'".$telefon."',";
        $insert .= "'".$tipus."',";
        $insert .= "'".$actiu."'";
        $insert .= ")";
        $this->conn->query($insert);
        return mysqli_insert_id($this->conn);
        
    }
    
    /*
     * Mètode per donar d'alta un usuari residuent
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus, $carrer, $cp i $poblacio (dades per donar d'alta un usuari).
    */
    public function crearUsuariResiduent($email,$password,$nom,$cognom1,$cognom2,$telefon,$actiu,$tipus,$carrer,$poblacio,$cp){
        
        $insert = "INSERT INTO usuaris (email,password,nom,cognom1,cognom2,telefon,tipus,actiu) VALUES ";
        $insert .= "(";
        $insert .= "'".$email."',";
        $insert .= "'".$password."',";
        $insert .= "'".$nom."',";
        $insert .= "'".$cognom1."',";
        if(!is_null($cognom2)){
            $insert .= "'".$cognom2."',";
        }else{
            $insert .= "'',";
        }
        $insert .= "'".$telefon."',";
        $insert .= "'".$tipus."',";
        $insert .= "'".$actiu."'";
        $insert .= ")";
        $this->conn->query($insert);
        $idInsertatUsuari =  mysqli_insert_id($this->conn);
        
        $insert = "INSERT INTO adresa (usuari,carrer, cp, poblacio) VALUES ";
        $insert .= "(";
        $insert .= "'".$idInsertatUsuari."',";
        $insert .= "'". str_replace("'","\'", $carrer)."',";
        $insert .= "'".$cp."',";
        $insert .= "'".$poblacio."'";
        $insert .= ")";
        $this->conn->query($insert);
        
        $insert = "INSERT INTO saldo (usuari) VALUES ";
        $insert .= "(";
        $insert .= "'".$idInsertatUsuari."'";
        $insert .= ")";
        $this->conn->query($insert);
        
        return $idInsertatUsuari;
        
        
    }
   
     /*
     * Mètode per donar d'alta un usuari adherit
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus, $carrer, $cp, $poblacio, $nomEmpresa, $horari (dades per donar d'alta un usuari).
    */
    public function crearUsuariAdherit($email,$password,$nom,$cognom1,$cognom2,$telefon,$actiu,$tipus,$carrer,$poblacio,$cp,$nomAdherit,$horari,$tipusAdherit){
        
        $insert = "INSERT INTO usuaris (email,password,nom,cognom1,cognom2,telefon,tipus,actiu) VALUES ";
        $insert .= "(";
        $insert .= "'".$email."',";
        $insert .= "'".$password."',";
        $insert .= "'".$nom."',";
        $insert .= "'".$cognom1."',";
        if(!is_null($cognom2)){
            $insert .= "'".$cognom2."',";
        }else{
            $insert .= "'',";
        }
        $insert .= "'".$telefon."',";
        $insert .= "'".$tipus."',";
        $insert .= "'".$actiu."'";
        $insert .= ")";
        $this->conn->query($insert);
        $idInsertatUsuari =  mysqli_insert_id($this->conn);
        
        $insert = "INSERT INTO adresa (usuari,carrer, cp, poblacio) VALUES ";
        $insert .= "(";
        $insert .= "'".$idInsertatUsuari."',";
        $insert .= "'". str_replace("'","\'", $carrer)."',";
        $insert .= "'".$cp."',";
        $insert .= "'".$poblacio."'";
        $insert .= ")";
        $this->conn->query($insert);
        
        $insert = "INSERT INTO saldo (usuari) VALUES ";
        $insert .= "(";
        $insert .= "'".$idInsertatUsuari."'";
        $insert .= ")";
        $this->conn->query($insert);
        
        $insert = "INSERT INTO adherit (usuari,tipus,nom,horari) VALUES ";
        $insert .= "(";
        $insert .= "'".$idInsertatUsuari."',";
        $insert .= "'".$tipusAdherit."',";
        $insert .= "'".$nomAdherit."',";
        $insert .= "'".$horari."'";
        $insert .= ")";
        $this->conn->query($insert);
        
        return $idInsertatUsuari;
        
        
    }
    
    /*
     * Mètode per modificar un usuari administrador.
     * @Params: $id, $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus, $actiu (dades per modificar un usuari).
    */
    public function modificarUsuariAdministrador($id,$email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus,$actiu){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "email = '".$email."',";
        $update .= "password = '".$password."',";
        $update .= "nom = '".$nom."',";
        $update .= "cognom1 = '".$cognom1."',";
        $update .= "cognom2 = '".$cognom2."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."'";
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariTreballador($id,$email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus,$carrer,$poblacio,$cp){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."',";
        $update .= "email = '".$email."',";
        $update .= "password = '".$password."',";
        $update .= "nom = '".$nom."',";
        $update .= "cognom1 = '".$cognom1."',";
        $update .= "cognom2 = '".$cognom2."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "WHERE id = '".$id."'";
        
        
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariResiduent($id,$email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus,$carrer,$poblacio,$cp){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."',";
        $update .= "email = '".$email."',";
        $update .= "password = '".$password."',";
        $update .= "nom = '".$nom."',";
        $update .= "cognom1 = '".$cognom1."',";
        $update .= "cognom2 = '".$cognom2."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "carrer = '".$carrer."',";
        $update .= "poblacio = '".$poblacio."',";
        $update .= "cp = '".$cp."',";
        $update .= "WHERE id = '".$id."'";
        
        
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariAdherit($id,$email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus,$actiu,$carrer,$poblacio,$cp,$nomEmpresa,$horari){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."',";
        $update .= "email = '".$email."',";
        $update .= "password = '".$password."',";
        $update .= "nom = '".$nom."',";
        $update .= "cognom1 = '".$cognom1."',";
        $update .= "cognom2 = '".$cognom2."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "actiu = '".$actiu."',";
        $update .= "carrer = '".$carrer."',";
        $update .= "poblacio = '".$poblacio."',";
        $update .= "cp = '".$cp."',";
        $update .= "nomEmpresa = '".$nomEmpresa."',";
        $update .= "horari = '".$horari."',";
        $update .= "WHERE id = '".$id."'";
        
        
        $this->conn->query($update);
        
    }
    
    /*
     * Mètode per generar el token per un usuari en concret.
     * @Params: $idUsuari (integer): Id de l'usuari que vol el token.
     */
    public function generarToken($idUsuari){
        // Token i dates
        $token = bin2hex(random_bytes(12));
        $dataActual = date('Y-m-d H:i:s');
        $dataSetmana = date('Y-m-d H:i:s', strtotime($dataActual. ' + 1 week'));
        // Primer tanquem qualsevol token que tingués obert aquest usuari
        $update ="UPDATE acces SET data_fi = '".$dataActual."', actiu = 0 WHERE usuari = '".$idUsuari."' AND actiu = 1";
        $this->conn->query($update);
        // Ara demanem el nou token.
        $insert = "INSERT into acces (usuari, token, data_inici, data_caducitat, actiu) VALUES (".$idUsuari.",'".$token."','".$dataActual."','".$dataSetmana."',1)";
        $resultat = $this->conn->query($insert);
        if($resultat){
            return $token;
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per tancar el token d'un usuari
     * @Params: $idUsuari (integer) $token (varchar): Id de l'usuari que fa la petició i el seu token.
     */
    public function tancarToken($idUsuari,$token){
        $dataActual = date('Y-m-d H:i:s');
        $update = "UPDATE acces SET actiu = 0 , data_fi = '".$dataActual."' WHERE token = '".$token."' AND usuari = '".$idUsuari."' ";
        $this->conn->query($update);
    }
    
    /*
     * Mètode comprovar que l'usuari te un token per processar la petició.
     * @Params: $idUsuari (integer) $token (varchar): Id de l'usuari que fa la petició i el seu token.
     */
    public function validarToken($idUsuari,$token){
        $dataActual = date('Y-m-d H:i:s');
        $select = "SELECT id FROM acces WHERE usuari = ".$idUsuari." AND token = '".$token."' AND actiu = 1 AND data_inici < '".$dataActual."' AND data_caducitat > '".$dataActual."' ";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            return true;
        }else{
            return false;
        }
    }


}

?>