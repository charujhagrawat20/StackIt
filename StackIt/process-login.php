<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if (empty($username) || empty($password)) {
        die("Both fields required.");
    }

    $users = json_decode(file_get_contents("users.json"), true) ?: [];
    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['username'] = $username;
        header("Location: index.php");
        exit;
    } else {
        die("Invalid credentials.");
    }
}
?>
