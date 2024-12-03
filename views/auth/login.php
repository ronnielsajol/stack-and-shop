<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container fade-in">
        <div class="hero">
            <img src="/assets/images/hero.png" alt="SNS" class="hero-image">
            <h1 class="welcome">Welcome to Stack and Shop</h1>
            <p>Build your imagination, one brick at a time!</p>
        </div>
        <div class="login-form">
            <h2>Login</h2>

            <form id="loginForm" action="/login" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="register">
                <p>Don't have an account? <a href="/register">Register</a></p>
            </div>
            <?php

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
                <div class="error-message"><?= htmlspecialchars($loginMessage) ?></div>
            <?php endif; ?>

            <?php
            // Display the registration success message (if any)
            if (!empty($registerSuccessMessage)): ?>
                <div class="success-message"><?= htmlspecialchars($registerSuccessMessage) ?></div>
            <?php endif; ?>


        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>