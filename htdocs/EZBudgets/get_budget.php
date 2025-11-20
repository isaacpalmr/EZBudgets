<?php
// ============================
// get_budget.php
// ============================

// Safe error handling: log errors but don’t break JSON output
ini_set('display_errors', 1);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
error_reporting(E_ALL);

session_start();
include("db_connect.php");

header('Content-Type: application/json');

/**
 * Map personnel_type => canonical table name
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
 * Fetch the name for a given personnel_type + personnel_id
 */
function getPersonnelName(mysqli $conn, string $personnel_type, $personnel_id): string {
    $table = personnelTypeToTable($personnel_type);
    if (!$table) return '';

    $id = intval($personnel_id);

    // Map table => primary key column
    $pkMap = [
        'university_employee'              => 'staff_id',
        'post_doctoral_researchers'        => 'postdoc_id',
        'graduate_research_assistants'     => 'gra_id',
        'undergraduate_research_assistants'=> 'ugra_id'
    ];
    $pk = $pkMap[$table] ?? 'id';

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

// ============================
// Input validation
// ============================
if (!isset($_GET['budget_id'])) {
    echo json_encode(['success' => false, 'error' => 'No budget_id provided']);
    exit;
}
$budget_id = intval($_GET['budget_id']);
if ($budget_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid budget_id']);
    exit;
}

// ============================
// Fetch budget metadata
// ============================
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

// ============================
// Fetch budget personnel
// ============================
$personnel = [];
if ($stmt = $conn->prepare(
    "SELECT bp_id, budget_id, personnel_type, personnel_id, percent_effort, stipend_requested, stipend_amount 
     FROM budget_personnel 
     WHERE budget_id = ? 
     ORDER BY bp_id ASC"
)) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $row['name'] = getPersonnelName($conn, $row['personnel_type'], $row['personnel_id']) ?: "ID: ".$row['personnel_id'];

        $personnel[] = [
            'bp_id' => intval($row['bp_id']),
            'personnel_type' => $row['personnel_type'],
            'personnel_id' => intval($row['personnel_id']),
            'name' => $row['name'],
            'percent_effort' => floatval($row['percent_effort']),
            'stipend_requested' => intval($row['stipend_requested']),
            'stipend_amount' => floatval($row['stipend_amount'])
        ];
    }
    $stmt->close();
}

// ============================
// Fetch budget travels
// ============================
$travels = [];
if ($stmt = $conn->prepare(
    "SELECT travel_id, budget_id, travel_type, num_nights, num_travelers 
     FROM budget_travels 
     WHERE budget_id = ? 
     ORDER BY travel_id ASC"
)) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $travels[] = [
            'travel_id' => intval($row['travel_id']),
            'travel_type' => $row['travel_type'],
            'num_nights' => intval($row['num_nights']),
            'num_travelers' => intval($row['num_travelers'])
        ];
    }
    $stmt->close();
}

// ============================
// Fetch budget items
// ============================
$items = [];
if ($stmt = $conn->prepare(
    "SELECT id, budget_id, item_type, name, quantity, unit_cost 
     FROM budget_items 
     WHERE budget_id = ? 
     ORDER BY id ASC"
)) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $items[] = [
            'id' => intval($row['id']),
            'item_type' => $row['item_type'],
            'name' => $row['name'],
            'quantity' => intval($row['quantity']),
            'unit_cost' => floatval($row['unit_cost'])
        ];
    }
    $stmt->close();
}

// ============================
// Output JSON
// ============================
echo json_encode([
    'success' => true,
    'budget' => [
        'budget_id' => intval($budget['budget_id']),
        'user_id' => intval($budget['user_id']),
        'budget_name' => $budget['budget_name'],
        'funding_source' => $budget['funding_source'],
        'default_fa_year' => $budget['default_fa_year'],
        'default_tuition_year' => $budget['default_tuition_year'],
        'travel_is_international' => (bool)$budget['travel_is_international'],
        'start_date' => $budget['start_date'],
        'end_date' => $budget['end_date']
    ],
    'personnel' => $personnel,
    'travels' => $travels,
    'items' => $items
]);
