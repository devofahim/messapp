<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

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
        // User is associated with a mess, fetch the mess ID
        $mess_row = mysqli_fetch_assoc($mess_members_result);
        $mess_id = $mess_row['mess_id'];

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Validate user_id input
            if (empty($_POST["user_id"])) {
                $user_id_error = "User ID is required";
            } else {
                $user_id_to_add = $_POST["user_id"];

                // Insert data into mess_members table
                $insert_query = "INSERT INTO mess_members (user_id, mess_id, job_title) VALUES ('$user_id_to_add', '$mess_id', 'member')";
                if (mysqli_query($db->conn, $insert_query)) {
                    echo "Member added successfully.";
                } else {
                    echo "Error adding member: " . mysqli_error($db->conn);
                }
            }
        }
    } else {
        echo "<p>You are not associated with any mess.</p>";
    }
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
    <title>Add Member</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Add Member</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="user_id">User ID:</label>
                <input type="text" class="form-control" id="user_id" name="user_id">
                <span class="text-danger"><?php if (isset($user_id_error)) echo $user_id_error; ?></span>
            </div>
            <button type="submit" class="btn btn-primary">Add Member</button>
        </form>


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
                // User is associated with a mess, fetch the mess ID
                $mess_row = mysqli_fetch_assoc($mess_members_result);
                $mess_id = $mess_row['mess_id'];

                // Get all members associated with the mess
                $members_query = "SELECT users.id, users.username FROM users 
                    INNER JOIN mess_members ON users.id = mess_members.user_id 
                    WHERE mess_members.mess_id = '$mess_id'";
                $members_result = mysqli_query($db->conn, $members_query);
            } else {
                echo "<p>You are not associated with any mess.</p>";
            }
        } else {
            echo "Error: User not found.";
            exit();
        }

        // Handle delete member request
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_member'])) {
            $member_id = $_POST['member_id'];

            // Delete member from mess_members table
            $delete_query = "DELETE FROM mess_members WHERE user_id='$member_id' AND mess_id='$mess_id'";
            if (mysqli_query($db->conn, $delete_query)) {
                // Refresh the page after successful deletion
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            } else {
                echo "Error deleting member: " . mysqli_error($db->conn);
            }
        }
        ?>
        <div class="container">
            <h3>Members:</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Username</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (isset($members_result)) {
                        while ($member = mysqli_fetch_assoc($members_result)) {
                            echo "<tr>";
                            echo "<td>" . $member['username'] . "</td>";
                            echo "<td>
                            <form method='POST' action='" . $_SERVER["PHP_SELF"] . "'>
                                <input type='hidden' name='member_id' value='" . $member['id'] . "'>
                                <button type='submit' name='delete_member' class='btn btn-danger'>Delete</button>
                            </form>
                        </td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>