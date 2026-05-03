<?php
require_once 'db.php';
session_start();

$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
$order_by = "";

switch($sort) {
    case 'price_asc': $order_by = "ORDER BY price ASC"; break;
    case 'price_desc': $order_by = "ORDER BY price DESC"; break;
    case 'name_asc': $order_by = "ORDER BY name ASC"; break;
    case 'name_desc': $order_by = "ORDER BY name DESC"; break;
    default: $order_by = "ORDER BY name ASC";
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Каталог - Гестион</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Каталог услуг</p>
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
        <h2>Наши услуги</h2>
        
        <div style="background:#f8f9fa; padding:15px; margin:20px 0; border-radius:8px; text-align:right;">
            <label>📊 Сортировать:</label>
            <select onchange="window.location.href='catalog_db.php?sort='+this.value">
                <option value="name_asc" <?php echo ($sort=='name_asc')?'selected':''; ?>>По названию (А-Я)</option>
                <option value="name_desc" <?php echo ($sort=='name_desc')?'selected':''; ?>>По названию (Я-А)</option>
                <option value="price_asc" <?php echo ($sort=='price_asc')?'selected':''; ?>>По цене (сначала дешёвые)</option>
                <option value="price_desc" <?php echo ($sort=='price_desc')?'selected':''; ?>>По цене (сначала дорогие)</option>
            </select>
        </div>

        <div class="catalog-container">
            <?php
            $sql = "SELECT * FROM product WHERE available = 1 $order_by";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="catalog-item">';
                    echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" width="250">';
                    echo '<h3>' . $row['name'] . '</h3>';
                    echo '<p>' . $row['short_description'] . '</p>';
                    echo '<p><strong>' . number_format($row['price'], 0, ',', ' ') . ' ₽</strong></p>';
                    echo '<p><a href="product.php?id=' . $row['id'] . '">Подробнее →</a></p>';
                    echo '<button class="add-to-cart" onclick="addToCart(' . $row['id'] . ', \'' . addslashes($row['name']) . '\', ' . $row['price'] . ', \'' . $row['image'] . '\')">🛒 В корзину</button>';
                    echo '</div>';
                }
            } else {
                echo "<p>Услуги временно не загружены</p>";
            }
            ?>
        </div>
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