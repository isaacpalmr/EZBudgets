<?php
// save_budget.php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
error_reporting(E_ALL);

session_start();
require_once "db_connect.php";

function respond($ok, $data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge(["success" => $ok], $data));
    exit;
}

if (!isset($_SESSION['user_id'])) {
    respond(false, ["error" => "Not authenticated"]);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) respond(false, ["error" => "Invalid JSON"]);

$subbudget_id      = isset($input['subbudget_id']) ? intval($input['subbudget_id']) : 0;
$prime_budget_id      = isset($input['prime_budget_id']) ? intval($input['prime_budget_id']) : 0;
$total_cost    = isset($input['total_cost']) ? intval($input['total_cost']) : 0;
$subaward_institution    = isset($input['subaward_institution']) ? trim($input['subaward_institution']) : "";
$personnel      = isset($input['personnel']) && is_array($input['personnel']) ? $input['personnel'] : [];
$travels        = isset($input['travels']) && is_array($input['travels']) ? $input['travels'] : [];
$items          = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];

try {
$conn->begin_transaction();

// Create or update budget
if ($subbudget_id <= 0) {
    $stmt = $conn->prepare("INSERT INTO subbudgets (prime_budget_id, subaward_institution, total_cost) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $prime_budget_id, $subaward_institution, $total_cost);
    $stmt->execute();
    $subbudget_id = $stmt->insert_id;
    $stmt->close();
} else {
    $stmt = $conn->prepare("UPDATE subbudgets SET prime_budget_id = ?, subaward_institution = ?, total_cost = ? WHERE subbudget_id = ?");
    $stmt->bind_param("isii", $prime_budget_id, $subaward_institution, $total_cost, $subbudget_id);
    $stmt->execute();
    $stmt->close();
}

// --- Clear old rows for this budget ---
// Personnel
$stmtDel = $conn->prepare("DELETE FROM subbudget_personnel WHERE subbudget_id = ?");
$stmtDel->bind_param("i", $subbudget_id);
$stmtDel->execute();
$stmtDel->close();

// Travels
$stmtDel = $conn->prepare("DELETE FROM subbudget_travels WHERE subbudget_id = ?");
$stmtDel->bind_param("i", $subbudget_id);
$stmtDel->execute();
$stmtDel->close();

// Itemized costs
$stmtDel = $conn->prepare("DELETE FROM subbudget_items WHERE subbudget_id = ?");
$stmtDel->bind_param("i", $subbudget_id);
$stmtDel->execute();
$stmtDel->close();


// --- Insert personnel ---
$stmtIns = $conn->prepare("
    INSERT INTO subbudget_personnel (subbudget_id, personnel_type, personnel_id, html_table_id, percent_effort, stipend_requested, tuition_requested)
    VALUES (?, ?, ?, ?, ?, ?, ?)
");
foreach ($personnel as $p) {
    $ptype = $p['personnel_type'];
    $html_table_id = $p['html_table_id'];
    $pid = intval($p['personnel_id'] ?? 0);
    $pct = intval($p['percent_effort'] ?? 0);
    $stip_req = isset($p['stipend_requested']) ? (int)($p['stipend_requested'] ? 1 : 0) : 0;
    $tuition_req = isset($p['tuition_requested']) ? (int)($p['tuition_requested'] ? 1 : 0) : 0;
    $stmtIns->bind_param("isisiid", $subbudget_id, $ptype, $pid, $html_table_id, $pct, $stip_req, $tuition_req);
    $stmtIns->execute();
}
$stmtIns->close();


// --- Insert travels ---
if (!empty($travels)) {
    $stmtTravel = $conn->prepare("
        INSERT INTO subbudget_travels 
            (subbudget_id, travel_type, num_nights, num_travelers)
        VALUES (?, ?, ?, ?)
    ");
    if (!$stmtTravel) throw new Exception("Travel prepare failed: " . $conn->error);

    foreach ($travels as $t) {
        $ttype = $t['travel_type'] ?? 'Domestic';
        $nights = intval($t['num_nights'] ?? 0);
        $travelers = intval($t['num_travelers'] ?? 0);

        if (!$stmtTravel->bind_param("isii", $subbudget_id, $ttype, $nights, $travelers)) {
            throw new Exception("Travel bind_param failed: " . $stmtTravel->error);
        }
        if (!$stmtTravel->execute()) {
            throw new Exception("Travel insert failed: " . $stmtTravel->error);
        }
    }
    $stmtTravel->close();
}


// --- Insert itemized costs ---
if (!empty($items)) {
    $stmtItem = $conn->prepare("
        INSERT INTO subbudget_items
            (subbudget_id, item_type, name, quantity, unit_cost)
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmtItem) throw new Exception("Item prepare failed: " . $conn->error);

    foreach ($items as $i) {
        $itype = $i['item_type'] ?? 'Other';
        $name = $i['name'] ?? '';
        $qty = intval($i['quantity'] ?? 0);
        $cost = floatval($i['unit_cost'] ?? 0);

        if (!$stmtItem->bind_param("issid", $subbudget_id, $itype, $name, $qty, $cost)) {
            throw new Exception("Item bind_param failed: " . $stmtItem->error);
        }
        if (!$stmtItem->execute()) {
            throw new Exception("Item insert failed: " . $stmtItem->error);
        }
    }
    $stmtItem->close();
}



$conn->commit();
respond(true, [
    "budget_id" => $subbudget_id,
    // "travels" => $travelResults, <- Caused warnings
    // "items" => $itemResults
]);

} catch (Exception $e) {
    $conn->rollback();
    respond(false, ["error" => $e->getMessage()]);
}
