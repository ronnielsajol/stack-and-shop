<?php

require_once __DIR__ . '/Database.php';  // Use __DIR__ for reliable path resolution

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    

    // Get all products
    public function getProducts() {
        $sql = "SELECT * FROM products";
        $result = $this->conn->query($sql);
        $result = $this->conn->query($sql);
        $products = [];
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $products[] = $row;
            }
        }
        
        return $products;
    }

    // Get cart items for a user
    public function getCartItems($user_id) {
        $sql = "SELECT c.*, p.name, p.price, p.image 
                FROM cart c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.user_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return [];
        }
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $items = [];
        
        while($row = $result->fetch_assoc()) {
            $items[] = $row;
        }
        
        return $items;
    }

    // Add item to cart
    public function addToCart($user_id, $product_id, $quantity) {
        $sql = "INSERT INTO cart (user_id, product_id, quantity) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE quantity = quantity + ?";
        
        try {
            $stmt = $this->conn->prepare($sql);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }
            $stmt->bind_param("iiii", $user_id, $product_id, $quantity, $quantity);
            $result = $stmt->execute();
            if (!$result) {
                throw new Exception("Failed to execute statement: " . $stmt->error);
            }
            return $result;
        } catch (Exception $e) {
            error_log('CartModel error: ' . $e->getMessage());
            throw $e; // Re-throw the exception to be caught in the controller
        }
    }

    // Update cart quantity
    public function updateCartQuantity($user_id, $product_id, $quantity) {
        $sql = "UPDATE cart SET quantity = ? 
                WHERE user_id = ? AND product_id = ?";
                
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("iii", $quantity, $user_id, $product_id);
        return $stmt->execute();
    }

    // Remove item from cart
    public function removeFromCart($user_id, $product_id) {
        $sql = "DELETE FROM cart WHERE user_id = ? AND product_id = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("ii", $user_id, $product_id);
        return $stmt->execute();
    }
}
