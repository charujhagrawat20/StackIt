<?php
session_start();

// Simulate login via URL (e.g., index.php?login=1 or ?logout=1)
if (isset($_GET['login'])) {
    $_SESSION['user'] = 'demoUser';
    header("Location: index.php");
    exit;
}
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit;
}

$loggedIn = isset($_SESSION['user']);

// Sample questions
$questions = [
    ['title' => 'How to use PHP?', 'views' => 120, 'answered' => false],
    ['title' => 'Difference between HTML and XHTML?', 'views' => 200, 'answered' => true]
];

function renderQuestions($questions) {
    $html = '';
    foreach ($questions as $q) {
        $html .= "<div class='question'>";
        $html .= "<h3>" . htmlspecialchars($q['title']) . "</h3>";
        $html .= "<p>Views: " . $q['views'] . "</p>";
        $html .= "<p>Status: " . ($q['answered'] ? "Answered" : "Unanswered") . "</p>";
        $html .= "</div>";
    }
    return $html;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>StackIt - Home</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }
    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: #333;
      color: #fff;
      padding: 10px 20px;
    }
    nav h1 {
      margin: 0;
    }
    .filters {
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .filters select,
    .filters button {
      padding: 5px;
    }
    .nav-right {
      display: flex;
      align-items: center;
    }
    .profile-container {
      position: relative;
      display: inline-block;
    }
    .profile-img {
      width: 40px;
      height: 40px;
      border-radius: 50%;
      cursor: pointer;
      border: 2px solid white;
    }
    .hamburger-menu {
      display: none;
      position: absolute;
      right: 0;
      top: 50px;
      background: #fff;
      border: 1px solid #ccc;
      border-radius: 5px;
      padding: 10px;
      z-index: 10;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      min-width: 150px;
    }
    .hamburger-menu.show {
      display: block;
    }
    .hamburger-menu button {
      display: block;
      width: 100%;
      padding: 8px 10px;
      margin: 5px 0;
      border: none;
      background: #f0f0f0;
      cursor: pointer;
      text-align: left;
    }
    .hamburger-menu button:hover {
      background: #e0e0e0;
    }
    .profile-large {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: block;
      margin: 0 auto 10px;
    }
    .questions {
      padding: 20px;
    }
    .question {
      border: 1px solid #ccc;
      border-radius: 5px;
      margin-bottom: 15px;
      padding: 15px;
    }
  </style>
</head>
<body>
  <nav>
    <h1>StackIt</h1>
    <div class="filters">
      <form method="get" action="">
        <select name="filter">
          <option>Newest</option>
          <option>Unanswered</option>
          <option>Most Viewed</option>
        </select>
        <button type="submit">Apply</button>
      </form>
      <a href="ask.php"><button>Ask Question</button></a>
    </div>
    <div class="nav-right">
      <div class="profile-container">
        <img src="img.jpg" class="profile-img" id="profileImg">
        <div class="hamburger-menu" id="profileMenu">
          <img src="img.jpg" class="profile-large">
          <?php if (!$loggedIn): ?>
            <form method="get" action="login.php">
              <button type="submit" name="login" value="1">Login</button>
            </form>
          <?php else: ?>
            <form method="get" action="login.php">
              <button type="submit" name="login" value="1">Login</button>
            </form>
            <form method="get" action="manage-profile.php">
              <button type="submit">Manage Profile</button>
            </form>
            <form method="get" action="">
              <button type="submit" name="logout" value="1">Logout</button>
            </form>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>

  <div class="questions">
    <?php echo renderQuestions($questions); ?>
  </div>

  <script>
    const profileImg = document.getElementById('profileImg');
    const profileMenu = document.getElementById('profileMenu');

    profileImg.addEventListener('click', function(event) {
      profileMenu.classList.toggle('show');
      event.stopPropagation(); // Prevent outside click from immediately closing it
    });

    document.addEventListener('click', function(event) {
      if (!profileMenu.contains(event.target) && event.target !== profileImg) {
        profileMenu.classList.remove('show');
      }
    });
  </script>
</body>
</html>
