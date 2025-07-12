<?php
session_start();

// Simulate login for demonstration (you could replace this with real auth logic)
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Guest';
}

// Handle profile update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newUsername = trim($_POST['username'] ?? '');
    if (!empty($newUsername)) {
        $_SESSION['username'] = htmlspecialchars($newUsername);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Profile - StackIt</title>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>
  <nav>
    <h1>StackIt</h1>
    <button onclick="location.href='index.php'">Home</button>
  </nav>

  <div class="form-container">
    <h2>Manage Profile</h2>
    <p><strong>Username:</strong> <?php echo $_SESSION['username']; ?></p>

    <form method="POST">
      <label for="username">Edit Username:</label>
      <input type="text" name="username" id="username" value="<?php echo $_SESSION['username']; ?>" required /><br>
      <button type="submit">Update</button>
    </form>
  </div>
</body>
</html>
