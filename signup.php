<?php
session_start();
include("includes/db.php");

$success = false;
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $mobile = $_POST['mobile'];
    $country_code = $_POST['country_code'];
    $state = $_POST['state'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];
    $address = $_POST['address'];
    $notify_email = isset($_POST['notify_email']) ? 1 : 0;

    // check if email OR username exists
    $check = "SELECT * FROM users WHERE email='$email' OR username='$username'";
    $result = $conn->query($check);

    if ($result->num_rows > 0) {
        $error = "Username or Email already exists!";
    } else {

        $sql = "INSERT INTO users 
        (name, username, email, password, mobile, country_code, state, city, pincode, address, notify_email) 
        VALUES 
        ('$name', '$username', '$email', '$password', '$mobile', '$country_code', '$state', '$city', '$pincode', '$address', '$notify_email')";

        if ($conn->query($sql) === TRUE) {
            $success = true;
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>AutoCare Signup</title>
    <link rel="stylesheet" href="assets/css/style.css">

    <script>
        function showSuccessAndRedirect() {
            alert("Signed up successfully!");
            window.location.href = "index.php";
        }
    </script>
</head>

<body>

<header class="main-header">
    <div class="header-content" onclick="window.location.href='home.php'" style="cursor:pointer;">
        <img src="assets/images/logo.png" class="logo">
        <span class="divider">|</span>
        <h1>Auto<span>Care</span></h1>
    </div>
</header>

<div class="login-box">
    <h2>Create Account</h2>

    <form method="POST">

        <input type="text" name="name" placeholder="Full Name" required>

        <input type="text" name="username" placeholder="Username" required>

        <input type="email" name="email" placeholder="Email Address" required>

        <input type="password" name="password" placeholder="Password" required>

        <div style="display:flex; gap:10px;">
            <input type="text" name="country_code" placeholder="+91" style="width:30%;" required>
            <input type="text" name="mobile" placeholder="Mobile Number" style="width:70%;" required>
        </div>

        <input type="text" name="state" placeholder="State" required>
        <input type="text" name="city" placeholder="City" required>
        <input type="text" name="pincode" placeholder="Pincode" required>

        <textarea name="address" placeholder="Full Address" rows="3" style="width:100%; padding:10px; margin-top:10px;"></textarea>

        <label style="display:inline-flex; align-items:center; gap:8px; margin-top:10px; white-space:nowrap;">
            <input type="checkbox" name="notify_email" checked style="margin:0; transform: translateY(0px);">
            <span>Receive email notifications</span>
        </label>

        <button type="submit">Sign Up</button>

    </form>

    <?php if($error != "") { ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <div class="signup">
        Already have an account? <a href="index.php">Login</a>
    </div>
</div>
<br><br><br><br><br><br>
<footer>
    © 2026 AutoCare | Designed by AutoCare Team
</footer>

<?php if($success) { ?>
<script>
    showSuccessAndRedirect();
</script>
<?php } ?>

</body>
</html>