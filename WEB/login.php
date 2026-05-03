<?php
require_once 'db.php';
session_start();

$msg = "";

// Если уже залогинен, перенаправляем в кабинет
if (isset($_SESSION['user_id'])) {
    header("Location: cabinet.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: cabinet.php");
            exit;
        } else {
            $msg = "❌ Неверный пароль!";
        }
    } else {
        $msg = "❌ Пользователь с таким email не найден!";
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход - Гестион</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .auth-container { max-width: 500px; margin: 0 auto; }
        .auth-box { background: #f8f9fa; padding: 25px; border-radius: 10px; }
        .auth-box input { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #dee2e6; border-radius: 4px; }
        .auth-box input[type="submit"] { background: #0b3b5c; color: white; cursor: pointer; }
        .msg { padding: 10px; margin-bottom: 15px; border-radius: 4px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <header><h1>Юридическая компания «Гестион»</h1><p>Вход в личный кабинет</p></header>
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
        <h2>🔐 Вход</h2>
        
        <?php if($msg): ?>
            <div class="msg"><?php echo $msg; ?></div>
        <?php endif; ?>
        
        <div class="auth-box">
            <form method="post">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Пароль" required>
                <input type="submit" name="login" value="Войти">
            </form>
            <p style="text-align: center; margin-top: 15px;">
                Нет аккаунта? <a href="register.php">Зарегистрироваться</a>
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