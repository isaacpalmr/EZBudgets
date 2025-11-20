<?php
session_start();
include("db_connect.php");

header('Content-Type: application/json');

/**
 * Map personnel_type => canonical table name.
 */
function personnelTypeToTable(string $personnel_type): ?string {
    $map = [
        'PI'                 => 'university_employee',
        'staff'              => 'university_employee',
        'postdoc'            => 'post_doctoral_researchers',
        'grad_assistant'     => 'graduate_research_assistants',
        'undergrad_assistant'=> 'undergraduate_research_assistants'
    ];
    return $map[$personnel_type] ?? null;
}

/**
 * Fetch the name for a given personnel_type + personnel_id.
 */
function getPersonnelName(mysqli $conn, string $personnel_type, $personnel_id): string {
    $table = personnelTypeToTable($personnel_type);
    if (!$table) return '';

    $id = intval($personnel_id);

    // Map table => primary key column
    $pkMap = [
        'university_employee'             => 'staff_id',
        'post_doctoral_researchers'       => 'postdoc_id',
        'graduate_research_assistants'    => 'gra_id',
        'undergraduate_research_assistants'=> 'ugra_id'
    ];
    $pk = $pkMap[$table] ?? 'personnel_id'; // default fallback

    $sql = "SELECT name FROM `$table` WHERE `$pk` = ? LIMIT 1";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->bind_result($name);
        if ($stmt->fetch()) {
            $stmt->close();
            return (string)$name;
        }
        $stmt->close();
    }
    return '';
}


// Validate input
if (!isset($_GET['budget_id'])) {
    echo json_encode(['success' => false, 'error' => 'No budget_id provided']);
    exit;
}
$budget_id = intval($_GET['budget_id']);
if ($budget_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid budget_id']);
    exit;
}

// Fetch budget metadata
$budget = null;
if ($stmt = $conn->prepare("SELECT * FROM budgets WHERE budget_id = ? LIMIT 1")) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $budget = $row;
    }
    $stmt->close();
}

if (!$budget) {
    echo json_encode(['success' => false, 'error' => 'Budget not found']);
    exit;
}

// Fetch budget_personnel rows
$personnel = [];
if ($stmt = $conn->prepare("SELECT bp_id, budget_id, personnel_type, personnel_id, percent_effort, stipend_requested, stipend_amount FROM budget_personnel WHERE budget_id = ? ORDER BY bp_id ASC")) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        // Add human-readable name for TomSelect
        $row['name'] = getPersonnelName($conn, $row['personnel_type'], $row['personnel_id']) ?: "ID: ".$row['personnel_id'];
        
        // cast numeric-like fields for JS friendliness
        $row['bp_id'] = intval($row['bp_id'] ?? 0);
        $row['budget_id'] = intval($row['budget_id'] ?? 0);
        $row['personnel_id'] = intval($row['personnel_id'] ?? 0);
        $row['percent_effort'] = floatval($row['percent_effort'] ?? 0);
        $row['stipend_requested'] = intval($row['stipend_requested'] ?? 0);
        $row['stipend_amount'] = floatval($row['stipend_amount'] ?? 0);

        $personnel[] = $row;
    }
    $stmt->close();
}

// Return JSON
echo json_encode([
    'success' => true,
    'budget' => $budget,
    'personnel' => $personnel
]);
