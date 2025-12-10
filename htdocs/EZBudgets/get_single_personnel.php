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
                SELECT u.name, u.salary, u.staff_title, u.is_pi_eligible, f.fringe_rate
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
                SELECT ugra_id AS id, name, residency, stipend_per_academic_year
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

    // GENERATED //
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $personnel_data = $result->fetch_assoc();
        
        if ($type === 'gra' || $type === 'ugrad') {
            $student_level = '';
            if ($type === 'ugrad') {
                $student_level = 'undergrad';
            } elseif ($type === 'gra') {
                if (stripos($personnel_data['program'], 'PhD') !== false || stripos($personnel_data['program'], 'Ph.D') !== false) {
                    $student_level = 'phd';
                } else {
                    $student_level = 'masters';
                }
            }
            $residency = $personnel_data['residency'];

            $tuition_sql = "
                SELECT 
                    SUM(base_tuition + mandatory_fees) AS tuition_per_academic_year,
                    MAX(tuition_increase_pct) AS projected_tuition_increase_pct
                FROM 
                    tuition_schedule
                WHERE 
                    student_level = '$student_level' AND 
                    residency = '$residency' AND 
                    semester IN ('fall', 'spring');
            ";
            
            $tuition_result = $conn->query($tuition_sql);
            
            if ($tuition_result && $tuition_result->num_rows > 0) {
                $tuition_row = $tuition_result->fetch_assoc();
                
                $personnel_data['tuition_per_academic_year'] = $tuition_row['tuition_per_academic_year'];
                $personnel_data['projected_tuition_increase_pct'] = $tuition_row['projected_tuition_increase_pct'];
                
            } else {
                $personnel_data['tuition_per_academic_year'] = '0.00'; 
                $personnel_data['projected_tuition_increase_pct'] = '0.0000';
            }
        }
        
        echo json_encode($personnel_data);
    } else {
        echo json_encode([]);
    }
    // GENERATED //
}

$conn->close();
?>