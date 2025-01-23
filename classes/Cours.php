<?php
// require_once('db.php');
class Cours extends Db
{
    public function __construct()
    {
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
        $query = "SELECT * FROM Cours WHERE teacher_id = :id ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['id' => $id]);
        $resultat = $stmt->fetchAll();
        return $resultat;
    }
    public function getCoursByEtudiant($id){
        $query = "SELECT cours.* FROM cours JOIN inscriptions 
        ON cours.cours_id = inscriptions.cours_id
        WHERE inscriptions.etudiant_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(["id"=> $id]);
        $resultat = $stmt->fetchAll();
        return $resultat;
    }

    public function getCoursWithPagination($search, $limit, $offset)
    {
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

    public function countCours($search)
    {
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
    public function create($title, $description, $teacher_id, $categoryId,$tags)
    {
        try {
        $this->conn ->beginTransaction();
        $sql = "INSERT INTO cours (title, description, teacher_id, category_id) VALUES (:title, :description, :teacher_id, :categoryId)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([
            'title' => $title,
            'description' => $description,
            'teacher_id' => $teacher_id,
            'categoryId' => $categoryId
        ]);
        $courseId = $this->conn->lastInsertId();
        
        $sql = "INSERT INTO cours_tags(cours_id, tag_id) VALUES (:courseId, :tagId)";
        $stmt = $this->conn->prepare($sql);
        foreach ($tags as $tag_id) {
        $result = $stmt->execute([
            "courseId"=> $courseId,
            "tagId"=> $tag_id
        ]);
    }
        $this->conn->commit();
        return $courseId;
        } catch (PDOException $e) {
            return false;}
    }


    public function delete($id)
    {

        $sql = "
                DELETE vc, dc, ct
                FROM content c
                LEFT JOIN video_content vc ON vc.content_id = c.id
                LEFT JOIN document_content dc ON dc.content_id = c.id
                LEFT JOIN cours_tags ct ON ct.cours_id =  c.cours_id
                WHERE c.cours_id = :id
            ";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);

        $sql = "DELETE FROM content WHERE cours_id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['id' => $id]);


        $sql = "DELETE FROM cours WHERE cours_id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);


        return $result;
    }
    public function updateCoursTitle($courseId, $title){
        $sql = 'UPDATE cours SET title = :title WHERE cours_id = :courseId';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':courseId'=> $courseId,':title'=> $title]);
    }
    
    public function updateCoursDescription($courseId, $description){
        $sql = 'UPDATE cours SET description = :description WHERE cours_id = :courseId';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':courseId'=> $courseId,':description'=> $description]);
    }

    public function updateCoursCategoryId($courseId, $categoryId){
        $sql = 'UPDATE cours SET category_id = :categoryId WHERE cours_id = :courseId';
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':courseId'=> $courseId, ':categoryId'=> $categoryId]);
    }

    
    
    public function getLastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function getCourseDetailsById($coursId)
    {
        try {
            $sql = "SELECT c.title, c.description, ct.path ,ct.type ,u.nom, cat.name as categoryName , ts.tag_name as coursTag

                    FROM cours c
                    LEFT JOIN content ct ON c.cours_id = ct.cours_id
                    LEFT JOIN video_content v ON ct.id = v.content_id
                    LEFT JOIN document_content d ON ct.id = d.content_id
                    LEFT JOIN utilisateurs u ON c.teacher_id = u.id
                    LEFT JOIN categories cat ON c.category_id = cat.id
                    LEFT JOIN cours_tags cts ON c.cours_id = cts.cours_id
                    LEFT JOIN tags ts ON cts.tag_id = ts.tag_id
                    WHERE c.cours_id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([$coursId]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des détails du cours : " . $e->getMessage();
            return false;
        }
    }
    public function getTotalCoursesNumber()
    {
        try {
            $stmt = $this->conn->prepare("SELECT COUNT(*) AS total_courses FROM cours");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result['total_courses'];
        } catch (PDOException $e) {
            error_log("Error getting total courses: " . $e->getMessage());
            return false;
        }
    }
    public function getTopCoursesByEnrollment()
    {
        try {
            $stmt = $this->conn->prepare("SELECT co.title, COUNT(*) AS student_number
                                          FROM inscriptions en
                                          JOIN cours co ON co.cours_id = en.cours_id
                                          GROUP BY en.cours_id
                                          ORDER BY student_number DESC
                                          LIMIT 3");
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            error_log("Error getting top courses by enrollment: " . $e->getMessage());
            return false;
        }
    }

}
