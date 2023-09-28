<?php
session_start();
include_once "services/commonServices.php";

$email = $_POST['email'];
$password = $_POST['password'];

if (isset($email)) {
    $user = getUserByEmail($email);

    if (!$user) {
        addUser($email, $password);
        setFlashMessage( "success", "Successful registered");
        redirectTo('page_login.php');
    } else {
        setFlashMessage( "danger", "<strong>Уведомление!</strong> Этот эл. адрес уже занят другим пользователем.");
        redirectTo('page_register.php');
    }
}
