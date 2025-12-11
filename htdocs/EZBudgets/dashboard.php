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
    $budget_name = $_POST['budget_name'] ?? 'New Budget';

    $sql_insert = "INSERT INTO budgets (user_id, budget_name) VALUES ($user_id, '$budget_name')";
    if ($conn->query($sql_insert) === TRUE) {
        $new_budget_id = $conn->insert_id;
        header("Location: main.php?budget_id=$new_budget_id");
        exit();
    } else {
        $message = "Error creating budget: " . $conn->error;
    }
}

// Handle budget deletion
if (isset($_POST['delete_budget'])) {
    $delete_id = intval($_POST['delete_budget']);
    $sql_delete = "DELETE FROM budgets WHERE budget_id = $delete_id AND user_id = $user_id";
    if ($conn->query($sql_delete) === TRUE) {
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
    <title>Dashboard</title>
    <style>
        .delete-btn {
            background-color: red;
            border: none;
            cursor: pointer;
            padding: 1px;
            margin-left: 10px;
            border-radius: 4px;
        }
        .delete-btn img {
            width: 24px;
            height: 24px;
        }
        .modify-btn {
            background-color: orange;
            color: white;
            padding: 1px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 15px;
            display: inline-block;
        }
        .logout-btn {
            background-color: gray;
            color: white;
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-left: 10px;
        }
        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <h1>Welcome <?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></h1>

    <?php if (isset($message)) echo "<p style='color:red;'>$message</p>"; ?>

    <!-- Buttons at top -->
    <a href="add_personnel.php" class="modify-btn" 
        title="⚠️ WARNING: This page allows for manual addition of personnel and fringe rates into the database. This may allow for creation of inaccurate budgets.">
        Modify Database ⚠️
    </a>


    <form style="display:inline;" action="logout.php" method="POST">
        <button class="logout-btn" type="submit">Logout</button>
    </form>

    <h2>Your Budgets</h2>
    <ul>
    <?php
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $budget_id = $row['budget_id'];
            $budget_name = htmlspecialchars($row['budget_name']);

            echo "<li style='margin-bottom: 6px;'>
                    $budget_name

                    <!-- Edit Button -->
                    <a href='main.php?budget_id=$budget_id' style='display:inline-block; margin-left: 10px; vertical-align: middle;'>
                        <button type='button' style='background-color: rgb(255, 235, 59); border: 1px solid black; border-radius: 0; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; padding: 0; cursor: pointer;'>
                            <img src='Images/pencil.png' width='16' height='16' alt='Edit' style='display:block; margin:0;'>
                        </button>
                    </a>

                    <!-- Delete Button -->
                    <form method='POST' style='display:inline-block; vertical-align: middle; margin-left: 5px;'>
                        <button type='submit' name='delete_budget' value='$budget_id' style='background-color: rgb(255, 82, 82); border: 1px solid black; border-radius: 0; width: 24px; height: 24px; display: flex; justify-content: center; align-items: center; padding: 0; cursor: pointer;'>
                            <img src='Images/delete_forever_24dp_1F1F1F_FILL0_wght400_GRAD0_opsz24.png' width='16' height='16' alt='Delete' style='display:block; margin:0;'>
                        </button>
                    </form>

                </li>";
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
