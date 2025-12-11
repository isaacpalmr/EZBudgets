<?php
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "ezbudgets");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit;
}

// Fetch all travel profiles
$sql = "SELECT travel_type, airfare, max_lodging_days, per_diem FROM travel_profiles";
$result = $conn->query($sql);

$profiles = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $profiles[$row['travel_type']] = [
            "airfare" => floatval($row['airfare']),
            "max_lodging_days" => intval($row['max_lodging_days']),
            "per_diem" => floatval($row['per_diem'])
        ];
    }
}

echo json_encode($profiles);
$conn->close();
?>