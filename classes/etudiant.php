<?php
require_once 'user.php';
class Etudiant extends User
{
    public function __construct()
    {
        parent::__construct();
    }

    public function enrollInCours($etudiantId, $courseId)
    {
        $ins = new Inscription();
        $ins->inscrire($courseId, $etudiantId);
    }

    public function viewCourses($etudiantId)
    {
        $ins = new Cours();
        return $ins->getCoursByEtudiant($etudiantId);
    }
    public function getEtudiantNumber()
    {
        $sql = "SELECT COUNT(*) as total 
        FROM utilisateurs 
        JOIN inscriptions 
        ON utilisateurs.id = inscriptions.etudiant_id
        WHERE utilisateurs.role = 'etudiant'";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // var_dump($result);die();
        return $result['total'];
    }
}
