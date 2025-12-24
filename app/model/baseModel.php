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



    public function get_all($connectDB, $table) {
        $stmt = $connectDB->prepare("SELECT * FROM `$table`");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getByCol($connectDB, $table, $col, $value) {
        $stmt = $connectDB->prepare("SELECT * FROM `$table` WHERE `$col` = :val");
        $stmt->bindValue(':val', $value);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insert($connectDB, $table, $data) {
        $columns = implode('`, `', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));

        $stmt = $connectDB->prepare("INSERT INTO `$table` (`$columns`) VALUES ($placeholders)");

        foreach ($data as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }

        return $stmt->execute();
    }

    public function update($connectDB, $table, $data, $col, $val) {
        $fields = [];
        foreach ($data as $key => $value) {
            $fields[] = "`$key` = :$key";
        }
        $fieldsStr = implode(', ', $fields);

        $stmt = $connectDB->prepare("UPDATE `$table` SET $fieldsStr WHERE `$col` = :val");
        $stmt->bindValue(':val', $val);

        foreach ($data as $key => $value) {
            $stmt->bindValue(':'.$key, $value);
        }

        return $stmt->execute();
    }

    public function delete($connectDB, $table, $col, $val) {
        $stmt = $connectDB->prepare("DELETE FROM `$table` WHERE `$col` = :val");
        $stmt->bindValue(':val', $val);
        return $stmt->execute();
    }

    public function deconnexion($connectDB) {
        $this->con = null;
    }
}
?>

