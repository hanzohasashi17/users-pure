<?php
session_start();
include_once "services/commonServices.php";

$userId = $_POST['id'];
$userStatus = $_POST['status'];

setUserStatus($userId, $userStatus);
setFlashMessage('info', 'User status successfully updated');
redirectTo('users.php');