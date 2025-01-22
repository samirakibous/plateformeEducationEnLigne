<?php
abstract class Content extends Db
{
    protected $createdAt;
    protected $id;
    protected $courseId;
    protected $path;
    public function __construct($courseId,$path)
    {
        parent::__construct();       
         $this->courseId = $courseId;

         $this->path = $path;
    }
    abstract public function save();
    abstract public function display($courseId);
}
