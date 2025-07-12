<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/style.css"/>
  <title>StackIt</title>
  <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/quill-emoji@0.1.7/dist/quill-emoji.css" rel="stylesheet"/>
</head>
<body>
<nav>
  <h1>StackIt</h1>
  <div class="filters">
    <button onclick="window.location.href='index.php'">Home</button>
    <button onclick="window.location.href='ask.php'">Ask Question</button>
  </div>
  <div class="nav-right">
    <div class="profile-container">
      <img src="img/img.jpg" class="profile-img" onclick="toggleProfileMenu()">
      <div class="hamburger-menu" id="profileMenu">
        <img src="img/img.jpg" class="profile-large">
        <?php if(isset($_SESSION['username'])): ?>
          <button onclick="window.location.href='manage-profile.php'">Manage Profile</button>
          <button onclick="window.location.href='logout.php'">Logout</button>
        <?php else: ?>
          <button onclick="window.location.href='login.php'">Login</button>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<script src="js/script.js"></script>
