<?php
session_start(); // Start the session to access $_SESSION

$redirectUrl = '/';
if (isset($_SESSION['role'])) {
  if ($_SESSION['role'] === 'merchant') {
    $redirectUrl = '/merchant/login';
  } elseif ($_SESSION['role'] === 'user') {
    $redirectUrl = '/login';
  }
}
session_unset();

// Destroy the session
session_destroy();

// Redirect to the login page or any other page
header("Location: $redirectUrl");
exit;
