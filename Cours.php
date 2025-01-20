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
        $query ="SELECT * FROM Cours WHERE teacher_id = :id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetchAll();
        return $resultat;
        

    }

    public function getCoursWithPagination($search, $limit, $offset) {
        $sql = "SELECT * FROM cours";
        $params = [];
    
        if (!empty($search)) {
            $sql .= " WHERE title LIKE :search OR description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
    
        $sql .= " ORDER BY title ASC LIMIT :limit OFFSET :offset";
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
            $sql .= " WHERE title LIKE :search OR description LIKE :search";
            $params['search'] = '%' . $search . '%';
        }
    
        $stmt = $this->conn->prepare($sql);
    
        if (!empty($search)) {
            $stmt->bindValue(':search', $params['search'], PDO::PARAM_STR);
        }
    
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }
    public function create($title, $description, $teacher_id, $categoryId){
        $sql = "INSERT INTO cours (title, description, teacher_id, category_id) VALUES (:title, :description, :teacher_id, :categoryId)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'title' => $title,
             'description' => $description, 
             'teacher_id' => $teacher_id, 
             'categoryId' => $categoryId
            ]);
        return $result;
    }

    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function getCourseDetailsById($coursId)
    {
        try {
            $sql = "SELECT c.title, c.description, ct.path 
                    FROM cours c
                    LEFT JOIN content ct ON c.cours_id = ct.cours_id
                    LEFT JOIN video_content v ON ct.id = v.content_id
                    WHERE c.cours_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$coursId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des détails du cours : " . $e->getMessage();
            return false;
        }
    }
    }


?>
