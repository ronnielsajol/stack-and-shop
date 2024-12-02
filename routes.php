<?php

require_once __DIR__ . '/router.php';
require_once __DIR__ . '/controller/UserController.php';

// ##################################################
// ##################################################
// ##################################################

// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', 'views/auth/login.php');
get('/home', 'views/index.php');
get('/register', 'views/auth/register.php');
get('/logout', 'views/auth/logout.php');
get('/merchant/login', 'views/auth/merchant-login.php');
get('/merchant/register', 'views/auth/merchant-register.php');


post('/login', function () {
  $controller = new UserController();
  $message = $controller->handleLogin();
  require_once __DIR__ . '/views/auth/login.php';
});
post('/register', function () {
  $controller = new UserController();
  $message = $controller->handleRegister();
  require_once __DIR__ . '/views/auth/register.php'; // You can create a register view for form submission
});


// ##################################################
// ##################################################
// ##################################################
// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404', 'views/404.php');
