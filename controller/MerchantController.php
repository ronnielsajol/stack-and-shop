<?php

require_once __DIR__ . '/../includes/database.php';

class MerchantController
{

  public function __construct()
  {
    session_start();
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
      $role = 'merchant';

      //validation
      if ($password !== $confirmPassword) {
        $message = 'Passwords do not match!';
      } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");

        $stmt->bind_param('ssss', $username, $email, $hashedPassword, $role);

        if ($stmt->execute()) {
          session_start();
          $_SESSION['register_success'] = "Registration successful! You can now log in.";

          header('Location: /merchant/login');
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

      $password = trim($password);

      $db = new Database();
      $conn = $db->getConnection();

      $stmt = $conn->prepare("SELECT id, username, password, role FROM users WHERE username = ? AND role = 'merchant'");
      $stmt->bind_param('s', $username);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
          $_SESSION['merchant_id'] = $user['id'];
          $_SESSION['merchant_username'] = $user['username'];
          $_SESSION['role'] = $user['role'];

          header('Location: /merchant/dashboard');
        } else {
          $message = 'Invalid username or password';
        }
      } else {
        $message = 'Invalid username or password';
      }
    }

    return $message;
  }
}
