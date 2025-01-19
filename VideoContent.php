<?php
require_once 'Content.php';
class VideoContent extends Content
{
    private $vidUrl;
    private $duration;

    public function __construct($db, $courseId, $vidUrl, $duration)
    {
        parent::__construct($db, $courseId);
        $this->vidUrl = $vidUrl;
        $this->duration = $duration;
    }

    public function save(){
        $sql="INSERT INTO content (course_id, type) VALUES (?,'video')";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$this->courseId]);
        if($result){
            $contentId = $this->conn->lastInsertId();
            $sql="INSERT INTO video_content (content_id, path, file_size) VALUES (?,?,?)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$contentId,$this->vidUrl,$this->duration]);
            return $result;
        }else{
            return false;
        }

    }

    public function display($contentId)
    {
        $sql= "SELECT title , DESCRIPTION , TYPE , document_url FROM courses
        INNER JOIN contents ON courses.id = contents.course_id
        INNER JOIN document_contents ON contents.id = document_contents.content_id
        WHERE courses.id = ?";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$contentId]);
        
    }
}

?>