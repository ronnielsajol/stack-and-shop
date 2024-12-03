<?php
require_once 'model/Config.php';
require_once 'model/Database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate form input
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'merchant')";

    if ($conn->query($sql) === TRUE) {
        $success = "Registration successful. You can now login as a merchant.";
    } else {
        $error = "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an account</title>
    <link rel="stylesheet" href="../../css/merchant_register.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container fade-in">
        <div class="login-form">
            <h2>Register</h2>
            <form method="POST" action="/merchant/register">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required><br>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required><br>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required><br>

                <label for="confirm_password">Confirm Password:</label>
                <input type="password" id="confirm_password" name="confirm_password" required><br>

                <button type="submit">Register</button>
            </form>
            <div class="register">
                <p>Already have an account? <a href="/merchant/login">Login</a></p>
            </div>

        </div>
        <div class="hero">
            <img src="../../assets/images/hero2.png" alt="SNS" class="hero-image">
            <h1 class="welcome">Welcome to Stack and Shop Merchant</h1>
            <p>Sell your bricks, one sale at a time!</p>
        </div>
        <?php
        session_start();

        // Check if there is a login message in session
        if (isset($_SESSION['login_message'])) {
            $loginMessage = $_SESSION['login_message'];
            unset($_SESSION['login_message']); // Clear the message after displaying it
        }

        // Check if there is a registration success message in session
        if (isset($_SESSION['register_success'])) {
            $registerSuccessMessage = $_SESSION['register_success'];
            unset($_SESSION['register_success']); // Clear the message after displaying it
        }

        // Display the login error message (if any)
        if (!empty($loginMessage)): ?>
            <div class="error-message"><?= htmlspecialchars($loginMessage) ?>
            </div>
        <?php endif; ?>

        <?php
        // Display the registration success message (if any)
        if (!empty($registerSuccessMessage)): ?>
            <div class="success-message"><?= htmlspecialchars($registerSuccessMessage) ?></div>
        <?php endif; ?>


    </div>
    <div class="hero">
        <img src="../../assets/images/hero2.png" alt="SNS" class="hero-image">
        <h1 class="welcome">Welcome to Stack and Shop Merchant </h1>
        <p>Build your imagination, one brick at a time!</p>
    </div>
    </div>
</body>

</html>