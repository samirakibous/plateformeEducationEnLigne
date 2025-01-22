<?php
require_once 'Content.php';
class VideoContent extends Content
{
    private $duration;

    public function __construct($courseId,$path, $duration)
    {
        parent::__construct($courseId,$path);
        $this->duration = $duration;
    }

    public function save(){
        $sql="INSERT INTO content (cours_id,path, type) VALUES (?,?,'video')";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$this->courseId, $this->path] );
        if($result){
            $contentId = $this->conn->lastInsertId();
            $sql="INSERT INTO video_content (content_id, duration) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$contentId,$this->duration]);
            return $contentId;
        }else{
            return false;
        }

    }

    public function display($coursId)
    {
        $sql= "SELECT title , description , type ,duration, path FROM cours
        INNER JOIN content ON cours.cours_id = content.cours_id
        INNER JOIN video_content ON content.id = video_content.content_id
        WHERE cours.cours_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$coursId]);        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}

?>