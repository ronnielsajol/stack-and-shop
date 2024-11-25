<?php
$root_path = realpath($_SERVER["DOCUMENT_ROOT"]);
$project_root = dirname(dirname(dirname(__FILE__)));
$relative_path = str_replace($root_path, '', $project_root);
$base_url = rtrim($relative_path, '/');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stack and Shop</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <h1>Welcome to Stack and Shop</h1>
        <a href="<?php echo $base_url; ?>/views/cart.php" class="cart-icon" aria-label="View shopping cart">
            <i class="fas fa-shopping-cart"></i>
            <span class="sr-only">Cart</span>
        </a>
    </header>