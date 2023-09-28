<?php
session_start();
include_once "services/userServices.php";

$userId = $_POST['id'];
$userName = $_POST['userName'];
$jobTitle = $_POST['jobTitle'];
$address = $_POST['address'];
$phone = $_POST['phone'];

editUserInfo($userId, $userName, $jobTitle, $phone, $address);
setFlashMessage('info', 'User successfuly updated');
$_SESSION['currentUserId'] = $userId;
redirectTo('page_profile.php');