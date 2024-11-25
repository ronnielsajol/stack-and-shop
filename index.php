<?php 
require_once 'includes/database.php';
$db = new Database();
$products = $db->getProducts();

include 'views/shared/header.php'; 
?>

<main>
    <div class="product-grid">
        <?php foreach($products as $product): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                     class="item-image">
                <h2 class="item-name"><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="item-price">$<?php echo number_format($product['price'], 2); ?></p>
                <button class="add-to-cart-btn" 
                        data-product-id="<?php echo $product['id']; ?>">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'views/shared/footer.php'; ?>