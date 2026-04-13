<?php
session_start();
include("includes/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $_SESSION['user'] = $username;
        header("Location: add_vehicle.php");
        exit();
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AutoCare Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="main-header">
    <div class="header-content">
        <img src="assets/images/logo.png" alt="Logo" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
</header>

<div class="login-box">
    <h2>Login</h2>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" id="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>
    </form>

    <?php if($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <div class="signup">
        Not a user? <a href="#">Sign up</a>
    </div>
</div>

<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

</body>
</html>