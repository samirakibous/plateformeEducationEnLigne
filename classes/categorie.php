<?php
class Categorie extends Db
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function createCategorie($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['name' => $name]);
        return $result;
    }

    public function deleteCategorie($id)
    {
        $sql = "DELETE FROM categories WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute(['id' => $id]);
        return $result;
    }
    public function getTopCategories()
    {
        try {
            $stmt = $this->conn->prepare("SELECT cat.category_name, COUNT(*) AS category_count
                FROM cours co
                JOIN categories cat ON cat.category_id = co.category_id
                GROUP BY cat.category_name
                ORDER BY category_count DESC
                LIMIT 3");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getting top categories: " . $e->getMessage());
            return false;
        }
    }
}
