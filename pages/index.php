<?php 
include("../php/db_connect.php"); //Connect to database
?>

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
            echo "<p style='color:green;'>Registration successful. <a href='../php/login.php'>Login now</a></p>";
        } else {
            // Check for duplicate username (MySQL error code 1062)
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

<p>Already a user? <a href="../php/login.php">Login here</a>.</p>
