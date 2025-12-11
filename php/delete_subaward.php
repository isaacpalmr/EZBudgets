<?php

// GENERATED
session_start();
include_once "db_connect.php";

header('Content-Type: application/json');

// Only authenticated users
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Not authenticated"]);
    exit;
}

// Read JSON payload
$input = json_decode(file_get_contents('php://input'), true);
$subbudget_id = isset($input['subbudget_id']) ? intval($input['subbudget_id']) : 0;

if ($subbudget_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid subbudget_id"]);
    exit;
}

try {
    // Optional: start transaction if you need to delete related rows
    $conn->begin_transaction();

    // Delete subbudget
    $stmt = $conn->prepare("DELETE FROM subbudgets WHERE subbudget_id = ?");
    $stmt->bind_param("i", $subbudget_id);
    $stmt->execute();

    if ($stmt->affected_rows === 0) {
        throw new Exception("No subaward found with that id");
    }

    $stmt->close();
    $conn->commit();

    echo json_encode(["success" => true, "subbudget_id" => $subbudget_id]);

} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(["error" => $e->getMessage()]);
}
// GENERATED