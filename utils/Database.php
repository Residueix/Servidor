<?php
ini_set('display_errors', 1);
    
Class Database{
    
    private $conn;
    
    public function __construct(){
        $this->conn = new mysqli('localhost', 'residueix', 'R3s1du31X', 'ResidueixDB'); 
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
     * Mètode per recuperar les poblacions (pot ser filtar pre provincia)
     * @Params: $provincia (opcional).
    */
    public function llistaPoblacions($provincia){
        if(is_null($provincia)){
            $select = "SELECT id, nom FROM poblacions ORDER BY nom";
        }else{
            $select = "SELECT id, nom FROM poblacions WHERE provincia = ".$provincia." ORDER BY nom";   
        }
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $json = "{";
            while($rs = $r->fetch_assoc()){
                $json .= '"'.$rs["id"].'":"'.$rs["nom"].'",';
            } 
            $json .= "}";
            return $json;
        }else{
            return null;
        }
    }
    
    /*
     * Mètode per donar d'alta un usuari administrador.
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus (dades per donar d'alta un usuari).
    */
    public function crearUsuariAdministrador($email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus){
        
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
        $insert .= "1";
        $insert .= ")";
        $this->conn->query($insert);
        return mysqli_insert_id($this->conn);
        
    }
    
        /*
     * Mètode per donar d'alta un usuari treballador del punt de recollida.
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus (dades per donar d'alta un usuari).
    */
    public function crearUsuariTreballador($email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus){
        
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
        $insert .= "1";
        $insert .= ")";
        $this->conn->query($insert);
        return mysqli_insert_id($this->conn);
        
    }
    
       /*
     * Mètode per donar d'alta un usuari residuent
     * @Params: $email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus, $carrer, $cp i $poblacio (dades per donar d'alta un usuari).
    */
    public function crearUsuariResiduent($email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus,$carrer,$poblacio,$cp){
        
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
        $insert .= "1";
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