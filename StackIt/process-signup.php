<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['newUsername'];
    $password = $_POST['newPassword'];
    if (empty($username) || empty($password)) {
        die("All fields required.");
    }

    $users = json_decode(file_get_contents("users.json"), true) ?: [];
    if (isset($users[$username])) {
        die("Username already exists.");
    }

    $users[$username] = $password;
    file_put_contents("users.json", json_encode($users));
    header("Location: login.php");
    exit;
}
?>
