<?php

// GENERATED
require_once "db_connect.php";

$input = json_decode(file_get_contents("php://input"), true);
$prime_budget_id = intval($input["prime_budget_id"]);

if ($prime_budget_id <= 0) {
    http_response_code(400);
    echo json_encode(["error" => "invalid id"]);
    exit;
}

if ($stmt = $conn->prepare(
    "INSERT INTO subbudgets (prime_budget_id) VALUES (?)"
)) {
    $stmt->bind_param("i", $prime_budget_id);
    $stmt->execute();
    $newId = $stmt->insert_id;
    $stmt->close();

    echo json_encode(["subbudget_id" => $newId]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "db failure"]);
}
// GENERATED

?>