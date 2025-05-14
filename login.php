<?php
session_start();
require_once("settings.php");

$conn = mysqli_connect($servername, $username, $password, $dbname);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['username']) && isset($_POST['password'])) {
    // Get user input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Simple query to check credentials 
    $query = "SELECT * FROM user WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        $_SESSION['username'] = $user['username'];
        header("Location: profile.php");
        exit();
    } else {
        echo "❌ Incorrect username or password.";
    }
} else {
    ?>
    <form method="POST" action="login.php">
        Username: <input type="text" name="username" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php
}
?>