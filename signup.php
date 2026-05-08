<?php
include 'config.php';
$message = '';
$error = '';
if (isset($_POST['signup'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $check = mysqli_query($conn, "SELECT id FROM users WHERE username='$username'");
    if (mysqli_num_rows($check) > 0) {
        $error = 'Username already exists';
    } else {
        // Plain-text password save, no hashing.
        $sql = "INSERT INTO users(name, username, password, role) VALUES('$name', '$username', '$password', 'staff')";
        if (mysqli_query($conn, $sql)) {
            $message = 'Account created. You can now login.';
        } else {
            $error = 'Signup failed: ' . mysqli_error($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Sign Up</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body class="login-body">
<div class="lightning"></div><div class="bolt"></div>
<div class="login-box">
    <h2>🧺 Create Account</h2>
    <p>Register staff account</p>
    <?php if ($message): ?><p class="success"><?php echo $message; ?></p><?php endif; ?>
    <?php if ($error): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <form method="POST">
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" name="signup">Sign Up</button>
    </form>
    <p><a href="login.php">Back to Login</a></p>
</div>
</body>
</html>
