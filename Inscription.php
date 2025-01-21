<?php
require_once 'db.php';
class Inscription extends DB
{
    public function __construct()
    {
        parent::__construct();
    }
    function inscrire($cours_id, $etudiant_id)
    {
        $sql= "INSERT INTO inscriptions (cours_id, etudiant_id) VALUES (:cours_id, :etudiant_id) ";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            "cours_id" => $cours_id,
            "etudiant_id" => $etudiant_id,
        ]);
        return $result;
    }

    // function desinscrire($cours_id, $etudiant_id){
    //     $sql= "DELETE FROM inscriptions WHERE cours_id = :cours_id AND etudiant_id = :etudiant_id";
    //     $stmt = $this->conn->prepare($sql);
    //     $result = $stmt->execute([
    //         "cours_id" => $cours_id,
    //         "etudiant_id" => $etudiant_id,
    //     ]);
    //     return $result;
    // }

    public function getAllEnrolements(){
        $sql= "SELECT * FROM inscriptions";
        $stmt= $this->conn->prepare($sql);
        $result=$stmt->execute();
        return $result;
    }
    public function getEnrolementsByCours($cours_id){
        $sql= "SELECT * FROM inscriptions WHERE cours_id = :cours_id
        JOIN utilisateurs ON inscriptions.etudiant_id = utilisateurs.id";
        $stmt = $this->conn->prepare($sql);
        $result=$stmt->execute([
            "cours_id"=> $cours_id,
        ]);
        return $result;
    }


}
?>
