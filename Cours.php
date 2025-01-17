<?php
class Cours extends DB
{
    public function __construct(){
        parent::__construct();
    }
    public function getAllCours()
    {
        $query = "SELECT * FROM cours ORDER BY date_creation DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getEnseignantCours($id)
    {
        $query ="SELECT * FROM Cours WHERE enseignant_id = :id ORDER BY date_creation DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetchAll();
        return $resultat;
        

    }

}

?>
