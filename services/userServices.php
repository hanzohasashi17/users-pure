<?php
include_once "helpServices.php";

function addUser(string $email, string $password): int
{
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $db = connectToDB();
    $db->exec("INSERT INTO `user` (`email`, `password`) VALUES ('$email', '$hashedPassword')");
    $user = getUserByEmail($email);
    return $user['id'];
}

function getUsers(): array
{
    $db = connectToDB();
    return $db->query("SELECT * FROM `user`")->fetchAll();
}

function isAdmin($user): bool
{
    if ($user['role'] === 'admin') {
        return true;
    };
    return false;
}

function getLoggedUser(): array
{
    return $_SESSION["loggedUser"];
}

function isEqualUser($user, $loggedUser): bool
{
    return $user['id'] === $loggedUser['id'];
}

function getUserStatus($status): string
{
    if ($status === "online") {
        return "success";
    } elseif ($status === "moved_away") {
        return "warning";
    } else {
        return "danger";
    }
}

function getUserByEmail(string $email): array | false
{
    $db = connectToDB();
    return $db->query("SELECT * FROM `user` WHERE `email` = '$email'")->fetch(PDO::FETCH_ASSOC);
}

function editUserInfo($id, $userName, $jobTitle, $phone, $address): bool
{
    $db = connectToDB();
    $db->exec("UPDATE `user` SET `userName`='$userName', `jobTitle`='$jobTitle', `phone`='$phone', `address`='$address' WHERE `id`='$id'");
    return true;
}

function setUserStatus($id, $status): bool
{
    $db = connectToDB();
    $db->exec("UPDATE `user` SET `status`='$status' WHERE `id`='$id'");
    return true;
}

function uploadUserAvatar($id, array $image): bool
{
    if ($image['name'] !== ""){
        $imageName = 'uploads/' . uniqid('image_') . $image['name'];
        $db = connectToDB();
        $db->exec("UPDATE `user` SET `image`='$imageName' WHERE `id`='$id'");
        move_uploaded_file($image['tmp_name'], $imageName);
        return true;
    }
    return false;
}

function addSocNetAddress($id, $vk, $telegram, $instagram): bool
{
    $db = connectToDB();
    $db->exec("UPDATE `user` SET `vk`='$vk', `telegram`='$telegram', `instagram`='$instagram' WHERE `id`='$id'");
    return true;
}

function getUserById(string $id): array | false
{
    $db = connectToDB();
    return $db->query("SELECT * FROM `user` WHERE `id` = '$id'")->fetch(PDO::FETCH_ASSOC);
}

function isEmailFree($db, $currentUserId, $email): bool
{
    $otherUser = $db->query("SELECT `id` FROM `user` WHERE `email`='$email'")->fetch(PDO::FETCH_ASSOC);
    if (!$otherUser || (int)$currentUserId === $otherUser['id']) {
        return true;
    }
    return false;
}

function editEmailAndPassword($id, $email, $password, $validatePassword): bool
{
    $db = connectToDB();
    if ($password !== $validatePassword) {
        setFlashMessage('danger', 'Password fields do not match');
        return false;
    } elseif (!isEmailFree($db, $id, $email)) {
        setFlashMessage('danger', 'Email is not uniq');
        return false;
    }
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $db->exec("UPDATE `user` SET `email`='$email', `password`='$hashedPassword' WHERE `id`='$id'");
    setFlashMessage('info', 'User successfully updated');
    return true;
}

function deleteUser($id)
{
    $db = connectToDB();
    $db->exec("DELETE FROM `user` WHERE `id`='$id'");
    return true;
}

function logout()
{
    unset($_SESSION['loggedUser']);
    return true;
}