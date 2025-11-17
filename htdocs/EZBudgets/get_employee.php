<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezbudgets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['staff_id'])) {
    $staff_id = intval($_GET['staff_id']); // sanitize input
    $sql = "SELECT name, hourly_rate FROM university_employee WHERE staff_id = $staff_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode(['name'=>'Unknown', 'hourly_rate'=>0]);
    }
}

$conn->close();
?>
