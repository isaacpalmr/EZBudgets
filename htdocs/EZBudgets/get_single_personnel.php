<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezbudgets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Check inputs
if (isset($_GET['personnelType'], $_GET['personnelId'])) {
    $type = $_GET['personnelType'];
    $id = intval($_GET['personnelId']); // sanitize numeric input

    switch ($type) {
        case 'staff':
            $sql = "
                SELECT u.name, u.hourly_rate, u.staff_title, u.is_pi_eligible, f.fringe_rate
                FROM university_employee u
                LEFT JOIN fringe_rate f ON u.staff_title = f.staff_title
                WHERE u.staff_id = $id
            ";
            break;

        case 'gra':
            $sql = "
                SELECT gra_id AS id, name, program, residency, max_fte, stipend_per_academic_year
                FROM graduate_research_assistants
                WHERE gra_id = $id
            ";
            break;
        
        case 'ugrad':
            $sql = "
                SELECT ugra_id AS id, name, stipend_per_academic_year
                FROM undergraduate_research_assistants
                WHERE ugra_id = $id
            ";
            break;
        
        case 'post-doc':
            $sql = "
                SELECT postdoc_id AS id, name, stipend_per_academic_year
                FROM post_doctoral_researchers
                WHERE postdoc_id = $id
            ";
            break;

        case 'student':
            $sql = "
                SELECT student_id AS id, name, degree, max_fte, stipend_per_year, residency
                FROM students
                WHERE student_id = $id
            ";
            break;

        default:
            echo json_encode([]);
            $conn->close();
            exit;
    }

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