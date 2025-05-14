<?php
session_start();
if (!isset($_SESSION['username'])) {
  header("Location: login.php");
  exit();
}
require_once("settings.php");
$conn = mysqli_connect($servername, $username, $password, $dbname);
$query = "SELECT email FROM user WHERE username = '{$_SESSION['username']}'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $new_email = trim($_POST['email']);
    $update_query = "UPDATE user SET email = '$new_email' WHERE username = '{$_SESSION['username']}'";
    $update_result = mysqli_query($conn, $update_query);
    if ($update_result) {
        $_SESSION['email'] = $new_email;
        $user['email'] = $new_email; 
        $message = "Email updated successfully!";
    } else {
        $error = "Update failed: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
</head>
<body>
    <h1>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h1>

    <h2>Your Profile Details</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></p>
    <p><strong>Current Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>

<form method="POST">
    <h3>Update Email</h3>
    <?php if (isset($message)): ?>
        <p style="color:green;"><?php echo $message; ?></p>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <label>New Email:
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </label>
    <button type="submit">Update Email</button>
</form>
</body>
</html>

