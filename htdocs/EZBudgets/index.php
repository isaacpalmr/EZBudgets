<?php include("db.php"); ?>

<form method="POST">
    <input type="text" name="first_name" placeholder="First Name" required><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br>
    <input type="text" name="username" placeholder="Username" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <button type="submit" name="register">Register</button>
</form>


<?php
if (isset($_POST["register"])) {
    $first = $_POST["first_name"];
    $last = $_POST["last_name"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO users (first_name, last_name, username, password) 
                VALUES ('$first', '$last', '$username', '$password')";
        $conn->query($sql);

        echo "<p style='color:green;'>Registration successful. <a href='login.php'>Login now</a></p>";

    } catch (mysqli_sql_exception $e) {


        if ($e->getCode() == 1062) {
            echo "<p style='color:red;'>That username is already taken. Please choose another.</p>";
        } else {
            echo "<p style='color:red;'>Database error: " . $e->getMessage() . "</p>";
        }
    }
}
?>


<p>Already a user? <a href="login.php">Login here</a>.</p>