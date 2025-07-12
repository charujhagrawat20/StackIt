<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("You must be logged in to post a question.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $tags = $_POST['tags'];

    if (empty($title) || empty($content)) {
        die("Title and content required.");
    }

    $questions = json_decode(file_get_contents("questions.json"), true) ?: [];
    $questions[] = [
        'title' => $title,
        'content' => $content,
        'tags' => $tags,
        'author' => $_SESSION['username'],
        'timestamp' => date("Y-m-d H:i:s")
    ];
    file_put_contents("questions.json", json_encode($questions));
    header("Location: index.php");
    exit;
}
?>
