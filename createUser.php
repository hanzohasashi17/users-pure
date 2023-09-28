<?php
session_start();
include_once "services/commonServices.php";

$email = $_POST['email'];
$password = $_POST['password'];
$userName = $_POST['userName'];
$jobTitle = $_POST['jobTitle'];
$phone = $_POST['phone'];
$address = $_POST['address'];
$status = $_POST['status'];
$image = $_FILES['image'];
$vk = $_POST['vk'];
$telegram = $_POST['telegram'];
$instagram = $_POST['instagram'];

if (getUserByEmail($email)) {
    setFlashMessage("danger", "This user already exists");
    redirectTo('create_user.php');
}

$userId = addUser($email, $password);
editUserInfo($userId, $userName, $jobTitle, $phone, $address);
setUserStatus($userId, $status);
uploadUserAvatar($userId, $image);
setFlashMessage("success", "User created successfully");
addSocNetAddress($userId, $vk, $telegram, $instagram);
redirectTo('users.php');