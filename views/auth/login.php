<?php

session_start();
require_once '../../includes/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Clean the password to remove any accidental spaces
    $password = trim($password);

    $db = new Database();
    $conn = $db->getConnection();

    // Get user by username
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // Debug: Print out password hash from DB and entered password
        echo "Entered Password: " . $password . "<br>";
        echo "Stored Hash: " . $user['password'] . "<br>";

        if (password_verify($password, $user['password'])) {
            // Correct password, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;

            // Redirect to the home page
            header('Location: ../index.php');
            exit;
        } else {
            $message = 'Invalid password.';
        }
    } else {
        $message = 'User not found.';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Login</button>
    </form>
    <p><?php echo $message; ?></p>
</body>
</html>
