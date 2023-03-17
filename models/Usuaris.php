class Usuaris{

    private $id;
    private $email;
    private $password;
    private $nom;
    private $tipus;
    private $cognom1;
    private $cognom2;

    public function __construct($id,$email,$password,$nom,$tipus,$cognom1,$cognom2){
        $this->id =  $id;
        $this->email =  $email;
        $this->password = $password;
        $this->nom = $nom;
        $this->tipus = $tipus;
        $this->cognom1 = $cognom1;
        $this->cognom2 = $cognom2;
    }

    public function getNom(){
        return $this->nom;
    }

    public function setNom($nouNom){
        $this->nom = $nouNom;
    }

}