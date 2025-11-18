<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>
</body>
</html>
