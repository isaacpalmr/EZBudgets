<?php
// save_budget.php
session_start();
include("db_connect.php");

// Basic response helper
function respond($ok, $data = []) {
    header('Content-Type: application/json');
    echo json_encode(array_merge(["success" => $ok], $data));
    exit;
}

// require user login if you use sessions
if (!isset($_SESSION['user_id'])) {
    respond(false, ["error" => "Not authenticated"]);
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) respond(false, ["error" => "Invalid JSON"]);

$budget_id      = isset($input['budget_id']) ? intval($input['budget_id']) : 0;
$budget_name          = isset($input['budget_name']) ? trim($input['budget_name']) : "";
$funding_source = isset($input['funding_source']) ? trim($input['funding_source']) : "";
$start_date     = isset($input['start_date']) ? $input['start_date'] : null;
$end_date       = isset($input['end_date']) ? $input['end_date'] : null;
$personnel      = isset($input['personnel']) && is_array($input['personnel']) ? $input['personnel'] : [];

$user_id = intval($_SESSION['user_id']);

try {
    // Use transaction to keep things consistent
    $conn->begin_transaction();

    if ($budget_id <= 0) {
        // create new budget
        $stmt = $conn->prepare("INSERT INTO budgets (user_id, budget_name, funding_source, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $user_id, $budget_name, $funding_source, $start_date, $end_date);
        $stmt->execute();
        $budget_id = $stmt->insert_id;
        $stmt->close();
    } else {
        // update existing budget (only if the budget_id belongs to this user or you have different permission rules)
        $stmt = $conn->prepare("UPDATE budgets SET budget_name = ?, funding_source = ?, start_date = ?, end_date = ? WHERE budget_id = ?");
        $stmt->bind_param("ssssi", $budget_name, $funding_source, $start_date, $end_date, $budget_id);
        $stmt->execute();
        $stmt->close();
    }

    // Remove old personnel rows for this budget
    $stmtDel = $conn->prepare("DELETE FROM budget_personnel WHERE budget_id = ?");
    $stmtDel->bind_param("i", $budget_id);
    $stmtDel->execute();
    $stmtDel->close();

    // Insert new personnel rows
    // Columns expected: budget_id, personnel_type, personnel_id, percent_effort, stipend_requested, stipend_amount
    $stmtIns = $conn->prepare("
        INSERT INTO budget_personnel 
            (budget_id, personnel_type, personnel_id, percent_effort, stipend_requested, stipend_amount)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
    if (!$stmtIns) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    foreach ($personnel as $p) {
        // normalize and validate values
        $ptype = isset($p['personnel_type']) ? $p['personnel_type'] : 'staff';
        $pid = isset($p['personnel_id']) ? intval($p['personnel_id']) : 0;
        $pct = isset($p['percent_effort']) ? intval($p['percent_effort']) : 0;
        $stip_req = isset($p['stipend_requested']) ? (int)($p['stipend_requested'] ? 1 : 0) : 0;
        $stip_amt = isset($p['stipend_amount']) ? floatval($p['stipend_amount']) : 0.00;

        // Safe fallback for personnel_type - keep aligned with DB enum
        $allowed = ['PI','staff','postdoc','student','grad_assistant','undergrad_assistant'];
        if (!in_array($ptype, $allowed)) {
            // attempt some common synonyms
            $map = [
                'gra' => 'grad_assistant',
                'ugrad' => 'undergrad_assistant',
                'grad_assistant' => 'grad_assistant',
                'undergrad_assistant' => 'undergrad_assistant',
                'post-doc' => 'postdoc',
                'postdoc' => 'postdoc',
                'PI' => 'PI',
                'Co-PI' => 'PI',
            ];
            if (isset($map[$ptype])) $ptype = $map[$ptype];
            // if still not allowed, default to staff
            if (!in_array($ptype, $allowed)) $ptype = 'staff';
        }

        $stmtIns->bind_param("isiiid", $budget_id, $ptype, $pid, $pct, $stip_req, $stip_amt);
        $stmtIns->execute();
    }

    $stmtIns->close();

    $conn->commit();

    respond(true, ["budget_id" => $budget_id]);

} catch (Exception $e) {
    $conn->rollback();
    respond(false, ["error" => $e->getMessage()]);
}
