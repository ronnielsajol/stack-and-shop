<?php

class AuthMiddleware {
    public static function handleUserAuth() {
        session_start();
        
        // Check if user is not logged in
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['login_message'] = 'Please login to continue.';
            header('Location: /');
            exit();
        }
    }

    public static function handleMerchantAuth() {
        session_start();
        
        // Check if merchant is not logged in or role is not merchant
        if (!isset($_SESSION['merchant_id']) || $_SESSION['role'] !== 'merchant') {
            $_SESSION['login_message'] = 'Please login as a merchant to continue.';
            header('Location: /merchant/login');
            exit();
        }
    }

    public static function handleGuestOnly() {
        session_start();
        
        // Redirect logged-in users away from login/register pages
        if (isset($_SESSION['user_id'])) {
            header('Location: /home');
            exit();
        } else if (isset($_SESSION['merchant_id'])) {
            header('Location: /merchant/dashboard');
            exit();
        }
    }
}