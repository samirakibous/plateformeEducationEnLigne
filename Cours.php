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

    public function getCoursWithPagination($search, $limit, $offset) {
        $sql = "SELECT * FROM cours";
        $params = [];
    
        if (!empty($search)) {
            $sql .= " WHERE titre LIKE :search OR description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
    
        $sql .= " ORDER BY titre ASC LIMIT :limit OFFSET :offset";
        $stmt = $this->conn->prepare($sql);
    
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    
        if (!empty($search)) {
            $stmt->bindValue(':search', $params['search'], PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countCours($search) {
        $sql = "SELECT COUNT(*) as total FROM cours";
        $params = [];
    
        if (!empty($search)) {
            $sql .= " WHERE titre LIKE :search OR description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
    
        $stmt = $this->conn->prepare($sql);
    
        if (!empty($search)) {
            $stmt->bindValue(':search', $params['search'], PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function create($title, $description, $teacherId, $categoryId){
        $sql = "INSERT INTO cours (title, description, enseignant_id, category_id) VALUES (:title, :description, :teacherId, :categoryId)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'title' => $title,
             'description' => $description, 
             'teacherId' => $teacherId, 
             'categoryId' => $categoryId]);
             return $result;
        }
    }
    

?>
