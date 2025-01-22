<?php
require_once 'db.php';
class Inscription extends Db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function inscrire($cours_id, $etudiant_id)
    {
        if ($this->getEnrolementByEtudianteEtCours($etudiant_id, $cours_id)) {
            return true;
        }
        $sql = "INSERT INTO inscriptions (cours_id, etudiant_id) VALUES (:cours_id, :etudiant_id) ";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([
            "cours_id" => $cours_id,
            "etudiant_id" => $etudiant_id,
        ]);;
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

    public function getAllEnrolements()
    {
        $sql = "SELECT * FROM inscriptions";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute();
        return $result;
    }
    public function getEnrolementsByCours($cours_id)
    {
        $sql = "SELECT * FROM inscriptions WHERE cours_id = :cours_id
        JOIN utilisateurs ON inscriptions.etudiant_id = utilisateurs.id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            "cours_id" => $cours_id,
        ]);
        return $result;
    }

    public function getEnrolementByEtudianteEtCours($etudiant_id, $cours_id)
    {
        $sql = "SELECT * FROM inscriptions WHERE cours_id = :cours_id AND etudiant_id = :etudiant_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            ":cours_id" => $cours_id,
            ":etudiant_id" => $etudiant_id,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
