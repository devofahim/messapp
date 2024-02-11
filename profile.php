<?php
session_start();
require_once 'user.php';
require_once 'profile.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$profileObj = new user(); // Create an instance of Profile class, not User
$userDetails = $profileObj->getUserDetails($username);

if (!$userDetails) {
    echo "Error: Unable to fetch user details.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Profile</h2>
        <div class="profile-details">
            <p><strong>Username:</strong> <?php echo $userDetails['username']; ?></p>
            <!-- Add more profile details here as needed -->
        </div>
        <div class="link">
            <a href="welcome.php">Back to Home</a>
            <a href="logout.php">Logout</a>
        </div>
        <nav class="bottom-menu">
            <a href="dashboard.php" class="menu-item info"><i class="fas fa-info-circle"></i> Dashboard</a>
            <a href="welcome.php" class="menu-item home"><i class="fas fa-home"></i> Home</a>
            <a href="profile.php" class="menu-item profile"><i class="fas fa-user"></i> Profile</a>
        </nav>
    </div>
</body>
</html>
