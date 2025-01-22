<?php 

class Enseignant extends User {
    public function __construct() {
        parent::__construct();
    }

    public function getTopTeachersByEnrollment()
    {
        try {
            $stmt = $this->conn->prepare("SELECT u.full_name, COUNT(*) AS student_number
                                        FROM enrollments en
                                        JOIN courses co ON co.course_id = en.course_id
                                        JOIN users u ON u.user_id = co.teacher_id
                                        GROUP BY u.user_id
                                        ORDER BY student_number DESC
                                        LIMIT 3;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Returns the top 3 teachers with their courses and the number of enrollments
        } catch (PDOException $e) {
            error_log("Error getting top teachers by enrollment: " . $e->getMessage());
            return false;
        }
    }
    
public function getTeacherCourseCount($teacher_id)
{
    try {
        $stmt = $this->conn->prepare("SELECT COUNT(*) AS course_count
                                        FROM courses
                                        WHERE teacher_id = ?;");
        $stmt->execute([$teacher_id]);
        return $stmt->fetchColumn();
    } catch (PDOException $e) {
        error_log("Error getting the number of courses for the teacher: " . $e->getMessage());
        return false;
    }
}
}
?>