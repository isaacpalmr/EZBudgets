<?php require_once "db_connect.php"; session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EZBudgets - Login</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            text-align: center;
            padding-top: 50px;
        }
        input, button {
            padding: 8px;
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <h1>EZBudgets</h1>

    <form method="POST">
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="login">Login</button>
    </form>

    <?php
    if (isset($_POST["login"])) {
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = $conn->query("SELECT * FROM users WHERE username='$username'");

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user["password"])) {
                $_SESSION["username"] = $user["username"];
                $_SESSION["first_name"] = $user["first_name"];
                $_SESSION["last_name"] = $user["last_name"];
                $_SESSION["user_id"] = $user["user_id"];

                header("Location: dashboard.php");
                exit;
            } else {
                echo "<p style='color:red;'>Incorrect password.</p>";
            }
        } else {
            echo "<p style='color:red;'>User not found.</p>";
        }
    }
    ?>

    <p>Not a user yet? <a href="../pages/index.php">Register now!</a></p>
</body>
</html>
