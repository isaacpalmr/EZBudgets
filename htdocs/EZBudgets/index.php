<?php include("db_connect.php"); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EZBudgets - Register</title>
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
        <input type="text" name="first_name" placeholder="First Name" required><br>
        <input type="text" name="last_name" placeholder="Last Name" required><br>
        <input type="text" name="username" placeholder="Username" required><br>
        <input type="text" name="email" placeholder="E-Mail" required><br>
        <input type="password" name="password" placeholder="Password" required><br>
        <button type="submit" name="register">Register</button>
    </form>

    <?php
    if (isset($_POST["register"])) {
        $first = $_POST["first_name"];
        $last = $_POST["last_name"];
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

        try {
            $sql = "INSERT INTO users (first_name, last_name, username, email, password, created_at, last_login)
                    VALUES ('$first', '$last', '$username', '$email', '$password', NOW(), NOW())";

            if ($conn->query($sql) === TRUE) {
                echo "<p style='color:green;'>Registration successful. <a href='login.php'>Login now</a></p>";
            } else {
                if ($conn->errno == 1062) {
                    echo "<p style='color:red;'>That username is already taken. Please choose another.</p>";
                } else {
                    echo "<p style='color:red;'>Database error: " . $conn->error . "</p>";
                }
            }
        } catch (Exception $e) {
            echo "<p style='color:red;'>Unexpected error: " . $e->getMessage() . "</p>";
        }
        $conn->close();
    }
    ?>

    <p>Already a user? <a href="login.php">Login here</a>.</p>
</body>
</html>
