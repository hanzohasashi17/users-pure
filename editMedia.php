<?php
session_start();
include_once "services/commonServices.php";

$userId = $_POST['id'];
$image = $_FILES['image'];

if (!uploadUserAvatar($userId, $image)) {
    setFlashMessage('danger', 'User avatar is not updated');
} else {
    setFlashMessage('info', 'User avatar successfully updated');
}
$_SESSION['currentUserId'] = $userId;
redirectTo('page_profile.php');