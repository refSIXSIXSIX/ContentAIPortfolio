<?php
require_once 'db.php';
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if (!$product) {
    echo "Товар не найден";
    exit;
}

$props_sql = "SELECT * FROM product_properties WHERE product_id = $id";
$props_result = $conn->query($props_sql);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['meta_title']; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p><?php echo $product['name']; ?></p>
    </header>
    <hr>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog_db.php">Каталог</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="login.php">Личный кабинет</a></li>
        </ul>
    </nav>
    <hr>
    <main>
        <h2><?php echo $product['name']; ?></h2>
        
        <div class="product-image">
            <a href="<?php echo $product['image']; ?>" target="_blank">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>" width="400">
            </a>
        </div>
        
        <div class="price-box">
            <p><strong>Стоимость:</strong> <?php echo number_format($product['price'], 0, ',', ' '); ?> ₽</p>
            <button class="add-to-cart" onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo addslashes($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo $product['image']; ?>')">🛒 Добавить в корзину</button>
        </div>
        
        <h3>Краткое описание</h3>
        <p><?php echo $product['short_description']; ?></p>
        
        <h3>Характеристики</h3>
        <ul>
            <?php while($prop = $props_result->fetch_assoc()): ?>
                <li><strong><?php echo $prop['property_name']; ?>:</strong> <?php echo $prop['property_value']; ?></li>
            <?php endwhile; ?>
        </ul>
        
        <h3>Подробное описание</h3>
        <p><?php echo nl2br($product['description']); ?></p>
    </main>
    <hr>
    <footer>
        <p>&copy; 2026 Юридическая компания «Гестион». Все права защищены.</p>
        <p style="margin-top:10px; font-size:0.9em;">
            ✉️ <a href="mailto:info@gestrion.ru" style="color:#ccc;">info@gestrion.ru</a> | 
            📞 +7 (495) 123-45-67
        </p>
        <p style="margin-top:15px;">
            <a href="#" onclick="window.open('privacy.txt', '_blank', 'width=700,height=500,resizable=1,toolbar=1'); return false;" style="color:#ccc;">📄 Политика конфиденциальности</a>
            &nbsp;|&nbsp;
            <a href="privacy.txt" download style="color:#ccc;">⬇️ Скачать</a>
        </p>
    </footer>

    <button class="cart-btn" id="cartBtn">🛒<span class="cart-count" id="cartCount">0</span></button>
    <div class="cart-modal" id="cartModal">
        <div class="cart-modal-content">
            <div class="cart-modal-header"><h3>🛒 Моя корзина</h3><span class="cart-close" id="cartClose">&times;</span></div>
            <div class="cart-modal-body" id="cartItems"><div class="cart-empty">Корзина пуста</div></div>
            <div class="cart-modal-footer" id="cartFooter" style="display:none;">
                <div class="cart-total"><span>Итого:</span><span id="cartTotal">0 ₽</span></div>
                <button class="cart-checkout" id="checkoutBtn">Оформить заказ</button>
            </div>
        </div>
    </div>

    <script src="cart.js"></script>
</body>
</html>