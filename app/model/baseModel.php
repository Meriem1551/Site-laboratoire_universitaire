<?php

class BaseModel{
    private $sql;
    private $con;
    private $host = 'localhost';
    private $db_name = 'tdw';
    private $username = 'root';//changer
    private $password = '';//changer
 
    public function __construct() {
        $this->sql = require __DIR__ . '/../../utils/sql.php';
    }
    public function connection() {
        $dsn = "mysql:dbname={$this->db_name};host={$this->host};";
        try {
            $this->con = new PDO($dsn, $this->username, $this->password);
            return $this->con;
        } catch (PDOException $ex) {
            printf("Erreur de connexion à la base de donnée: %s", $ex->getMessage());
            exit();
        }
    }
    public function requet($connectDB, $queryKey, $params=[]){
        $stmt = $connectDB->prepare($this->sql[$queryKey]);
        foreach ($params as $key => $value) {
            if (in_array($key, ['limit', 'offset'])) {
                $stmt->bindValue(':'.$key, (int)$value, PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':'.$key, $value);
            }
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deconnexion($connectDB) {
        $this->con = null;
    }
    
}
?>