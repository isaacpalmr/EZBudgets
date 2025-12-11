<?php require_once "db_connect.php"; session_start(); ?>

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
            $_SESSION["user_id"] = $user["user_id"]; // use your primary key column for users


            header("Location: ../pages/dashboard.php");
            exit;
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "User not found.";
    }
}
?>

<p>Not a user yet? <a href="../pages/index.php">Register now!</a>.</p>