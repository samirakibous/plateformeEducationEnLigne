<?php
abstract class Content extends Db
{
    protected $createdAt;
    protected $id;
    protected $courseId;
    public function __construct($courseId)
    {
        parent::__construct();        $this->courseId = $courseId;
    }
    abstract public function save();
    abstract public function display($courseId);
}
