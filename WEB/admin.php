<?php
require_once 'db.php';

// Добавление услуги
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_service'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $short_desc = $conn->real_escape_string($_POST['short_description']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = (float)$_POST['price'];
    $image = $conn->real_escape_string($_POST['image']);
    
    $sql = "INSERT INTO product (manufacturer_id, name, alias, short_description, description, price, image, available, meta_keywords, meta_description, meta_title) 
            VALUES (1, '$name', LOWER(REPLACE('$name', ' ', '-')), '$short_desc', '$desc', $price, '$image', 1, '', '', '$name')";
    
    if ($conn->query($sql)) {
        $msg = "Услуга добавлена!";
    } else {
        $msg = "Ошибка: " . $conn->error;
    }
}

// Удаление услуги
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $conn->query("DELETE FROM product WHERE id = $id");
    header("Location: admin.php");
}

// Получаем все услуги
$services = $conn->query("SELECT * FROM product ORDER BY id");
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель - Гестион</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-table { width: 100%; border-collapse: collapse; }
        .admin-table th, .admin-table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .admin-form { background: #f8f9fa; padding: 20px; margin-bottom: 30px; border-radius: 10px; }
        .admin-form input, .admin-form textarea { width: 100%; margin-bottom: 10px; padding: 8px; }
        .btn-delete { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <header><h1>Админ-панель Гестион</h1></header>
    <hr>
    <nav><ul><li><a href="index.php">На сайт</a></li><li><a href="catalog_db.php">Каталог</a></li></ul></nav>
    <hr>
    <main>
        <?php if(isset($msg)) echo "<p style='color:green'>$msg</p>"; ?>
        
        <div class="admin-form">
            <h3>➕ Добавить новую услугу</h3>
            <form method="post">
                <input type="text" name="name" placeholder="Название услуги" required>
                <input type="text" name="short_description" placeholder="Краткое описание" required>
                <textarea name="description" rows="5" placeholder="Полное описание"></textarea>
                <input type="number" step="0.01" name="price" placeholder="Цена" required>
                <input type="text" name="image" placeholder="Имя файла картинки (например, biznes.jpg)">
                <input type="submit" name="add_service" value="Добавить услугу">
            </form>
        </div>
        
        <h3>📋 Список услуг</h3>
        <table class="admin-table">
            <tr><th>ID</th><th>Название</th><th>Цена</th><th>Действия</th></tr>
            <?php while($row = $services->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo number_format($row['price'], 0, ',', ' '); ?> ₽</td>
                <td>
                    <a href="product.php?id=<?php echo $row['id']; ?>">👁️ Просмотр</a> |
                    <a href="edit.php?id=<?php echo $row['id']; ?>">✏️ Редактировать</a> |
                    <a href="admin.php?delete=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Удалить?')">🗑️ Удалить</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
    </main>
    <footer><p>&copy; 2026 Гестион</p>
    <p style="margin-top: 15px;">
    <a href="#" onclick="window.open('privacy.txt', '_blank', 'width=700,height=500,resizable=1,toolbar=1'); return false;" style="color: #ccc;">📄 Политика конфиденциальности</a>
    &nbsp;|&nbsp;
    <a href="privacy.txt" download style="color: #ccc;">⬇️ Скачать</a>
</p></footer>
</body>
</html>