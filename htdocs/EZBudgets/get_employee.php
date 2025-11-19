<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezbudgets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if (isset($_GET['staff_id'])) {
    $staff_id = intval($_GET['staff_id']); // sanitize input
    $sql = 
    "SELECT u.name, u.hourly_rate, u.staff_title, u.is_pi_eligible, f.fringe_rate
    FROM university_employee u
    LEFT JOIN fringe_rate f
        ON u.staff_title = f.staff_title
    WHERE staff_id = $staff_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo json_encode([]);
    }
}

$conn->close();
?>
