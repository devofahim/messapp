<?php
session_start();
require_once 'user.php';
require_once 'data/db.php'; // Include the database file

// Create a database connection
$db = new Database();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate mess name
    if (empty($_POST["mess_name"])) {
        $mess_name_error = "Mess name is required";
    } else {
        $mess_name = $_POST["mess_name"];
        
        // Get current logged-in user's ID
        $username = $_SESSION['username'];
        $user_query = "SELECT id FROM users WHERE username='$username'";
        $user_result = mysqli_query($db->conn, $user_query); // Use $db->conn to access the database connection
        
        if (mysqli_num_rows($user_result) == 1) {
            $row = mysqli_fetch_assoc($user_result);
            $user_id = $row['id'];

            // Create User object
            $userObj = new User();

            // Insert data into mess table
            $mess_id = $userObj->createMess($user_id, $mess_name);
            if ($mess_id) {
                // Redirect to add_auto_members_table.php
                header("Location: add_auto_members_table.php?mess_id=$mess_id&user_id=$user_id");
                exit();
            } else {
                echo "Error: Unable to create mess.";
                exit();
            }
        } else {
            echo "Error: User not found.";
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Mess</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Create Mess</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="mess_name">Mess Name:</label>
                <input type="text" class="form-control" id="mess_name" name="mess_name">
                <span class="text-danger"><?php if(isset($mess_name_error)) echo $mess_name_error; ?></span>
            </div>
            <button type="submit" class="btn btn-primary btn-sm">Create Mess</button>
        </form>
    </div>
</body>
</html>
