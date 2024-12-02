<?php

require_once __DIR__ . '/../includes/database.php';

class UserController
{

  public function __construct()
  {
    session_start(); // Start the session here
  }
  public function handleRegister()
  {
    $db = new Database();
    $conn = $db->getConnection();

    $message = '';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $username = $_POST['username'];
      $email = $_POST['email'];
      $password = $_POST['password'];
      $confirmPassword = $_POST['confirm_password'];

      // Basic validation
      if ($password !== $confirmPassword) {
        $message = 'Passwords do not match!';
      } else {
        // Hash the password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into the database
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $email, $hashedPassword);

        if ($stmt->execute()) {
          // Store success message in session
          session_start();
          $_SESSION['register_success'] = 'Registration successful! You can now log in.';

          // Redirect to the login page
          header('Location: /');
          exit;
        } else {
          $message = 'Error: ' . $stmt->error;
        }

        $stmt->close();
      }
    }

    return $message;
  }


  public function handleLogin()
  {
    $message = '';

    // Check if registration was successful
    if (isset($_SESSION['register_success'])) {
      $message = $_SESSION['register_success'];
      unset($_SESSION['register_success']);
    }

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

        if (password_verify($password, $user['password'])) {
          // Correct password, set session
          $_SESSION['user_id'] = $user['id'];
          $_SESSION['username'] = $username;

          // Redirect to the home page
          header('Location: /home');
          exit;
        } else {
          $message = 'Invalid password.';
        }
      } else {
        $message = 'User not found.';
      }

      $stmt->close();
    }

    // Store the error message in session for later use
    $_SESSION['login_message'] = $message;

    // Redirect back to login page with the message
    header('Location: /');
    exit;
  }
}
