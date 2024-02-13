<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'data/db.php';

// Create a database connection
$db = new Database();

// Get current logged-in user's ID
$username = $_SESSION['username'];
$user_query = "SELECT id FROM users WHERE username='$username'";
$user_result = mysqli_query($db->conn, $user_query);

if (mysqli_num_rows($user_result) == 1) {
    $row = mysqli_fetch_assoc($user_result);
    $user_id = $row['id'];

    // Check if user_id exists in mess_members table
    $mess_members_query = "SELECT mess_id FROM mess_members WHERE user_id='$user_id'";
    $mess_members_result = mysqli_query($db->conn, $mess_members_query);

    if (mysqli_num_rows($mess_members_result) > 0) {
        $mess_row = mysqli_fetch_assoc($mess_members_result);
        $mess_id = $mess_row['mess_id'];

        // Fetch members of the mess from users table
        $members_query = "SELECT id, username FROM users WHERE id IN (SELECT user_id FROM mess_members WHERE mess_id='$mess_id')";
        $members_result = mysqli_query($db->conn, $members_query);
    } else {
        echo "<p>You are not associated with any mess.</p>";
        exit();
    }
} else {
    echo "Error: User not found.";
    exit();
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form data
    $user_id_selected = $_POST['user_id'];
    $meal_count = $_POST['meal_count'];

    print_r($user_id_selected);

    // Insert into meal table
    $insert_query = "INSERT INTO meal (user_id, mess_id, meal_count) VALUES ('$user_id_selected', '$mess_id', '$meal_count')";
    if (mysqli_query($db->conn, $insert_query)) {
        echo "Meal added successfully.";
    } else {
        echo "Error adding meal: " . mysqli_error($db->conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Meal</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Add Meal</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="user_id">Select User:</label>
                <select class="form-control" id="user_id" name="user_id">
                    <?php
                    while ($member = mysqli_fetch_assoc($members_result)) {
                        echo "<option value='" . $member['id'] . "'>" . $member['username'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="meal_count">Meal Count:</label>
                <input type="number" class="form-control" id="meal_count" name="meal_count" min="1" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Meal</button>
        </form>
        
    </div>


    <?php
// Check if the user is logged in

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

// Include database connection
require_once 'data/db.php';
$db = new Database();

// Get the current logged-in user's ID
$username = $_SESSION['username'];
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

        // Fetch all meals associated with the mess
        $meals_query = "SELECT meal.id, users.username, meal.meal_count, meal.datetime 
                        FROM meal 
                        INNER JOIN users ON meal.user_id = users.id 
                        WHERE meal.mess_id = '$mess_id'";
        $meals_result = mysqli_query($db->conn, $meals_query);
    } else {
        echo "<p>You are not associated with any mess.</p>";
    }
} else {
    echo "Error: User not found.";
    exit();
}

// Handle delete meal request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_meal'])) {
    $meal_id = $_POST['meal_id'];

    // Delete meal from the meal table
    $delete_query = "DELETE FROM meal WHERE id='$meal_id'";
    if (mysqli_query($db->conn, $delete_query)) {
        // Refresh the page after successful deletion
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "Error deleting meal: " . mysqli_error($db->conn);
    }
}
?>

<div class="container">
    <h3>Meals:</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Username</th>
                <th>Meal Count</th>
                <th>Meal Date Time</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($meal = mysqli_fetch_assoc($meals_result)) {
                echo "<tr>";
                echo "<td>" . $meal['username'] . "</td>";
                echo "<td>" . $meal['meal_count'] . "</td>";
                echo "<td>" . $meal['datetime'] . "</td>";
                echo "<td>
                    <form method='POST' action='" . $_SERVER["PHP_SELF"] . "'>
                        <input type='hidden' name='meal_id' value='" . $meal['id'] . "'>
                        <button type='submit' name='delete_meal' class='btn btn-danger'>Delete</button>
                    </form>
                </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>

</html>
