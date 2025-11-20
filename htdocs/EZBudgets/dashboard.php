<?php
session_start();
include("db_connect.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

// Handle new budget creation
if (isset($_POST['create_budget'])) {
    $budget_name = $_POST['budget_name'];

    // Insert new budget into the table
    $sql_insert = "INSERT INTO budgets (user_id, budget_name) VALUES ($user_id, '$budget_name')";
    if ($conn->query($sql_insert) === TRUE) {
        // Get the newly created budget ID
        $new_budget_id = $conn->insert_id;

        // Redirect to budget setup page with budget_id in query string
        header("Location: PI.php?budget_id=$new_budget_id");
        exit();
    } else {
        $message = "Error creating budget: " . $conn->error;
    }
}

// Fetch budgets for the user (for display)
$sql = "SELECT * FROM budgets WHERE user_id = $user_id"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>

    <?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>

    <h2>Your Budgets</h2>
    <ul>
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {

        $budget_id = $row['budget_id'];
        $budget_name = htmlspecialchars($row['budget_name']);
        //$years = htmlspecialchars($row['total_years']);

        echo "
            <li>
                $budget_name
                <a href='PI.php?budget_id=$budget_id' 
                   style='margin-left: 10px;'>
                   <button>Edit</button>
                </a>
            </li>
        ";
    }
} else {
    echo "<li>No budgets yet.</li>";
}
?>
</ul>


    <form method="POST">
        <button type="submit" name="create_budget">Create Budget</button>
    </form>
</body>
</html>
