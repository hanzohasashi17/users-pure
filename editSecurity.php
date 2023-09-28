<?php
session_start();
include_once "services/commonServices.php";

$userId = $_POST['id'];
$email = $_POST['email'];
$password = $_POST['password'];
$validatePassword = $_POST['validatePassword'];


if (editEmailAndPassword($userId, $email, $password, $validatePassword)) {
    redirectTo('page_profile.php');
} else {
    $_SESSION['currentUserId'] = $userId;
    redirectTo('page_security.php');
}


