<?php
$conn = new mysqli("localhost", "root", "", "ezbudgets");

$filter = $_GET['filter'] ?? '';

switch ($filter) {
    case 'pi':
        $sql = "SELECT staff_id, name FROM university_employee 
                WHERE is_pi_eligible = 1 ORDER BY name ASC";
        break;

    case 'postdoc':
        $sql = "SELECT staff_id, name FROM university_employee 
                WHERE staff_title = 'Post Doc' ORDER BY name ASC";
        break;

    case 'prostaff':
        $sql = "SELECT staff_id, name FROM university_employee
                WHERE staff_title <> 'Post Doc' and staff_title <> 'Faculty' ORDER BY name ASC";
        break;

    default:
        $sql = "SELECT staff_id, name FROM university_employee ORDER BY name ASC";
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);

?>