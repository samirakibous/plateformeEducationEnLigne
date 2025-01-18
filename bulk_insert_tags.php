<?php
require_once 'db.php'; 
require_once 'Tag.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['tags'])) {
    // Récupérer les tags soumis
    $tagsInput = $_POST['tags'];

    // Séparer les tags par virgule ou saut de ligne
    $tagsArray = preg_split('/[\n,]+/', $tagsInput);
    $tag = new Tag();
    $result = $tag->insertTags($tagsArray);
    echo $result['message'];
}
$tag = new Tag();
$tag->getAllTags();
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tag_id'])) {
    $tagId = $_POST['tag_id'];
    $result = $tag->deleteTag($tagId);
   
}
header('Location: tags.php');

?>
