<?php
$conn = new mysqli("localhost", "root", "", "ezbudgets");

$html_table_id = $_GET['html_table_id'] ?? '';

switch ($html_table_id) {
    case 'pi-table':
        $sql = "SELECT staff_id AS id, name FROM university_employee";
        break;

    case 'post-docs':
        $sql = "SELECT postdoc_id AS id, name FROM post_doctoral_researchers ORDER BY name ASC";
        break;

    case 'pro-staff':
        $sql = "SELECT staff_id AS id, name FROM university_employee
                WHERE staff_title <> 'Faculty' ORDER BY name ASC";
        break;

    case 'gras':
        $sql = "SELECT gra_id AS id, name FROM graduate_research_assistants ORDER BY name ASC";
        break;
    
    case 'ugrads':
        $sql = "SELECT ugra_id AS id, name FROM undergraduate_research_assistants ORDER BY name ASC";
        break;

    default:
        $sql = "SELECT staff_id AS id, name FROM university_employee ORDER BY name ASC";
}

$result = $conn->query($sql);
$rows = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($rows);

?>