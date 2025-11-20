<?php
// save_budget.php

ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/php_errors.log');
error_reporting(E_ALL);

session_start();
include("db_connect.php");

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

$budget_id      = isset($input['budget_id']) ? intval($input['budget_id']) : 0;
$budget_name    = isset($input['budget_name']) ? trim($input['budget_name']) : "";
$funding_source = isset($input['funding_source']) ? trim($input['funding_source']) : "";
$start_date     = isset($input['start_date']) ? $input['start_date'] : null;
$end_date       = isset($input['end_date']) ? $input['end_date'] : null;
$personnel      = isset($input['personnel']) && is_array($input['personnel']) ? $input['personnel'] : [];
$travels        = isset($input['travels']) && is_array($input['travels']) ? $input['travels'] : [];
$items          = isset($input['items']) && is_array($input['items']) ? $input['items'] : [];

$user_id = intval($_SESSION['user_id']);

try {
    $conn->begin_transaction();

    // Create or update budget
    if ($budget_id <= 0) {
        $stmt = $conn->prepare("INSERT INTO budgets (user_id, budget_name, funding_source, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $budget_name, $funding_source, $start_date, $end_date);
        $stmt->execute();
        $budget_id = $stmt->insert_id;
        $stmt->close();
    } else {
        $stmt = $conn->prepare("UPDATE budgets SET budget_name = ?, funding_source = ?, start_date = ?, end_date = ? WHERE budget_id = ?");
        $stmt->bind_param("ssssi", $budget_name, $funding_source, $start_date, $end_date, $budget_id);
        $stmt->execute();
        $stmt->close();
    }

    // --- Clear old rows for this budget ---
// Personnel
$stmtDel = $conn->prepare("DELETE FROM budget_personnel WHERE budget_id = ?");
$stmtDel->bind_param("i", $budget_id);
$stmtDel->execute();
$stmtDel->close();

// Travels
$stmtDel = $conn->prepare("DELETE FROM budget_travels WHERE budget_id = ?");
$stmtDel->bind_param("i", $budget_id);
$stmtDel->execute();
$stmtDel->close();

// Itemized costs
$stmtDel = $conn->prepare("DELETE FROM budget_items WHERE budget_id = ?");
$stmtDel->bind_param("i", $budget_id);
$stmtDel->execute();
$stmtDel->close();


// --- Insert personnel ---
$stmtIns = $conn->prepare("
    INSERT INTO budget_personnel (budget_id, personnel_type, personnel_id, percent_effort, stipend_requested, stipend_amount)
    VALUES (?, ?, ?, ?, ?, ?)
");
foreach ($personnel as $p) {
    $ptype = $p['personnel_type'] ?? 'staff';
    $pid = intval($p['personnel_id'] ?? 0);
    $pct = intval($p['percent_effort'] ?? 0);
    $stip_req = isset($p['stipend_requested']) ? (int)($p['stipend_requested'] ? 1 : 0) : 0;
    $stip_amt = floatval($p['stipend_amount'] ?? 0);
    $stmtIns->bind_param("isiiid", $budget_id, $ptype, $pid, $pct, $stip_req, $stip_amt);
    $stmtIns->execute();
}
$stmtIns->close();


// --- Insert travels ---
if (!empty($travels)) {
    $stmtTravel = $conn->prepare("
        INSERT INTO budget_travels 
            (budget_id, travel_type, num_nights, num_travelers)
        VALUES (?, ?, ?, ?)
    ");
    if (!$stmtTravel) throw new Exception("Travel prepare failed: " . $conn->error);

    foreach ($travels as $t) {
        $ttype = $t['travel_type'] ?? 'Domestic';
        $nights = intval($t['num_nights'] ?? 0);
        $travelers = intval($t['num_travelers'] ?? 0);

        if (!$stmtTravel->bind_param("isii", $budget_id, $ttype, $nights, $travelers)) {
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
        INSERT INTO budget_items
            (budget_id, item_type, name, quantity, unit_cost)
        VALUES (?, ?, ?, ?, ?)
    ");
    if (!$stmtItem) throw new Exception("Item prepare failed: " . $conn->error);

    foreach ($items as $i) {
        $itype = $i['item_type'] ?? 'Other';
        $name = $i['name'] ?? '';
        $qty = intval($i['quantity'] ?? 0);
        $cost = floatval($i['unit_cost'] ?? 0);

        if (!$stmtItem->bind_param("issid", $budget_id, $itype, $name, $qty, $cost)) {
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
        "budget_id" => $budget_id,
        "travels" => $travelResults,
        "items" => $itemResults
    ]);

} catch (Exception $e) {
    $conn->rollback();
    respond(false, ["error" => $e->getMessage()]);
}
