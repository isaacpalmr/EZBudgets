<?php
require_once 'util.php';

header('Content-Type: application/json');

$conn = new mysqli("localhost", "root", "", "ezbudgets");

// Abort immediately if the connection is barren.
if ($conn->connect_error) {
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

if (!isset($_GET['personnelType'], $_GET['personnelId'])) {
    echo json_encode([]);
    exit;
}

$type = $_GET['personnelType'];
$id   = intval($_GET['personnelId']);

echo json_encode(get_personnel_data($conn, $type, $id));

$conn->close();
?>