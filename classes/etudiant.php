<?php
class Etudiant extends User {
    public function __construct() {
        parent::__construct();
    }
    
    public function enrollInCours($etudiantId, $courseId) {
        $ins = new Inscription();
        $ins->inscrire($courseId, $etudiantId);
    }

    public function viewCourses($etudiantId){
        $ins = new Cours();
        return $ins->getCoursByEtudiant($etudiantId);
    }
}
?>