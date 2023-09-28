<?php

function connectToDB(): PDO
{
    return new PDO("mysql:host=localhost;dbname=pure;", 'root', '');
}

function validatePassword(string $email, string $password): bool
{
    $db = connectToDB();
    $hash = $db->query("SELECT `password` FROM `user` WHERE `email` = '$email'")->fetch();
    return password_verify($password, $hash['password']);
}

function redirectTo(string $path): void
{
    header("Location: {$path}");
}

function setFlashMessage(string $key, string $message): void
{
    $_SESSION["$key"] = $message;
}

function getFlashMessage(string $key): void
{
    if (isset($_SESSION["$key"])) {
        echo "<div class=\"alert alert-{$key} text-dark\" role=\"alert\">{$_SESSION["$key"]}</div>";
        unset($_SESSION["$key"]);
    }
}

function login($email, $password): bool
{
    $user = getUserByEmail($email);
    $passwordIsValid = validatePassword($email, $password);
    if (!$user || !$passwordIsValid) {
        return false;
    } else {
        $_SESSION['loggedUser'] = $user;
        return true;
    }
}

function isNotLogin(): bool
{
    return !$_SESSION["loggedUser"];
}

