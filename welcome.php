<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

require_once 'data/db.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Create a database connection
$db = new Database();
// Get current logged-in user's ID
$username = $_SESSION['username'];
$user_query = "SELECT id FROM users WHERE username='$username'";
$user_result = mysqli_query($db->conn, $user_query);

if (mysqli_num_rows($user_result) == 1) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = $row['id'];

    // Check if user_id exists in mess table
    $mess_query = "SELECT * FROM mess WHERE user_id='$user_id'";
    $mess_result = mysqli_query($db->conn, $mess_query);

    $showCreateMessButton = (mysqli_num_rows($mess_result) == 0); // True if user_id doesn't exist in mess table
} else {
    echo "Error: User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Welcome, <?php echo $username; ?>!</h2>
        <?php if ($showCreateMessButton) : ?>
            <a href="create_mess.php"><button class="btn btn-success btn-sm">Create Mess </button></a>
        <?php else : ?>

        <?php endif; ?>

        <?php

$username = $_SESSION['username'];

require_once 'data/db.php';

// Create a database connection
$db = new Database();

// Get current logged-in user's ID
$user_query = "SELECT id FROM users WHERE username='$username'";
$user_result = mysqli_query($db->conn, $user_query);

if (mysqli_num_rows($user_result) == 1) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = $row['id'];

    // Check if user_id exists in mess_members table
    $mess_members_query = "SELECT * FROM mess_members WHERE user_id='$user_id'";
    $mess_members_result = mysqli_query($db->conn, $mess_members_query);

    if (mysqli_num_rows($mess_members_result) > 0) {
        // User is associated with a mess, fetch the mess name
        $mess_row = mysqli_fetch_assoc($mess_members_result);
        $mess_id = $mess_row['mess_id'];

        // Check if the user is a manager
        $manager_query = "SELECT * FROM mess_members WHERE mess_id = '$mess_id' AND user_id = '$user_id' AND job_title = 'manager'";
        $manager_result = mysqli_query($db->conn, $manager_query);

        if (mysqli_num_rows($manager_result) > 0) {
            // User is a manager, display the "Add Member" button
            echo '<a href="add_member.php" class="btn btn-primary">Add Member</a>';
        }
    } else {
        echo "<p>You are not associated with any mess.</p>";
    }
} else {
    echo "Error: User not found.";
    exit();
}
?>


        <?php

$username = $_SESSION['username'];

require_once 'data/db.php';

// Create a database connection
$db = new Database();

// Get current logged-in user's ID
$user_query = "SELECT id FROM users WHERE username='$username'";
$user_result = mysqli_query($db->conn, $user_query);

if (mysqli_num_rows($user_result) == 1) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = $row['id'];

    // Check if user_id exists in mess_members table
    $mess_members_query = "SELECT * FROM mess_members WHERE user_id='$user_id'";
    $mess_members_result = mysqli_query($db->conn, $mess_members_query);

    if (mysqli_num_rows($mess_members_result) > 0) {
        // User is associated with a mess, fetch the mess name
        $mess_row = mysqli_fetch_assoc($mess_members_result);
        $mess_id = $mess_row['mess_id'];

        // Fetch the mess name associated with the mess ID
        $mess_query = "SELECT mess_name FROM mess WHERE id='$mess_id'";
        $mess_result = mysqli_query($db->conn, $mess_query);

        if (mysqli_num_rows($mess_result) == 1) {
            $mess_row = mysqli_fetch_assoc($mess_result);
            $mess_name = $mess_row['mess_name'];

            // Fetch the name of the user associated with the mess
            $user_query = "SELECT username FROM users WHERE id IN (SELECT user_id FROM mess_members WHERE mess_id='$mess_id')";
            $user_result = mysqli_query($db->conn, $user_query);

            if (mysqli_num_rows($user_result) > 0) {
                $user_row = mysqli_fetch_assoc($user_result);
                $user_name = $user_row['username'];

                ?>
                <p><b>Mess Name: </b><?php echo $mess_name; ?></p>
                <p><b>Created By: </b><?php echo $user_name; ?></p>
            <?php } else {
                echo "Error: User not found.";
            }
        } else {
            echo "Error: Mess not found.";
        }
    } else {
        echo "<p>You are not associated with any mess.</p>";
    }
} else {
    echo "Error: User not found.";
    exit();
}
?>

<?php

$username = $_SESSION['username'];

require_once 'data/db.php';

// Create a database connection
$db = new Database();

// Get current logged-in user's ID
$user_query = "SELECT id FROM users WHERE username='$username'";
$user_result = mysqli_query($db->conn, $user_query);

if (mysqli_num_rows($user_result) == 1) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = $row['id'];

    // Check if user_id exists in mess_members table
    $mess_members_query = "SELECT * FROM mess_members WHERE user_id='$user_id'";
    $mess_members_result = mysqli_query($db->conn, $mess_members_query);

    if (mysqli_num_rows($mess_members_result) > 0) {
        // User is associated with a mess, fetch the mess name
        $mess_row = mysqli_fetch_assoc($mess_members_result);
        $mess_id = $mess_row['mess_id'];

        // Check if there is a manager for the mess
        $manager_query = "SELECT users.username FROM users JOIN mess_members ON users.id = mess_members.user_id WHERE mess_members.mess_id = '$mess_id' AND mess_members.job_title = 'manager'";
        $manager_result = mysqli_query($db->conn, $manager_query);

        if (mysqli_num_rows($manager_result) > 0) {
            $manager_row = mysqli_fetch_assoc($manager_result);
            $manager_username = $manager_row['username'];

            echo "<p><b>Manager of the Mess:</b> $manager_username</p>";
        }

    } else {
        echo "<p>You are not associated with any mess.</p>";
    }
} else {
    echo "Error: User not found.";
    exit();
}
?>
        <div class="link">
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