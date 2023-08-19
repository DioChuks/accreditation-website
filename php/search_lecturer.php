<?php
error_reporting(0);
// Assuming you have established a database connection
include_once('connection.php');

// Fetch the deposit data from the database
$query = isset($_POST['search']) ? $_POST['search'] : 0;

// Sanitize and escape user input to prevent SQL injection
$safeQuery = $conn->real_escape_string($query);

$sql = "SELECT profile_id, name_profile FROM tbl_profile WHERE name_profile LIKE '%$safeQuery%'";

$result = $conn->query($sql);

// Create an array to store the deposit data
$profiles = array();

// Fetch each row from the result set
while ($row = $result->fetch_assoc()) {
    // Retrieve the customer username based on the customer ID
    $profile_id = $row['profile_id'];
    $profile_name = $row['name_profile'];

    // Store the deposit data in an associative array
    $profile = array(
        'profile_id' => $profile_id,
        'profile_name' => $profile_name,
    );

    // Add the deposit data to the deposits array
    $profiles[] = $profile;
}

// Close the database connection
$conn->close();

// Set the response header as JSON
header('Content-Type: application/json');

// Encode the deposits array as JSON and send the response
echo json_encode($profiles);
?>
