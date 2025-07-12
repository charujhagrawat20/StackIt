<?php
session_start();

// Database connection (replace with your values if needed)
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "stackit";
$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Validation
    if (empty($email) || empty($username) || empty($password)) {
        $msg = "❌ All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "❌ Invalid email format.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check for duplicate email or username
        $checkSql = "SELECT * FROM user WHERE email = ? OR username = ?";
        $stmt = mysqli_prepare($conn, $checkSql);
        mysqli_stmt_bind_param($stmt, "ss", $email, $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $msg = "⚠️ Email or username already exists.";
        } else {
            // Insert new user
            $insertSql = "INSERT INTO user (email, username, password) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insertSql);
            mysqli_stmt_bind_param($stmt, "sss", $email, $username, $hashedPassword);
            if (mysqli_stmt_execute($stmt)) {
                $msg = "✅ Signup successful! Welcome, " . htmlspecialchars($username);
            } else {
                $msg = "❌ Error saving user: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up - StackIt</title>
  <link rel="stylesheet" href="style.css"/>
  <style>
    body { font-family: Arial; background-color: #f4f4f4; }
    .form-container {
      max-width: 400px;
      margin: 50px auto;
      background: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    input, button {
      width: 100%;
      padding: 10px;
      margin: 8px 0;
    }
    button {
      background: #28a745;
      color: white;
      border: none;
      cursor: pointer;
    }
    p { text-align: center; margin-top: 10px; }
  </style>
</head>
<body>

  <div class="form-container">
    <h2>Create Account</h2>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required><br>
      <input type="text" name="username" placeholder="Username" required><br>
      <input type="password" name="password" placeholder="Password" required><br>
      <button type="submit">Sign Up</button>
    </form>
    <p style="color: #cc0000;"><?php echo $msg; ?></p>
    <p><a href="login.php">Already have an account? Login</a></p>
  </div>

</body>
</html>
