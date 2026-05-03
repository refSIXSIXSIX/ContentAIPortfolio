<?php
require_once 'db.php';
session_start();

$msg = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    
    // Проверки
    if ($password !== $confirm) {
        $msg = "❌ Пароли не совпадают!";
    } else {
        // Проверка, существует ли email
        $check = $conn->query("SELECT id FROM users WHERE email = '$email'");
        if ($check->num_rows > 0) {
            $msg = "❌ Пользователь с таким email уже существует!";
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO users (name, email, phone, password, reg_date) 
                    VALUES ('$name', '$email', '$phone', '$hashed', '$date')";
            
            if ($conn->query($sql)) {
                $msg = "✅ Регистрация успешна! Теперь вы можете войти.";
            } else {
                $msg = "❌ Ошибка: " . $conn->error;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация - Гестион</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container { max-width: 500px; margin: 0 auto; }
        .auth-box { background: #f8f9fa; padding: 25px; border-radius: 10px; }
        .auth-box input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #dee2e6; border-radius: 4px; }
        .auth-box input[type="submit"] { background: #0b3b5c; color: white; cursor: pointer; }
        .msg { padding: 10px; margin-bottom: 15px; border-radius: 4px; }
        .msg.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .msg.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <header><h1>Юридическая компания «Гестион»</h1><p>Регистрация</p></header>
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
    <main class="auth-container">
        <h2>📝 Регистрация</h2>
        
        <?php if($msg): ?>
            <div class="msg <?php echo strpos($msg, '✅') !== false ? 'success' : 'error'; ?>">
                <?php echo $msg; ?>
            </div>
        <?php endif; ?>
        
        <div class="auth-box">
            <form method="post">
                <input type="text" name="name" placeholder="Имя" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="tel" name="phone" placeholder="Телефон">
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="password" name="confirm" placeholder="Подтверждение пароля" required>
                <input type="submit" name="register" value="Зарегистрироваться">
            </form>
            <p style="text-align: center; margin-top: 15px;">
                Уже есть аккаунт? <a href="login.php">Войти</a>
            </p>
        </div>
    </main>
    <hr>
    <footer><p>&copy; 2026 Гестион</p>
    <p style="margin-top: 15px;">
    <a href="#" onclick="window.open('privacy.txt', '_blank', 'width=700,height=500,resizable=1,toolbar=1'); return false;" style="color: #ccc;">📄 Политика конфиденциальности</a>
    &nbsp;|&nbsp;
    <a href="privacy.txt" download style="color: #ccc;">⬇️ Скачать</a>
</p></footer>
</body>
</html>