<?php
session_start();
require_once 'user.php';

$userObj = new User();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($userObj->authenticateUser($username, $password)) {
        $_SESSION['username'] = $username;
        header("Location: welcome.php");
        exit();
    } else {
        echo "Incorrect username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="" method="POST">
            <input type="text" name="username" placeholder="Username" required><br>
            <input type="password" name="password" placeholder="Password" required><br>
            <input type="submit" name="login" value="Login">
        </form>
        <div class="link">
            Don't have an account? <a href="signup.php">Signup</a>
        </div>
    </div>
</body>
</html>
