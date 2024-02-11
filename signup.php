<?php
session_start();
require_once 'user.php';

$userObj = new User();

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userObj->createUser($username, $password)) {
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Error: Unable to signup.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Signup</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="signup" value="Signup">
        </form>
        <div class="link">
            Already have an account? <a href="login.php">Login</a>
        </div>
    </div>
</body>
</html>
