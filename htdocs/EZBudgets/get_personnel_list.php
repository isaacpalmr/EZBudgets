<?php
$conn = new mysqli("localhost", "root", "", "ezbudgets");

$filter = $_GET['filter'] ?? '';

switch ($filter) {
    case 'pi':
        $sql = "SELECT staff_id AS id, name FROM university_employee";
        break;

    case 'post-doc':
        $sql = "SELECT postdoc_id AS id, name FROM post_doctoral_researchers ORDER BY name ASC";
        break;

    case 'pro-staff':
        $sql = "SELECT staff_id AS id, name FROM university_employee
                WHERE staff_title <> 'Faculty' ORDER BY name ASC";
        break;

    case 'gra':
        $sql = "SELECT gra_id AS id, name FROM graduate_research_assistants ORDER BY name ASC";
        break;
    
    case 'ugrad':
        $sql = "SELECT ugra_id AS id, name FROM undergraduate_research_assistants ORDER BY name ASC";
        break;
    
    case 'student':
        $sql = "SELECT student_id AS id, name FROM students ORDER BY name ASC";
        break;

    default:
        $sql = "SELECT staff_id AS id, name FROM university_employee ORDER BY name ASC";
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);

?>