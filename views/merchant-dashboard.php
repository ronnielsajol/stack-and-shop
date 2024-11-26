<?php
session_start();

if (!isset($_SESSION['merchant_id'])) {
    header("Location: auth/merchant-login.php");
    exit();
}

$merchant_username = $_SESSION['merchant_username'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Merchant Dashboard</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <header>
        <h2>Welcome, <?php echo htmlspecialchars($merchant_username); ?>!</h2>
        <nav>
            <a href="auth/logout.php" class="btn btn-logout">Logout</a>
        </nav>
    </header>

    <main>
        <section class="dashboard-content">
            <h3>Merchant Dashboard</h3>
            <p>This is your merchant dashboard. You can add your merchant-specific features here.</p>
            <!-- Add more merchant-specific features here -->
        </section>
    </main>

    <footer>
        <p>Are you a customer? <a href="auth/login.php" class="btn btn-customer-login">Go to Customer Login</a></p>
    </footer>

    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        header {
            background-color: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        main {
            padding: 2rem;
            background-color: #fff;
            margin-top: 2rem;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        footer {
            margin-top: 2rem;
            text-align: center;
        }
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .btn:hover {
            background-color: #45a049;
        }
        .btn-logout {
            background-color: #f44336;
        }
        .btn-logout:hover {
            background-color: #d32f2f;
        }
        .btn-customer-login {
            background-color: #2196F3;
        }
        .btn-customer-login:hover {
            background-color: #1976D2;
        }
    </style>
</body>
</html>