<?php
require_once 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет - Гестион</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .cabinet-info { background:#f8f9fa; padding:25px; border-radius:10px; max-width:600px; margin:0 auto; }
        .cabinet-info p { margin:10px 0; padding:8px; background:white; border-radius:4px; }
        .logout-btn { background:#dc3545; color:white; border:none; padding:10px 20px; border-radius:4px; cursor:pointer; text-decoration:none; display:inline-block; }
        .logout-btn:hover { background:#c82333; }
    </style>
</head>
<body data-user-id="<?php echo $user_id; ?>">
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Личный кабинет</p>
    </header>
    <hr>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog_db.php">Каталог</a></li>
            <li><a href="contacts.php">Контакты</a></li>
            <li><a href="cabinet.php">Личный кабинет</a></li>
        </ul>
    </nav>
    <hr>
    <main>
        <h2>👤 Добро пожаловать, <?php echo htmlspecialchars($user_name); ?>!</h2>
        
        <div class="cabinet-info">
            <h3>Ваши данные</h3>
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Телефон:</strong> <?php echo htmlspecialchars($user['phone']) ?: 'не указан'; ?></p>
            <p><strong>Дата регистрации:</strong> <?php echo date('d.m.Y', strtotime($user['reg_date'])); ?></p>
            
            <a href="logout.php" class="logout-btn">🚪 Выйти</a>
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