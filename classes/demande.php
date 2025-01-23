<?php
require_once(__DIR__ . '/../db.php');
require_once 'user.php';
class Demande extends Db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function demandes($role, $nom, $email, $password){
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        if($role == 'enseignant'){
            $query = "INSERT INTO demandes (nom, email, password, role) VALUES (:nom, :email, :password, :role)";
            $stmt = $this->conn->prepare($query);
            $stmt->execute([
                ':nom' => $nom,
                ':email' => $email,
                ':password' => $hashed_password,
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
    public function deleteDemande($id){
        $sql = "DELETE FROM demandes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
    }   
     
    public function accepterDemande($id){
        $sql = "INSERT INTO utilisateurs (nom, email, password, role)
         SELECT nom, email, password, role FROM demandes
          WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        $this->deleteDemande($id);
    }
    
}