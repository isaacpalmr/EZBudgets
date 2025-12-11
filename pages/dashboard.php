<?php
session_start();
include("../php/db_connect.php");

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../php/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['first_name'];
$last_name = $_SESSION['last_name'];

// Handle new budget creation
if (isset($_POST['create_budget'])) {
    $budget_name = $_POST['budget_name'] ?? 'New Budget';
    $sql_insert = "INSERT INTO budgets (user_id, budget_name) VALUES ($user_id, '$budget_name')";
    if ($conn->query($sql_insert) === TRUE) {
        $new_budget_id = $conn->insert_id;
        header("Location: edit_budget.php?budget_id=$new_budget_id");
        exit();
    } else {
        $message = "Error creating budget: " . $conn->error;
    }
}

// Handle budget deletion
if (isset($_POST['delete_budget'])) {
    $delete_id = intval($_POST['delete_budget']);

    // Delete all subawards for this budget
    $stmtSub = $conn->prepare("DELETE FROM subbudgets WHERE prime_budget_id = ?");
    $stmtSub->bind_param("i", $delete_id);
    $stmtSub->execute();
    $stmtSub->close();

    // Now delete the budget itself
    $stmtBudget = $conn->prepare("DELETE FROM budgets WHERE budget_id = ? AND user_id = ?");
    $stmtBudget->bind_param("ii", $delete_id, $user_id);
    if ($stmtBudget->execute()) {
        $stmtBudget->close();
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Error deleting budget: " . $conn->error;
    }
}

// Fetch budgets for the user
$sql = "SELECT * FROM budgets WHERE user_id = $user_id"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Dashboard - EZBudgets</title>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">
<style>
    body {
        font-family: "Open Sans", sans-serif;
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
    }

    h1, h2 {
        text-align: center;
        margin-bottom: 10px;
    }

    ul {
        list-style: none;
        padding: 0;
        margin: 20px 0;
        width: 100%;
        max-width: 500px;
    }

    li {
        margin-bottom: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #f8f8f8;
        padding: 10px;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .buttons {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    button, .modify-btn, .logout-btn {
        font-family: "Open Sans", sans-serif;
        cursor: pointer;
        border-radius: 4px;
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 0;
    }

    .modify-btn {
        background-color: orange;
        color: white;
        padding: 8px 12px;
        margin-bottom: 20px;
        text-decoration: none;
    }

    .logout-btn {
        background-color: gray;
        color: white;
        padding: 8px 12px;
        border: none;
        margin-left: 10px;
    }

    .budget-btn {
        width: 24px;
        height: 24px;
        padding: 0;
        border: 1px solid black;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(255, 235, 59);
    }

    .delete-btn {
        width: 24px;
        height: 24px;
        padding: 0;
        border: 1px solid black;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgb(255, 82, 82);
    }

    form.create-budget {
        margin-top: 20px;
    }
</style>
</head>
<body>

<h1>EZBudgets</h1>
<h2>Welcome <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h2>

<?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>

<div style="display: flex; justify-content: center; gap: 10px; margin-bottom: 20px;">
    <a href="add_personnel.php" class="modify-btn" 
        title="⚠️ WARNING: This page allows for manual addition of personnel and fringe rates into the database. This may allow for creation of inaccurate budgets.">
        Modify Database ⚠️
    </a>


    <form style="display:inline;" action="../php/logout.php" method="POST">
        <button class="logout-btn" type="submit">Logout</button>
    </form>
</div>

<h2>Your Budgets</h2>
<ul>
<?php
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $budget_id = $row['budget_id'];
        $budget_name = htmlspecialchars($row['budget_name']);
        echo "<li>
                <span>$budget_name</span>
                <div class='buttons'>
                    <a href='edit_budget.php?budget_id=$budget_id'>
                        <button type='button' class='budget-btn'>
                            <img src='../images/pencil.png' width='16' height='16' alt='Edit'>
                        </button>
                    </a>
                    <form method='POST'>
                        <button type='submit' name='delete_budget' value='$budget_id' class='delete-btn'>
                            <img src='../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png' width='16' height='16' alt='Delete'>
                        </button>
                    </form>
                </div>
              </li>";
    }
} else {
    echo "<li>No budgets yet.</li>";
}
?>
</ul>

<form class="create-budget" method="POST" style="display: flex; justify-content: center; margin-top: 20px;">
    <button type="submit" name="create_budget" 
        style="background-color: rgb(1, 255, 136); border: 1px solid black; border-radius: 4px; width: 100px; height: 32px; cursor: pointer; font-family: 'Open Sans', sans-serif; font-weight: 600;">
        Create Budget
    </button>
</form>


</body>
</html>
