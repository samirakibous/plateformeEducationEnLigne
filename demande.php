<?php
require_once 'db.php';
require_once 'user.php';
class Demande extends Db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function demandes($role, $nom, $email, $password){
        if($role == 'enseignant'){
            $query = "INSERT INTO demandes (nom, email, password, role) VALUES (:nom, :email, :password, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':password' => $password,
                ':role' => $role
            ]);
        
        }
    
    }
    
    public function getDemandes(){
        $sql = "SELECT * FROM demandes";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}