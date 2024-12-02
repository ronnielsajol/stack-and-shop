<?php
require_once 'includes/config.php';
require_once 'includes/database.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user inputs
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    // Query to check for the merchant login in the users table
    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username' AND role = 'merchant'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Fetch the user data from the database
        $row = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $row['password'])) {
            // Start session for merchant
            $_SESSION['merchant_id'] = $row['id'];
            $_SESSION['merchant_username'] = $row['username'];

            // Redirect to the merchant dashboard
            header("location: ../merchant-dashboard.php");
        } else {
            $error = "Invalid username or password";
        }
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Login</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>

<body>
    <h2>Merchant Login</h2>

    <!-- Display error message if login fails -->
    <?php if (isset($error)) {
        echo "<p class='error'>$error</p>";
    } ?>

    <!-- Login form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div>
            <input type="submit" value="Login">
        </div>
    </form>

    <!-- Registration link -->
    <p>Don't have an account? <a href="/merchant/register">Register here</a></p>
</body>

</html>