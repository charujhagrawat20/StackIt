<?php
require 'db.php';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');

    if (!empty($email)) {
        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", time() + 3600); // 1 hour

        $sql = "UPDATE user SET reset_token = ?, reset_expiry = ? WHERE email = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $token, $expiry, $email);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $resetLink = "http://localhost/StackIt/reset-password.php?token=$token";
            // Simulate sending email
            $msg = "Password reset link: <a href='$resetLink'>$resetLink</a>";
        } else {
            $msg = "Email not found.";
        }
    } else {
        $msg = "Please enter your email.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
</head>
<body>
    <div class="form-container">
        <h2>Forgot Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Your email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <p><?php echo $msg; ?></p>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
