<?php
// Disable error reporting for production
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');
require_once 'database.php';

// For now, we'll use a dummy user ID (you'll want to implement proper authentication)
$user_id = 1;

$db = new Database();
$data = json_decode(file_get_contents('php://input'), true);

$response = ['success' => false, 'message' => ''];

try {
    if (!isset($data['action'])) {
        throw new Exception('No action specified');
    }

    switch($data['action']) {
        case 'add':
            if (!isset($data['product_id']) || !isset($data['quantity'])) {
                throw new Exception('Missing product_id or quantity');
            }
            $response['success'] = $db->addToCart($user_id, $data['product_id'], $data['quantity']);
            $response['message'] = $response['success'] ? 'Item added to cart' : 'Failed to add item to cart';
            break;
            
        case 'update':
            if (!isset($data['product_id']) || !isset($data['quantity'])) {
                throw new Exception('Missing product_id or quantity');
            }
            $response['success'] = $db->updateCartQuantity($user_id, $data['product_id'], $data['quantity']);
            $response['message'] = $response['success'] ? 'Cart updated' : 'Failed to update cart';
            break;
            
        case 'remove':
            if (!isset($data['product_id'])) {
                throw new Exception('Missing product_id');
            }
            $response['success'] = $db->removeFromCart($user_id, $data['product_id']);
            $response['message'] = $response['success'] ? 'Item removed from cart' : 'Failed to remove item from cart';
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);