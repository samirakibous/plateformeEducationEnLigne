<?php
class DocumentContent extends Content {
    private $path;
    private $fileSize;
    public function __construct($db, $courseId,$path,$fileSize) {
        parent::__construct($db, $courseId);
        $this->path = $path;
        $this->fileSize = $fileSize;
    }
    public function save(){
        $sql="INSERT INTO content (course_id, type) VALUES (?,'document')";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$this->courseId]);
        if($result){
            $contentId = $this->conn->lastInsertId();
            $sql="INSERT INTO document_content (content_id, path, file_size) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$contentId,$this->path,$this->fileSize]);
            return $result;
        }else{
            return false;
        }

    }
    public function display($courseId)
    {
        $sql= "SELECT title , DESCRIPTION , TYPE , document_url FROM courses
        INNER JOIN contents ON courses.id = contents.course_id
        INNER JOIN document_contents ON contents.id = document_contents.content_id
        WHERE courses.id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$courseId]);  
        
    }
}
?>