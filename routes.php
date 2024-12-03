<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/controller/UserController.php';
require_once __DIR__ . '/controller/MerchantController.php';
require_once __DIR__ . '/controller/CartController.php';
require_once __DIR__ . '/middleware/AuthMiddleware.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index

// Guest routes
get('/', function() {
    AuthMiddleware::handleGuestOnly();
    require 'views/auth/login.php';
});

get('/register', function() {
    AuthMiddleware::handleGuestOnly();
    require 'views/auth/register.php';
});

get('/merchant/login', function() {
    AuthMiddleware::handleGuestOnly();
    require 'views/auth/merchant-login.php';
});

get('/merchant/register', function() {
    AuthMiddleware::handleGuestOnly();
    require 'views/auth/merchant-register.php';
});

// Protected user routes
get('/home', function() {
    AuthMiddleware::handleUserAuth();
    require 'views/index.php';
});

get('/logout', function() {
    AuthMiddleware::handleUserAuth();
    require 'views/auth/logout.php';
});

// Protected merchant routes
get('/merchant/dashboard', function() {
    AuthMiddleware::handleMerchantAuth();
    require 'views/merchant-dashboard.php';
});

// Auth routes
post('/login', function () {
    AuthMiddleware::handleGuestOnly();
    $controller = new UserController();
    $message = $controller->handleLogin();
    require_once __DIR__ . '/views/auth/login.php';
});

post('/register', function () {
    AuthMiddleware::handleGuestOnly();
    $controller = new UserController();
    $message = $controller->handleRegister();
    require_once __DIR__ . '/views/auth/register.php'; // You can create a register view for form submission
});

post('/merchant/login', function () {
    AuthMiddleware::handleGuestOnly();
    $controller = new MerchantController();
    $message = $controller->handleLogin();
    require_once __DIR__ . '/views/auth/merchant-login.php';
});

post('/merchant/register', function () {
    AuthMiddleware::handleGuestOnly();
    $controller = new MerchantController();
    $message = $controller->handleRegister();
    require_once __DIR__ . '/views/auth/merchant-register.php';
});

// CartController Routes
get('/cart', function() { 
    AuthMiddleware::handleUserAuth(); 
    require 'views/cart.php';
});

post('/cart/add', function () {
    $controller = new CartController();
    echo json_encode($controller->addToCart());
});

post('/cart/update', function () {
    $controller = new CartController();
    echo json_encode($controller->updateCart());
});

post('/cart/remove', function () {
    $controller = new CartController();
    echo json_encode($controller->removeFromCart());
});

// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');