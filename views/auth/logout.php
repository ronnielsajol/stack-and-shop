<?php
// File: views/auth/logout.php

require_once __DIR__ . '/../../helpers/SessionHelper.php';

// Initialize the session if it hasn't been started
SessionHelper::init();

// Determine the redirect URL based on the user's role
$redirectUrl = '/';
if (SessionHelper::get('role') === 'merchant') {
    $redirectUrl = '/merchant/login';
} elseif (SessionHelper::get('role') === 'user') {
    $redirectUrl = '/login';
}

// Clear all session data
SessionHelper::destroy();

// Ensure that the output buffering is turned on
if (ob_get_level() == 0) ob_start();

// Unset cookies by setting them to expire in the past
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Redirect to the appropriate page
header("Location: $redirectUrl");

// Ensure that the script stops executing after the redirect
exit();