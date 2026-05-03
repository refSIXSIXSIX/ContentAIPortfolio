<?php
require_once 'db.php';
session_start();

$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$results = [];

if (!empty($query)) {
    $search = "%{$query}%";
    $stmt = $conn->prepare("SELECT * FROM product WHERE name LIKE ? AND available = 1");
    $stmt->bind_param("s", $search);
    $stmt->execute();
    $results = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Поиск - Гестион</title>
    <link rel="stylesheet" href="style.css">
</head>
<body data-user-id="<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : ''; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Результаты поиска</p>
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
        <h2>🔎 Результаты поиска: "<?php echo htmlspecialchars($query); ?>"</h2>
        
        <?php if (empty($query)): ?>
            <p>Введите поисковый запрос.</p>
        <?php elseif (count($results) === 0): ?>
            <p>😕 Ничего не найдено. Попробуйте другие ключевые слова.</p>
        <?php else: ?>
            <div class="catalog-container">
                <?php foreach ($results as $row): ?>
                    <div class="catalog-item">
                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>" width="250">
                        <h3><?php echo $row['name']; ?></h3>
                        <p><?php echo $row['short_description']; ?></p>
                        <p><strong><?php echo number_format($row['price'], 0, ',', ' '); ?> ₽</strong></p>
                        <p><a href="product.php?id=<?php echo $row['id']; ?>">Подробнее →</a></p>
                        <button class="add-to-cart" onclick="addToCart(<?php echo $row['id']; ?>, '<?php echo addslashes($row['name']); ?>', <?php echo $row['price']; ?>, '<?php echo $row['image']; ?>')">🛒 В корзину</button>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        
        <p style="margin-top: 20px;"><a href="index.php">← Вернуться на главную</a></p>
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

    <!-- Корзина -->
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