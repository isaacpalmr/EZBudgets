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
<link rel="stylesheet" href="styles.css">

<style>
    body {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
    }

    main {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0;
        padding: 20px;
    }

    h1, h2 {
        text-align: center;
    }

    ul {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding: 0;
        width: 100%;
    }

    li {
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

    .modify-database {
        color: black;
        /* margin-bottom: 20px; */
        text-decoration: none;
    }

    .logout-btn {
        color: white;
        background-color: #1D1E18;
    }

    .create-budget {
        /* margin-top: 20px; */
        margin: 0px 0px;
    }
</style>
</head>
<body>

<h1>EZBudgets</h1>

<?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>

<main>
    <div class="card-container" style="
        display: flex; 
        flex-direction: column;
        align-items: center; 
        gap: 10px; 
        margin-bottom: 20px;">
        <h2 style="padding: 0px; margin-top: 0px">
            Welcome, <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?>!
        </h2>

        <form action="add_personnel.php" method="GET">
            <button class="modify-database dark-border big-button" type="submit">
                Modify Database
            </button>
        </form>

        <form action="../php/logout.php" method="POST">
            <button class="logout-btn dark-border big-button" type="submit">Logout</button>
        </form>
    </div>

    <div class="card-container" style="width: 100%; max-width: 500px; display: flex; align-items: center; flex-direction: column">
        <h2 style="padding: 0px; margin-top: 0px; margin-bottom: 15px">
            Your Budgets
        </h2>
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
                                
                                <button class='edit-button dark-border' style='width: 32px; height: 32px'>
                                    <img src='../images/pencil.png' width='20' height='20'>
                                </button>
                            </a>
                            <form method='POST'>
                                <button type='submit' name='delete_budget' value='$budget_id' class='rem_row dark-border'>
                                    <img src='../images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png' width='24' height='24'>
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

        
    </div>

    <form method="POST">
        <button type="submit" name="create_budget" class="create-budget dark-border big-button">
            Create Budget
        </button>
    </form>
</main>

</body>
</html>
