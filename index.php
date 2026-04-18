<?php
session_start();
include("includes/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // find user by email OR username
    $sql = "SELECT * FROM users WHERE email='$username' OR username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {

        $row = $result->fetch_assoc();

        // verify password
        if (password_verify($password, $row['password'])) {

            $_SESSION['user'] = $row['username'];
            header("Location: vehicles.php");
            exit();

        } else {
            $error = "Invalid password";
        }

    } else {
        $error = "User not found";
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
    <div class="header-content" onclick="window.location.href='home.php'" style="cursor:pointer;">
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
        Not a user? <a href="signup.php">Sign up</a>
    </div>
</div>

<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

</body>
</html>