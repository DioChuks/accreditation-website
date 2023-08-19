<?php
error_reporting(0);
// Assuming you have established a database connection
include_once('connection.php');
// Fetch the deposit data from the database
$query = isset($_POST['search']) ? $_POST['search'] : 0;

// Sanitize and escape user input to prevent SQL injection
$safeQuery = $conn->real_escape_string($query);

$sql = "SELECT sch_id, sch_name FROM tbl_schools WHERE sch_name LIKE '%$safeQuery%'";

$result = $conn->query($sql);

// Create an array to store the deposit data
$schools = array();

// Fetch each row from the result set
while ($row = $result->fetch_assoc()) {
    // Retrieve the customer username based on the customer ID
    $school_id = $row['sch_id'];
    $school_name = $row['sch_name'];

    // Store the deposit data in an associative array
    $school = array(
        'school_id' => $school_id,
        'school_name' => $school_name,
    );

    // Add the deposit data to the deposits array
    $schools[] = $school;
}

// Close the database connection
$conn->close();

// Set the response header as JSON
header('Content-Type: application/json');

// Encode the deposits array as JSON and send the response
echo json_encode($schools);
?>
