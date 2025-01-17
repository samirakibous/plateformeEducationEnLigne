<?php
require_once 'user.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $user = new User();
    $action = $_POST['action']; 
    if ($action === 'logout') {
        $user->logout();
    }
}
?>