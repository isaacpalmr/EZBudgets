<?php
/**
 * Retrieve personnel metadata + optional tuition data.
 */
function get_personnel_data(mysqli $conn, string $type, int $id) {
    if ($conn->connect_errno) {
        return [];
    }

    switch ($type) {
        case 'staff':
            $sql = "
                SELECT staff_id AS id, u.name, u.salary, u.staff_title, u.is_pi_eligible, f.fringe_rate
                FROM university_employee u
                LEFT JOIN fringe_rate f ON u.staff_title = f.staff_title
                WHERE u.staff_id = $id
            ";
            break;

        case 'gra':
            $sql = "
                SELECT gra_id AS id, name, program, residency, stipend_per_academic_year
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

        default:
            return [
                'error' => true,
                'message' => "Unrecognized personnel type: {$type}"
            ];
    }

    $result = $conn->query($sql);
    if (!$result || $result->num_rows === 0) {
        return [];
    }

    $data = $result->fetch_assoc();

    // Tuition augmentation for GRA/UGRAD
    if ($type === 'gra' || $type === 'ugrad') {

        if ($type === 'ugrad') {
            $student_level = 'undergrad';
        } else { 
            $program = $data['program'];
            $student_level =
                (stripos($program, 'PhD') !== false || stripos($program, 'Ph.D') !== false)
                ? 'phd'
                : 'masters';
        }

        $residency = $data['residency'];

        $tuition_sql = "
            SELECT 
                SUM(base_tuition + mandatory_fees) AS tuition_per_academic_year,
                MAX(tuition_increase_pct) AS projected_tuition_increase_pct
            FROM tuition_schedule
            WHERE 
                student_level = '$student_level'
                AND residency = '$residency'
                AND semester IN ('fall', 'spring')
        ";

        $tres = $conn->query($tuition_sql);

        if ($tres && $tres->num_rows > 0) {
            $t = $tres->fetch_assoc();
            $data['tuition_per_academic_year']       = $t['tuition_per_academic_year'];
            $data['projected_tuition_increase_pct'] = $t['projected_tuition_increase_pct'];
        } else {
            $data['tuition_per_academic_year']       = '0.00';
            $data['projected_tuition_increase_pct'] = '0.0000';
        }
    }

    return $data;
}
?>