<?php

class SessionHelper {
    public static function init() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function set($key, $value) {
        self::init();
        $_SESSION[$key] = $value;
    }

    public static function get($key) {
        self::init();
        return $_SESSION[$key] ?? null;
    }

    public static function destroy() {
        self::init();
        session_destroy();
        session_unset();
    }

    public static function isLoggedIn() {
        self::init();
        return isset($_SESSION['user_id']) || isset($_SESSION['merchant_id']);
    }

    public static function isMerchant() {
        self::init();
        return isset($_SESSION['role']) && $_SESSION['role'] === 'merchant';
    }
}