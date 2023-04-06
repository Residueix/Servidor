<?php
ini_set('display_errors', 1);


// Javier Valverde Lozano
Class Database{
    
    private $conn;
    private $e;
    private $token;
    
    public function __construct($error){
        $this->conn = new mysqli('localhost', 'residueix', 'R3s1du31X', 'ResidueixDB'); 
        $this->e = $error;
        $this->token = '6e06ad1160adeafe010cebb9';
    }
    
    public function getToken(){
        return $this->token;
    }
    
    public function cometes($string){
        return str_replace("'", "\'", $string);
    }
    
    public function format($string){
        $retorn = str_replace("'", "\'", $string);
        $retorn = str_replace(["\r","\n","\r\n","\n\r"], "", $retorn);
        return $retorn;
    }
    
    /*
     * Mètode per loginarse
     * @Params: $usuari i $password: Id i password de l'usuari
    */
    public function login($usuari,$password){
        $select = "SELECT u.id as id, ";
        $select .= "u.tipus as tipus, ";
        $select .= "u.email as email, ";
        $select .= "u.password as password, ";
        $select .= "u.nom as nom, ";
        $select .= "u.cognom1 as cognom1, ";
        $select .= "u.cognom2 as cognom2, "; 
        $select .= "u.telefon as telefon, ";
        $select .= "u.actiu as actiu, ";
        $select .= "tu.nom as tipus_nom ";
        $select .= "FROM usuaris u ";
        $select .= "LEFT JOIN tipus_usuari tu ON u.tipus = tu.id ";
        $select .= "WHERE email = '".$usuari."' AND password = '".$password."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return array(
                        "id"=>$rs["id"],
                        "tipus"=>$rs["tipus"],
                        "tipus_nom"=>$rs["tipus_nom"],
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
     * Mètode per veure si existeix un usuari al sistema en el login
     * @Params: $email (varchar): email de l'usuari a buscar 
    */
    public function existeixUsuariLogin($email){
        $select = "SELECT id, email, password FROM usuaris WHERE email = '".$email."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return '{"codi_error":"0","accio":"consulta","descripcio":"Existeix aquest correu a la base de dades.","id":"'.$rs["id"].'","email":"'.$rs["email"].'","password":"'.$rs["password"].'"}';
        }else{
            return null;
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
     * Mètode per passar a inactiu si existeix el residu al sistema
     * @Params: $id (integer): Id del residu a buscar.
    */
    public function baixaResidu($id){
        $update = "UPDATE residus SET actiu = '0' WHERE id = '".$id."'";
        $this->conn->query($update);
        return '{"codi_error":"0","accio":"baixa","descripcio":"S\'ha donat de baixa el residu amb l\'id '.$id.'","id":"'.$id.'"}';
    }
    
    
    /*
     * Mètode per eliminar el tipus de residu al sistema
     * @Params: $id (varchar): id del tipus de residu a eliminar
    */
    public function baixaTipusResidu($id){
        
        $select = "SELECT r.id as idResidu, r.tipus as idTipusResidu, r.nom as nomResidu, r.imatge as imatgeResidu, r.descripcio as descripcioResidu, r.actiu as actiuResidu, r.valor as valorResidu, tr.nom as nomTipusResidu, tr.imatge as imatgeTipusResidu ";
        $select .= "FROM residus r ";
        $select .= "LEFT JOIN tipus_residu tr ON tr.id = r.tipus ";
        $select .= "WHERE tr.id = '".$id."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            return $this->e["57"];
        }else{
            $select = "SELECT imatge FROM tipus_residu WHERE id = '".$id."'";
            $r2 = $this->conn->query($select);
            $rs2 = $r2->fetch_assoc();
            $arxiu = "/opt/lampp/htdocs/residueix/img/residus/tipus/" . $rs2["imatge"];
            unlink($arxiu);
            $delete = "DELETE FROM tipus_residu WHERE id = '".$id."'";
            $r3 = $this->conn->query($delete);
            return '{"codi_error":"0","accio":"baixa","descripcio":"S\'ha eliminat el tipus de registre."}';
        }     
       
    }
    
    /*
     * Mètode per consultar un usuari del sistema
     * @Params: $idUsuari (integer): Id de l'usuari a buscar.
    */
    public function consultaUsuari($idUsuari){
        
        $select = "SELECT ";
        $select .= "usu.id as id, ";
        $select .= "usu.tipus as tipus, ";
        $select .= "tusu.nom as tipus_nom, ";
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
        $select .= "pob.nom as poblacio_nom, ";
        $select .= "pob.provincia as provincia, ";
        $select .= "pro.nom as provincia_nom, ";
        $select .= "adh.nom as nomAdherit, ";
        $select .= "adh.horari as horari, ";
        $select .= "adh.tipus as tipusAdherit, ";
        $select .= "tadh.nom as tipusAdherit_nom ";
        $select .= "FROM usuaris usu ";
        $select .= "LEFT JOIN tipus_usuari tusu ON usu.tipus = tusu.id ";
        $select .= "LEFT JOIN adresa adr ON adr.usuari = usu.id ";
        $select .= "LEFT JOIN poblacions pob ON adr.poblacio = pob.id ";
        $select .= "LEFT JOIN provincies pro ON pob.provincia = pro.id ";
        $select .= "LEFT JOIN adherit adh ON adh.usuari = usu.id ";
        $select .= "LEFT JOIN tipus_adherit tadh ON adh.tipus = tadh.id ";
        $select .= "WHERE usu.id = '".$idUsuari."'";
        $this->conn->query($select);
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            return '{ "codi_error":"0","id":"'.$rs["id"].'","tipus":"'.$rs["tipus"].'","tipus_nom":"'.$rs["tipus_nom"].'","email":"'.$rs["email"].'","password":"'.$rs["password"].'","nom":"'.$rs["nom"].'","cognom1":"'.$rs["cognom1"].'","cognom2":"'.$rs["cognom2"].'","telefon":"'.$rs["telefon"].'","actiu":"'.$rs["actiu"].'","carrer":"'.$rs["carrer"].'","cp":"'.$rs["cp"].'","poblacio":"'.$rs["poblacio"].'","poblacio_nom":"'.$rs["poblacio_nom"].'","provincia":"'.$rs["provincia"].'","provincia_nom":"'.$rs["provincia_nom"].'","nomAdherit":"'.$rs["nomAdherit"].'","horari":"'.$rs["horari"].'","tipusAdherit":"'.$rs["tipusAdherit"].'","tipusAdherit_nom":"'.$rs["tipusAdherit_nom"].'" }';
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
     * Mètode per recuperar els tipus de residu existents
     * @Params: sense.
    */
    public function llistatTipusResidu(){
        
        $select = "SELECT id, nom ,imatge ";
        $select .= "FROM tipus_residu ";
        $select .= "ORDER BY nom ASC ";        
        $r = $this->conn->query($select);
        
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{"id":"'.$rs["id"].'","nom":"'.$rs["nom"].'","imatge":"'.$rs["imatge"].'"}';
            } 
            $json .= ']}';
            return $json;
        }else{
            return '{"codi_error":"0","llistat":[]}';
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
     * Mètode per recuperar els usuaris
     * @Params: sense
    */
    public function llistatResidus(){
        
        $select = "SELECT r.id as idResidu, r.tipus as idTipusResidu, r.nom as nomResidu, r.imatge as imatgeResidu, r.descripcio as descripcioResidu, r.valor as valorResidu, r.actiu as actiuResidu, tr.nom as nomTipusResidu, tr.imatge as imatgeTipusResidu ";
        $select .= "FROM residus r ";
        $select .= "LEFT JOIN tipus_residu tr ON tr.id = r.tipus ";
        $select .= "ORDER BY r.nom ASC ";
        
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ",";}
                $json .= '{';
                $json .= '"id_residu":"'.$rs["idResidu"].'",';
                $json .= '"id_tipus_residu":"'.$rs["idTipusResidu"].'",';
                $json .= '"nom_residu":"'.$rs["nomResidu"].'",';
                $json .= '"imatge_residu":"'.$rs["imatgeResidu"].'",';
                $json .= '"descripcio_residu":"'. str_replace("\n","\\n",$rs["descripcioResidu"]).'",';
                $json .= '"valor_residu":"'.$rs["valorResidu"].'",';
                $json .= '"actiu_residu":"'.$rs["actiuResidu"].'",';
                $json .= '"nom_tipus_residu":"'.$rs["nomTipusResidu"].',",';
                $json .= '"imatge_tipus_residu":"'.$rs["imatgeTipusResidu"].'"';
                $json .= '}';
            } 
            $json .= "]}";
            return $json;
        }else{
            return '{"codi_error":"0","llistat":[]}';
        }
    }
 
    /*
     * Mètode per recuperar un tipus de residu
     * @Params: sense
    */
    public function consultaTipusResidu($id){
        
        if(is_null($id)){
            return $this->e["56"];
        }else{
             $select = "SELECT id, nom, imatge FROM tipus_residu WHERE id = '".$id."'";
             $r = $this->conn->query($select);
             if($r->num_rows > 0){
                 $rs = $r->fetch_assoc();
                 return '{"codi_error":"0","id":"'.$rs["id"].'","nom":"'.$rs["nom"].'","imatge":"'.$rs["imatge"].'"}';
             }else{
                return $this->e["55"];
             }
        }
        
    }
    
    /*
     * Mètode per recuperar un residu
     * @Params: id residu
    */
    public function consultaResidu($id){
        
        if(is_null($id)){
            return $this->e["61"];
        }else{
            
            $select = "SELECT r.id as idResidu, r.tipus as idTipusResidu, r.nom as nomResidu, r.imatge as imatgeResidu, r.descripcio as descripcioResidu, r.valor as valorResidu, r.actiu as actiuResidu, tr.nom as nomTipusResidu, tr.imatge as imatgeTipusResidu ";
            $select .= "FROM residus r ";
            $select .= "LEFT JOIN tipus_residu tr ON tr.id = r.tipus ";
            $select .= "WHERE r.id = '".$id."' ";
            $r = $this->conn->query($select);
            
            if($r->num_rows > 0){
                $rs = $r->fetch_assoc();
                $json = '{';
                $json .= '"codi_error":"0",';
                $json .= '"id_residu":"'.$rs["idResidu"].'",';
                $json .= '"id_tipus_residu":"'.$rs["idTipusResidu"].'",';
                $json .= '"nom_residu":"'.$rs["nomResidu"].'",';
                $json .= '"imatge_residu":"'.$rs["imatgeResidu"].'",';
                $json .= '"descripcio_residu":"'. str_replace("\n","\\n",$rs["descripcioResidu"]).'",';
                $json .= '"valor_residu":"'.$rs["valorResidu"].'",';
                $json .= '"actiu_residu":"'.$rs["actiuResidu"].'",';
                $json .= '"nom_tipus_residu":"'.$rs["nomTipusResidu"].'",';
                $json .= '"imatge_tipus_residu":"'.$rs["imatgeTipusResidu"].'"';
                $json .= '}';
                return $json;
             }else{
                return $this->e["62"];
             }
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
        $insert .= "'".$this->cometes($nom)."',";
        $insert .= "'".$this->cometes($cognom1)."',";
        if(!is_null($cognom2)){
            $insert .= "'".$this->cometes($cognom2)."',";
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
        $insert .= "'".$this->cometes($nom)."',";
        $insert .= "'".$this->cometes($cognom1)."',";
        if(!is_null($cognom2)){
            $insert .= "'".$this->cometes($cognom2)."',";
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
        $insert .= "'".$this->cometes($nom)."',";
        $insert .= "'".$this->cometes($cognom1)."',";
        if(!is_null($cognom2)){
            $insert .= "'".$this->cometes($cognom2)."',";
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
        $insert .= "'".$this->cometes($carrer)."',";
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
        $insert .= "'".$this->cometes($nom)."',";
        $insert .= "'".$this->cometes($cognom1)."',";
        if(!is_null($cognom2)){
            $insert .= "'".$this->cometes($cognom2)."',";
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
        $insert .= "'".$this->cometes($carrer)."',";
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
        $insert .= "'".$this->cometes($nomAdherit)."',";
        $insert .= "'".$this->cometes($horari)."'";
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
        $update .= "nom = '".$this->cometes($nom)."',";
        $update .= "cognom1 = '".$this->cometes($cognom1)."',";
        $update .= "cognom2 = '".$this->cometes($cognom2)."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."'";
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariTreballador($id,$email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus,$actiu){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."',";
        $update .= "email = '".$email."',";
        $update .= "password = '".$password."',";
        $update .= "nom = '".$this->cometes($nom)."',";
        $update .= "cognom1 = '".$this->cometes($cognom1)."',";
        $update .= "cognom2 = '".$this->cometes($cognom2)."',";
        $update .= "telefon = '".$telefon."',";
        $update .= "tipus = '".$tipus."',";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."'";
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariResiduent($id,$email, $password, $nom, $cognom1, $cognom2, $telefon, $tipus,$actiu,$carrer,$poblacio,$cp){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."', ";
        $update .= "email = '".$email."', ";
        $update .= "password = '".$password."', ";
        $update .= "nom = '".$this->cometes($nom)."',";
        $update .= "cognom1 = '".$this->cometes($cognom1)."', ";
        $update .= "cognom2 = '".$this->cometes($cognom2)."', ";
        $update .= "telefon = '".$telefon."', ";
        $update .= "tipus = '".$tipus."', ";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."' ";
        $this->conn->query($update);
        
        $update = "UPDATE adresa ";
        $update .= "SET ";
        $update .= "carrer = '".$this->cometes($carrer)."', ";
        $update .= "cp = '".$cp."', ";
        $update .= "poblacio = '".$poblacio."' ";
        $update .= "WHERE usuari = '".$id."' ";
        $this->conn->query($update);
        
    }
    
    public function modificarUsuariAdherit($id,$email,$password,$nom,$cognom1,$cognom2,$telefon,$tipus,$actiu,$carrer,$poblacio,$cp,$tipusAdherit,$nomAdherit,$horari){
        
        $update = "UPDATE usuaris ";
        $update .= "SET ";
        $update .= "id = '".$id."', ";
        $update .= "email = '".$email."', ";
        $update .= "password = '".$password."', ";
        $update .= "nom = '".$this->cometes($nom)."',";
        $update .= "cognom1 = '".$this->cometes($cognom1)."', ";
        $update .= "cognom2 = '".$this->cometes($cognom2)."', ";
        $update .= "telefon = '".$telefon."', ";
        $update .= "tipus = '".$tipus."', ";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."' ";
        $this->conn->query($update);
        
        $update = "UPDATE adresa ";
        $update .= "SET ";
        $update .= "carrer = '".$this->cometes($carrer)."', ";
        $update .= "cp = '".$cp."', ";
        $update .= "poblacio = '".$poblacio."' ";
        $update .= "WHERE usuari = '".$id."' ";
        $this->conn->query($update);
        
        
        $update = "UPDATE adherit ";
        $update .= "SET ";
        $update .= "tipus = '".$tipusAdherit."', ";
        $update .= "nom = '".$this->cometes($nomAdherit)."', ";
        $update .= "horari = '".$this->cometes($horari)."' ";
        $update .= "WHERE usuari = '".$id."' ";
        $this->conn->query($update);      
        
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
    
    /*
     * Mètode per donar d'alta un tipus de residu
     * @Params: $nom (String)(nom del tipus de residu) 
     * @Params: $imatge (String)(nom de la imatge)
     */
    public function altaTipusResidu($nom,$imatge){
        
        $insert = "INSERT INTO tipus_residu ";
        $insert .= "(nom, imatge ) VALUES ";
        $insert .= "(";
        $insert .= "'".$this->format($nom)."',";
        $insert .= "'".$imatge."'";
        $insert .= ")";
        if($this->conn->query($insert)){
            return '{"codi_error":"0","descripcio":"Tipus de residu donat d\'alta"}';
        }else{
            return $this->e["41"];
        }
        
    }
    
    /*
     * Mètode per donar d'alta un residu
     * @Params: $tipus (Int, id) $nom (String)(nom del residu) 
     * @Params: $imatge (String)(nom de la imatge)
     * @Params: $descripcio (String)(explicació), $valor (Decimal) valor real del residu
     * @Params: $actiu (Int)
     */
    public function altaResidu($tipus,$nom,$imatge,$descripcio,$valor,$actiu){
        
        $insert = "INSERT INTO residus ";
        $insert .= "(tipus, nom, imatge, descripcio, valor, actiu ) VALUES ";
        $insert .= "(";
        $insert .= "'".$tipus."',";
        $insert .= "'".$nom."',";
        $insert .= "'".$imatge."',";
        $insert .= "'".$this->conn->real_escape_string($descripcio)."',";
        $insert .= "'".$valor."',";
        $insert .= "'".$actiu."'";
        $insert .= ")";
        if($this->conn->query($insert)){
            return '{"codi_error":"0","descripcio":"Residu donat d\'alta"}';
        }else{
            return $this->e["48"];
        }
        
    }
    
    /*
     * Mètode per modificar un tipus de residu
     * @Params: $nom (String)(nom del tipus de residu) 
     * @Params: $imatge (String)(nom de la imatge)
     */
    public function modificarTipusResidu($id,$nom,$imatge){
        
        $select = "SELECT imatge FROM tipus_residu WHERE id = '".$id."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            
            if($imatge != null){
                $rs = $r->fetch_assoc();
                unlink("/opt/lampp/htdocs/residueix/img/residus/tipus/" . $rs["imatge"]);
                $update = "UPDATE tipus_residu ";
                $update .= "SET ";
                $update .= "nom = '".$this->format($nom)."' ,";
                $update .= "imatge = '".$imatge."' ";
                $update .= "WHERE id = '".$id."'";
                $this->conn->query($update);
                return '{"codi_error":"0","descripcio":"Tipus de residu modificat."}';
            }else{
                $update = "UPDATE tipus_residu ";
                $update .= "SET ";
                $update .= "nom = '".$this->format($nom)."' ";
                $update .= "WHERE id = '".$id."'";
                $this->conn->query($update);
                return '{"codi_error":"0","descripcio":"Tipus de residu modificat."}';    
            }
            
        }else{
            return $this->e["42"];
        }  
        
        
    }
    
    
    /*
     * Mètode per modificar un residu
     * @Params: $id (Int)(Identificador)
     * @Params: $nom (String)(nom del residu) 
     * @Params: $imatge (String)(nom de la imatge)
     * @Params: $descripcio (Text)(Explicació residu)
     * @Params: $valor (Decimal)(valor del residu)
     * @Params: $actiu (Int)(0=inactiu 1=actiu)
     */
    public function modificarResidu($id,$tipus,$nom,$nomFinalImatge,$descripcio,$valor,$actiu){
        
        $select = "SELECT imatge FROM residus WHERE id = '".$id."'";
        $r = $this->conn->query($select);
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            if($nomFinalImatge != null){
                unlink("/opt/lampp/htdocs/residueix/img/residus/" . $rs["imatge"]);
            }
        }
                
        $update = "UPDATE residus ";
        $update .= "SET ";
        $update .= "id = '".$id."' ,";
        $update .= "tipus = '".$tipus."' ,";
        $update .= "nom = '".$this->format($nom)."' ,";
        if($nomFinalImatge != null){
            $update .= "imatge = '".$nomFinalImatge."', ";
        }
        $update .= "descripcio = '".$this->conn->real_escape_string($descripcio)."' ,";
        $update .= "valor = '".$this->format($valor)."' ,";
        $update .= "actiu = '".$actiu."' ";
        $update .= "WHERE id = '".$id."'";
        $this->conn->query($update);
        
        return '{"codi_error":"0","descripcio":"Residu modificat correctament."}';
        
    }
    
// Punts de recollida
// *************************************************************************
    
    /*
     * Mètode per recuperar el llistat de punts de recollida.
     * @Params: sense.
    */
    public function llistatPuntsRecollida($actiu){
        
        $select = "SELECT ";
        $select .= "pr.id as idPunt, pr.nom as nomPunt, pr.descripcio as descripcioPunt, pr.imatge as imatgePunt, pr.latitud as latitudPunt, pr.longitud as longitudPunt, pr.carrer as carrerPunt, pr.cp as cpPunt, pr.poblacio as idPoblacio, pr.horari as horariPunt, pr.actiu as actiuPunt, ";
        $select .= "pob.nom as nomPoblacio, pob.provincia as idProvincia, ";
        $select .= "pro.nom as nomProvincia ";
        $select .= "FROM punts_recollida pr ";
        $select .= "LEFT JOIN poblacions pob ON pob.id = pr.poblacio ";
        $select .= "LEFT JOIN provincies pro ON pro.id = pob.provincia ";
        switch($actiu){
            case "0":
                // baixes
                $select .= "WHERE pr.actiu = '0' ";
            break;
            case "1":
                // actius
                $select .= "WHERE pr.actiu = '1' ";
            break;
            case "2":
                // tots no posem clausula where.
            break;
            default:
                // Opció per defecte
                $select .= "WHERE pr.actiu = '1' ";
            break;
            
        }
        $select .= "ORDER BY pr.nom ASC ";
        
        $r = $this->conn->query($select);
        
        if($r->num_rows > 0){
            $cont = 0;
            $json = '{"codi_error":"0","llistat":[';
            while($rs = $r->fetch_assoc()){
                $cont++;
                if($cont!=1){ $json .= ","; }
                $json .= '{"id_punt":"'.$rs["idPunt"].'","nom_pun":"'.$rs["nomPunt"].'","descripcio":"'.$rs["descripcioPunt"].'","imatge":"'.$rs["imatgePunt"].'","latitud":"'.$rs["latitudPunt"].'","longitud":"'.$rs["longitudPUnt"].'","carrer":"'.$rs["carrerPunt"].'","cp":"'.$rs["cpPunt"].'","horari":"'.$rs["horariPunt"].'","actiu":"'.$rs["actiuPunt"].'","id_poblacio":"'.$rs["idPoblacio"].'","nom_poblacio":"'.$rs["nomPoblacio"].'","id_provincia":"'.$rs["idProvincia"].'","nom_provincia":"'.$rs["nomProvincia"].'"}';
            } 
            $json .= ']}';
            return $json;
        }else{
            return '{"codi_error":"0","llistat":[]}';
        }
    } 
    
    /*
     * Mètode per recuperar el un punt de recollida determinat.
     * @Params: id punt de recollida.
    */
    public function consultaPuntRecollida($id){
        
        $select = "SELECT ";
        $select .= "pr.id as idPunt, pr.nom as nomPunt, pr.descripcio as descripcioPunt, pr.imatge as imatgePunt, pr.latitud as latitudPunt, pr.longitud as longitudPunt, pr.carrer as carrerPunt, pr.cp as cpPunt, pr.poblacio as idPoblacio, pr.horari as horariPunt, pr.actiu as actiuPunt, ";
        $select .= "pob.nom as nomPoblacio, pob.provincia as idProvincia, ";
        $select .= "pro.nom as nomProvincia ";
        $select .= "FROM punts_recollida pr ";
        $select .= "LEFT JOIN poblacions pob ON pob.id = pr.poblacio ";
        $select .= "LEFT JOIN provincies pro ON pro.id = pob.provincia ";
        $select .= "WHERE pr.id = '".$id."' ";
        
        $r = $this->conn->query($select);
        
        if($r->num_rows > 0){
            $rs = $r->fetch_assoc();
            $json .= '{"id_punt":"'.$rs["idPunt"].'","nom_pun":"'.$rs["nomPunt"].'","descripcio":"'.$rs["descripcioPunt"].'","imatge":"'.$rs["imatgePunt"].'","latitud":"'.$rs["latitudPunt"].'","longitud":"'.$rs["longitudPUnt"].'","carrer":"'.$rs["carrerPunt"].'","cp":"'.$rs["cpPunt"].'","horari":"'.$rs["horariPunt"].'","actiu":"'.$rs["actiuPunt"].'","id_poblacio":"'.$rs["idPoblacio"].'","nom_poblacio":"'.$rs["nomPoblacio"].'","id_provincia":"'.$rs["idProvincia"].'","nom_provincia":"'.$rs["nomProvincia"].'"}';
            return $json;
        }else{
            return $this->e["68"];
        }
    } 


}

?>