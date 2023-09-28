<?php
session_start();
include_once "services/commonServices.php";


$email = $_POST['email'];
$password = $_POST["password"];

$isLogged = login($email, $password);

if (!$isLogged) {
    setFlashMessage("danger", "Login or password is incorrect!");
    redirectTo('page_login.php');
} else {
    redirectTo('users.php');
}
