<?php
class DocumentContent extends Content {
    private $fileSize;

    public function __construct($courseId, $path ,$fileSize) {
        parent::__construct($courseId, $path);
        $this->fileSize = $fileSize;
    }
    public function save(){
        $sql="INSERT INTO content (cours_id,path, type) VALUES (?,?,'document')";
        $stmt = $this->conn->prepare($sql);
        $result = $stmt->execute([$this->courseId, $this->path] );
        if($result){
            $contentId = $this->conn->lastInsertId();
            $sql="INSERT INTO document_content (content_id,file_size ) VALUES (?,?)";
            $stmt = $this->conn->prepare($sql);
            $result = $stmt->execute([$contentId,$this->fileSize]);
            return $result;
        }else{
            return false;
        }

    }
    public function display($coursId)
    {	
        $sql= "SELECT title , description , type ,file_size, path FROM cours
        INNER JOIN content ON cours.cours_id = content.cours_id
        INNER JOIN document_content ON content.id = document_content.content_id
        WHERE cours.cours_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$coursId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
}
?>