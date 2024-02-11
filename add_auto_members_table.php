<?php
session_start();
require_once 'data/db.php'; // Include the database file

// Create a database connection
$db = new Database();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
// Check if user_id exists in the mess table
$user_id = $_GET['user_id'];
$check_query = "SELECT id FROM mess WHERE user_id='$user_id'"; // Fetching 'mess_id' instead of 'id'
$check_result = mysqli_query($db->conn, $check_query);

if (!$check_result || mysqli_num_rows($check_result) == 0) {
    echo "Error: User ID does not exist in the mess table.";
    exit();
}

// Fetch the mess_id associated with the provided user_id
$row = mysqli_fetch_assoc($check_result);
$mess_id = $row['id']; // Retrieving 'mess_id'

// Insert data into mess_members table
$job_title = "manager"; // Assuming the job_title is always "manager" for the creator
$insert_query = "INSERT INTO mess_members (user_id, mess_id, job_title) VALUES ('$user_id', '$mess_id', '$job_title')";

if (mysqli_query($db->conn, $insert_query)) {
    // Redirect to welcome.php
    header("Location: welcome.php");
    exit();
} else {
    echo "Error: " . $insert_query . "<br>" . mysqli_error($db->conn);
}
?>
