<?php
session_start();
require_once '../db.php';
require_once '../classes/User.php';

$user = new User();
if (isset($_POST['action']) && $_POST['action'] === 'suspender') {
    $user->suspendUser($_POST['id']);
}
header('Location: /users.php');