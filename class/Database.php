Class Database{
    
    private $host = 'localhost';
    private $user = 'residueix';
    private $password = 'R3s1du31X';
    private $database = "ResidueixDB";

    public function connection(){
        $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
        if($conn->connect_error){
            return false;
        }else{
            return $conn;
        }
    }


}


