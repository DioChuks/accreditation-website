<?php
error_reporting(0);
// Assuming you have established a database connection
include_once('connection.php');

// Fetch the deposit data from the database
$lastDepositId = isset($_GET['lastSchoolId']) ? $_GET['lastSchoolId'] : 0;
$sql = "SELECT sch_id, sch_name, sch_location, sch_type, staff_no FROM tbl_schools WHERE (sch_id > '$lastSchoolId') ORDER BY sch_id DESC LIMIT 7";

$result = $conn->query($sql);

// Create an array to store the deposit data
$schools = array();

// Fetch each row from the result set
while ($row = $result->fetch_assoc()) {
    // Retrieve the customer username based on the customer ID
    $school_id = $row['sch_id'];
    $school_name = $row['sch_name'];
    $school_location = $row['sch_location'];
    $school_type = $row['sch_type'];
    $school_staff = $row['staff_no'];

    // Store the deposit data in an associative array
    $school = array(
        'school_id' => $school_id,
        'school_name' => $school_name,
        'school_location' => $school_location,
        'school_type' => $school_type,
        'school_staff_no' => $school_staff
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
