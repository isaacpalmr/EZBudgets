
<?php
//Generated

// get_subbudget_details.php
header('Content-Type: application/json');

$subbudget_id = isset($_GET['subbudget_id']) ? intval($_GET['subbudget_id']) : 0;
if (!$subbudget_id) {
    echo json_encode(['error' => 'No subbudget_id provided']);
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ezbudgets";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(['error' => 'DB connection failed']);
    exit;
}

// Get main budget_id and granted_to from budget_subawards, and budget_name + dates from budgets
$stmt = $conn->prepare("
    SELECT b.budget_name, s.granted_to, b.start_date, b.end_date
    FROM budget_subawards s
    JOIN budgets b ON s.budget_id = b.budget_id
    WHERE s.subbudget_id = ?
");
$stmt->bind_param("i", $subbudget_id);
$stmt->execute();
$stmt->bind_result($budget_name, $granted_to, $start_date, $end_date);

if ($stmt->fetch()) {
    echo json_encode([
        'budget_name' => $budget_name,
        'granted_to' => $granted_to,
        'start_date' => $start_date,
        'end_date' => $end_date
    ]);
} else {
    echo json_encode(['error' => 'Subbudget not found']);
}

$stmt->close();
$conn->close();

//Generated