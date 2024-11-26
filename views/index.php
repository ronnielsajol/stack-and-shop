<?php
require_once '../includes/database.php';
$db = new Database();
$products = $db->getProducts();

include 'shared/header.php';

if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if not logged in
    header('Location: auth/login.php');
    exit;
}
?>

<main>
    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($product['img_url']); ?>"
                    alt="<?php echo htmlspecialchars($product['product_name']); ?>"
                    class="item-image">
                <h2 class="item-name"><?php echo htmlspecialchars($product['product_name']); ?></h2>
                <p class="item-price">₱<?php echo number_format($product['price'], 2); ?></p>
                <button class="add-to-cart-btn"
                    data-product-id="<?php echo $product['id']; ?>">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'shared/footer.php'; ?>