<?php
class Cours extends DB
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
    public function create($title, $description, $teacher_id, $categoryId)
    {
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

    public function delete($id)
    {

        $sql = "
                DELETE vc, dc
                FROM content c
                LEFT JOIN video_content vc ON vc.content_id = c.id
                LEFT JOIN document_content dc ON dc.content_id = c.id
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
    public function updateCourse($id, $courseData, $contentData) {
        try {
            // Démarrer une transaction
            $this->conn->beginTransaction();
    
            // Mettre à jour les informations du cours
            $sql = "
                UPDATE cours 
                SET 
                    title = :title, 
                    description = :description, 
                    category_id = :category_id, 
                    content_type = :content_type, 
                    updated_at = CURRENT_TIMESTAMP
                WHERE cours_id = :id
            ";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                'id' => $id,
                'title' => $courseData['title'],
                'description' => $courseData['description'],
                'category_id' => $courseData['category_id'],
                'content_type' => $courseData['content_type'],
            ]);
    
            // Mettre à jour les contenus dans `content`
            foreach ($contentData as $content) {
                $sql = "
                    UPDATE content 
                    SET 
                        path = :path, 
                        type = :type, 
                        updated_at = CURRENT_TIMESTAMP
                    WHERE id = :content_id AND cours_id = :cours_id
                ";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    'content_id' => $content['content_id'],
                    'cours_id' => $id,
                    'path' => $content['path'],
                    'type' => $content['type'],
                ]);
    
                // Mettre à jour les détails spécifiques aux vidéos
                if ($content['type'] === 'video') {
                    $sql = "
                        UPDATE video_content 
                        SET 
                            duration = :duration, 
                            updated_at = CURRENT_TIMESTAMP
                        WHERE content_id = :content_id
                    ";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        'content_id' => $content['content_id'],
                        'duration' => $content['duration'],
                    ]);
                }
    
                // Mettre à jour les détails spécifiques aux documents
                if ($content['type'] === 'document') {
                    $sql = "
                        UPDATE document_content 
                        SET 
                            file_size = :file_size, 
                            updated_at = CURRENT_TIMESTAMP
                        WHERE content_id = :content_id
                    ";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->execute([
                        'content_id' => $content['content_id'],
                        'file_size' => $content['file_size'],
                    ]);
                }
            }
    
            // Valider la transaction
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $this->conn->rollBack();
            error_log("Erreur lors de la mise à jour du cours : " . $e->getMessage());
            return false;
        }
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
