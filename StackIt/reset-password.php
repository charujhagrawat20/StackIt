<?php
require 'db.php';

$token = $_GET['token'] ?? '';
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $newPass = $_POST['password'];

    if (!empty($newPass)) {
        $hashed = password_hash($newPass, PASSWORD_DEFAULT);

        $sql = "UPDATE user SET password = ?, reset_token = NULL, reset_expiry = NULL 
                WHERE reset_token = ? AND reset_expiry > NOW()";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ss", $hashed, $token);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
            $msg = "Password has been reset. <a href='login.php'>Login now</a>";
        } else {
            $msg = "Invalid or expired token.";
        }
    } else {
        $msg = "Please enter a new password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <div class="form-container">
        <h2>Reset Password</h2>
        <?php if (!empty($token)): ?>
        <form method="POST">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <input type="password" name="password" placeholder="New Password" required>
            <button type="submit">Reset Password</button>
        </form>
        <?php else: ?>
            <p>Invalid token.</p>
        <?php endif; ?>
        <p><?php echo $msg; ?></p>
    </div>
</body>
</html>
