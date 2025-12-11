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
require_once "db_connect.php";

require_once 'util.php';

header('Content-Type: application/json');

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
    "SELECT id, budget_id, personnel_type, personnel_id, html_table_id, percent_effort, stipend_requested, tuition_requested
     FROM budget_personnel 
     WHERE budget_id = ? 
     ORDER BY id ASC"
)) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $canonical_personnel_data = get_personnel_data($conn, $row['personnel_type'], $row['personnel_id']);
        $budget_personnel_data = [
            'type' => $row['personnel_type'],
            "html_table_id" => $row["html_table_id"],
            'percent_effort' => floatval($row['percent_effort']),
            'stipend_requested' => intval($row['stipend_requested']),
            'tuition_requested' => intval($row['tuition_requested']),
        ];

        $personnel[] = array_merge(
            // Budget personnel data (mostly user input)
            $budget_personnel_data,

            // Canonical personnel data
            $canonical_personnel_data
        );
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
// Fetch budget subawards
// ============================
$subawards = [];
if ($stmt = $conn->prepare(
    "SELECT id, budget_id, subbudget_id
     FROM budget_subawards
     WHERE budget_id = ?
     ORDER BY id ASC"
)) {
    $stmt->bind_param("i", $budget_id);
    $stmt->execute();
    $res = $stmt->get_result();

    while ($row = $res->fetch_assoc()) {
        $subbudget_id = (int)$row['subbudget_id'];

        // Query subbudget metadata
        $stmt2 = $conn->prepare(
            "SELECT subaward_institution, total_cost
             FROM subbudgets
             WHERE subbudget_id = ?"
        );
        $stmt2->bind_param("i", $subbudget_id);
        $stmt2->execute();
        $sub = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();

        $subawards[] = [
            "subbudget_id" => $subbudget_id,
            "subaward_institution" => $sub["subaward_institution"] ?? "",
            "total_cost" => intval($sub["total_cost"] ?? 0)
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
        'start_date' => $budget['start_date'],
        'end_date' => $budget['end_date']
    ],
    'personnel' => $personnel,
    'travels' => $travels,
    'items' => $items,
    'subawards' => $subawards,
]);
