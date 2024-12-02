<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register an account</title>
    <link rel="stylesheet" href="../../css/register.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Spice&family=Ubuntu:wght@300;400;700&display=swap" rel="stylesheet">

</head>

<body>
    <div class="container fade-in">
        <div class="hero">
            <img src="../../assets/images/hero.png" alt="SNS" class="hero-image">
            <h1 class="welcome">Welcome to Stack and Shop</h1>
            <p>Build your imagination, one brick at a time!</p>
        </div>
        <div class="login-form">
            <h2>Register</h2>
            <form method="POST" action="/register">
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
                <p>Already have an account? <a href="/">Login</a></p>
            </div>
            <p class="error-message" id="errorMessage"></p>
        </div>

    </div>
    <script src="script.js"></script>
</body>

</html>