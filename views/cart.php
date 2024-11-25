<?php
require_once '../includes/database.php';
$db = new Database();

// For now, we'll use a dummy user ID (you'll want to implement proper authentication)
$user_id = 1;
$cart_items = $db->getCartItems($user_id);

include 'shared/header.php';
?>

<main class="cart-page">
    <h2>Your Shopping Cart</h2>
    <div class="cart-items">
        <?php if (empty($cart_items)): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item" data-product-id="<?php echo $item['product_id']; ?>">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                         alt="<?php echo htmlspecialchars($item['name']); ?>" 
                         class="item-image">
                    <div class="item-details">
                        <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                        <p class="item-price">$<?php echo number_format($item['price'], 2); ?></p>
                        <div class="item-quantity">
                            <label for="quantity-<?php echo $item['product_id']; ?>">Quantity:</label>
                            <input type="number" 
                                   id="quantity-<?php echo $item['product_id']; ?>" 
                                   name="quantity" 
                                   value="<?php echo $item['quantity']; ?>" 
                                   min="1" 
                                   max="10"
                                   class="quantity-input">
                        </div>
                    </div>
                    <button class="remove-item" 
                            data-product-id="<?php echo $item['product_id']; ?>">
                        Remove
                    </button>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-summary">
                <p>Total: <span class="cart-total">$<?php 
                    echo number_format(array_sum(array_map(function($item) {
                        return $item['price'] * $item['quantity'];
                    }, $cart_items)), 2);
                ?></span></p>
                <button class="checkout-btn">Proceed to Checkout</button>
            </div>
        <?php endif; ?>
    </div>
</main>

<?php include 'shared/footer.php'; ?>