<?php
session_start();
require_once 'db.php';

$loginMessage = "";

// Auto-login using cookie
if (isset($_COOKIE['remember_user']) && !isset($_SESSION['user'])) {
    $_SESSION['user'] = $_COOKIE['remember_user'];
    header("Location: index.php");
    exit();
}

// Handle login form
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $remember = isset($_POST['remember']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM user WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($row = mysqli_fetch_assoc($result)) {
                if (password_verify($password, $row['password'])) {
                    $_SESSION['user'] = $row['username'];

                    if ($remember) {
                        setcookie("remember_user", $row['username'], time() + (86400 * 30), "/");
                    }

                    header("Location: index.php");
                    exit();
                } else {
                    $loginMessage = "Incorrect password.";
                }
            } else {
                $loginMessage = "Username not found.";
            }
        } else {
            $loginMessage = "Database error: " . mysqli_error($conn);
        }
    } else {
        $loginMessage = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - StackIt</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f0f6ff;
      margin: 0;
      padding: 0;
    }
    header, footer {
      background-color: #333;
      color: white;
      padding: 15px 20px;
      text-align: center;
    }
    .form-container {
      background-color: #d9ecff;
      max-width: 350px;
      margin: 60px auto;
      padding: 25px 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    .form-container h2 {
      text-align: center;
      margin-bottom: 20px;
    }
    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      margin: 10px 0 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .remember-row {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }
    .remember-row input[type="checkbox"] {
      margin-right: 8px;
    }
    .login-btn {
      width: 100%;
      background-color: #dee5f2ff;
      color: black;
      padding: 10px;
      border: none;
      border-radius: 4px;
      font-weight: bold;
      cursor: pointer;
    }
    .login-btn:hover {
      background-color: #c4c8ceff;
    }
    .links a {
      text-align: center;
      display: block;
      margin-top: 10px;
      text-decoration: none;
      color: #007bff;
    }
    p.message {
      color: red;
      text-align: center;
    }
  </style>
</head>
<body>

<header>
  <h1>Welcome to StackIt</h1>
</header>

<div class="form-container">
  <h2>Login</h2>
  <form method="POST" action="login.php">
    <label>Username</label>
    <input type="text" name="username" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <div class="remember-row">
      <input type="checkbox" name="remember" id="remember">
      <label for="remember">Remember me</label>
    </div>

    <button type="submit" class="login-btn">LOGIN</button>
  </form>

  <p class="message"><?php echo $loginMessage; ?></p>

  <div class="links">
    <a href="signup.php">Don't have an account? Sign up</a>
    <a href="forgot-password.php">Forgot password?</a>
  </div>
</div>

<footer>
  &copy; <?php echo date('Y'); ?> StackIt. All rights reserved.
</footer>

</body>
</html>
