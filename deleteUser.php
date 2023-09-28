<?php
session_start();
include_once 'services/commonServices.php';

$userId = $_GET['id'];
$user = getUserById($userId);

deleteUser($userId);
setFlashMessage('success', 'User successfully deleted');

if (isEqualUser($user, getLoggedUser())) {
    redirectTo('page_register.php');
} else {
    redirectTo('users.php');
}
