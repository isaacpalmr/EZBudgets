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
if (!isset($_GET['subbudget_id'])) {
    echo json_encode(['success' => false, 'error' => 'No subbudget_id provided']);
    exit;
}
$subbudget_id = intval($_GET['subbudget_id']);
if ($subbudget_id <= 0) {
    echo json_encode(['success' => false, 'error' => 'Invalid subbudget_id']);
    exit;
}

// ============================
// Fetch budget metadata
// ============================
$subbudget = null;
if ($stmt = $conn->prepare("SELECT * FROM subbudgets WHERE subbudget_id = ? LIMIT 1")) {
    $stmt->bind_param("i", $subbudget_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $row = $result->fetch_assoc()) {
        $subbudget = $row;
    }
    $stmt->close();
}

if (!$subbudget) {
    echo json_encode(['success' => false, 'error' => 'Budget not found']);
    exit;
}

// ============================
// Fetch budget personnel
// ============================
$personnel = [];
if ($stmt = $conn->prepare(
    "SELECT id, subbudget_id, personnel_type, personnel_id, html_table_id, percent_effort, stipend_requested, tuition_requested
     FROM subbudget_personnel 
     WHERE subbudget_id = ? 
     ORDER BY id ASC"
)) {
    $stmt->bind_param("i", $subbudget_id);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $canonical_personnel_data = get_personnel_data($conn, $row['personnel_type'], $row['personnel_id']);
        $subbudget_personnel_data = [
            'type' => $row['personnel_type'],
            "html_table_id" => $row["html_table_id"],
            'percent_effort' => floatval($row['percent_effort']),
            'stipend_requested' => intval($row['stipend_requested']),
            'tuition_requested' => intval($row['tuition_requested']),
        ];

        $personnel[] = array_merge(
            // Budget personnel data (mostly user input)
            $subbudget_personnel_data,

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
    "SELECT travel_id, subbudget_id, travel_type, num_nights, num_travelers 
     FROM subbudget_travels 
     WHERE subbudget_id = ? 
     ORDER BY travel_id ASC"
)) {
    $stmt->bind_param("i", $subbudget_id);
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
    "SELECT id, subbudget_id, item_type, name, quantity, unit_cost 
     FROM subbudget_items 
     WHERE subbudget_id = ? 
     ORDER BY id ASC"
)) {
    $stmt->bind_param("i", $subbudget_id);
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
        'subbudget_id' => intval($subbudget['subbudget_id']),
        'subaward_institution' => $subbudget['subaward_institution'],
    ],
    'personnel' => $personnel,
    'travels' => $travels,
    'items' => $items
]);
