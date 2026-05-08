<?php
session_start();
include 'config.php';
$error = '';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Plain-text password check, no hashing.
    $query = "SELECT * FROM users WHERE username='$username' AND password='$password' LIMIT 1";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Laundry Shop Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
<div class="lightning"></div><div class="bolt"></div>
<div class="login-box">
    <h2>⚡ Laundry Shop</h2>
    <p>Modern Glassmorphism Management System</p>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="login">Login</button>
    </form>
    <p>No account? <a href="signup.php">Sign up here</a></p>
    <p class="small">Default: admin / admin123</p>
</div>
</body>
</html>
