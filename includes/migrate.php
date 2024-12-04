<?php
// Include the database configuration
require_once './model/Config.php';

// SQL statements to create tables
$queries = [
  // Users table
  "CREATE TABLE IF NOT EXISTS users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        role ENUM('merchant', 'user') DEFAULT 'user', -- Role to differentiate users
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )",

  // Products table
  "CREATE TABLE IF NOT EXISTS products (
        id INT AUTO_INCREMENT PRIMARY KEY,
        merchant_id INT NOT NULL, -- Links the product to a merchant
        image TEXT NOT NULL, -- Changed from img_url for consistency
        name VARCHAR(255) NOT NULL, -- Changed from product_name for consistency
        price DECIMAL(10, 2) NOT NULL,
        quantity INT NOT NULL,
        description TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (merchant_id) REFERENCES users(id) ON DELETE CASCADE
    )",

  // Cart table
  "CREATE TABLE IF NOT EXISTS cart (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )",

  // Orders table
  "CREATE TABLE IF NOT EXISTS orders (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        total_amount DECIMAL(10, 2) NOT NULL,
        status ENUM('pending', 'completed', 'cancelled') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
    )",

  // Order items table
  "CREATE TABLE IF NOT EXISTS order_items (
        id INT AUTO_INCREMENT PRIMARY KEY,
        order_id INT NOT NULL,
        product_id INT NOT NULL,
        quantity INT NOT NULL,
        price DECIMAL(10, 2) NOT NULL, -- Price at the time of purchase
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
        FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
    )"
];

// Execute each query
foreach ($queries as $query) {
  if ($conn->query($query) === TRUE) {
    echo "Table created successfully: " . substr($query, 13, strpos($query, '(') - 13) . "<br>";
  } else {
    echo "Error creating table: " . $conn->error . "<br>";
  }
}
