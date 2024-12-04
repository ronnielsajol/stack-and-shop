<?php
require_once __DIR__ . '/../model/Database.php';
require_once __DIR__ . '/../model/CartModel.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

$db = new CartModel();
$products = $db->getProducts();

// Initialize the session
SessionHelper::init();

// Get the current user's ID
$user_id = SessionHelper::get('user_id');
include 'shared/header.php';


?>

<main>
    <div class="merchant-login-container">
        <a href="/logout" class="merchant-login-btn">
            Merchant? Login to manage your store
        </a>
    </div>

    <div class="product-grid">
        <?php foreach ($products as $product): ?>
            <div class="item-card">
                <img src="<?php echo htmlspecialchars($product['image']); ?>"
                    alt="<?php echo htmlspecialchars($product['name']); ?>"
                    class="item-image">
                <h2 class="item-name"><?php echo htmlspecialchars($product['name']); ?></h2>
                <p class="item-price">₱<?php echo number_format($product['price'], 2); ?></p>
                <?php echo $product['id']; ?>
                <button class="add-to-cart-btn"
                    data-product-id="<?php echo $product['id']; ?>">
                    Add to Cart
                </button>
            </div>
        <?php endforeach; ?>
    </div>
</main>

<?php include 'shared/footer.php'; ?>