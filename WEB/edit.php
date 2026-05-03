<?php
require_once 'db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$msg = "";

// Получаем данные услуги
$sql = "SELECT * FROM product WHERE id = $id";
$result = $conn->query($sql);
$service = $result->fetch_assoc();

if (!$service) {
    header("Location: admin.php");
    exit;
}

// Обработка формы редактирования
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_service'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $short_desc = $conn->real_escape_string($_POST['short_description']);
    $desc = $conn->real_escape_string($_POST['description']);
    $price = (float)$_POST['price'];
    $image = $conn->real_escape_string($_POST['image']);
    
    $update_sql = "UPDATE product SET 
        name = '$name',
        short_description = '$short_desc',
        description = '$desc',
        price = $price,
        image = '$image'
        WHERE id = $id";
    
    if ($conn->query($update_sql)) {
        $msg = "<p style='color:green;'>✅ Услуга обновлена!</p>";
        // Обновляем данные для отображения
        $result = $conn->query("SELECT * FROM product WHERE id = $id");
        $service = $result->fetch_assoc();
    } else {
        $msg = "<p style='color:red;'>❌ Ошибка: " . $conn->error . "</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование - Гестион</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .edit-form {
            max-width: 600px;
            margin: 0 auto;
            background: #f8f9fa;
            padding: 25px;
            border-radius: 10px;
        }
        .edit-form input, .edit-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
        }
        .edit-form input[type="submit"] {
            background-color: #0b3b5c;
            color: white;
            cursor: pointer;
            width: auto;
            padding: 12px 25px;
        }
        .preview-img {
            max-width: 150px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Юридическая компания «Гестион»</h1>
        <p>Редактирование услуги</p>
    </header>
    <hr>
    <nav>
        <ul>
            <li><a href="index.php">Главная</a></li>
            <li><a href="catalog_db.php">Каталог</a></li>
            <li><a href="admin.php">Админ-панель</a></li>
        </ul>
    </nav>
    <hr>
    <main>
        <h2>✏️ Редактирование: <?php echo $service['name']; ?></h2>
        
        <?php echo $msg; ?>
        
        <div class="edit-form">
            <form method="post">
                <label>Название услуги:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($service['name']); ?>" required>
                
                <label>Краткое описание:</label>
                <input type="text" name="short_description" value="<?php echo htmlspecialchars($service['short_description']); ?>" required>
                
                <label>Полное описание:</label>
                <textarea name="description" rows="5" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                
                <label>Цена (руб):</label>
                <input type="number" step="0.01" name="price" value="<?php echo $service['price']; ?>" required>
                
                <label>Имя файла картинки:</label>
                <input type="text" name="image" value="<?php echo htmlspecialchars($service['image']); ?>" required>
                <?php if(file_exists($service['image'])): ?>
                    <img src="<?php echo $service['image']; ?>" class="preview-img" alt="preview">
                <?php endif; ?>
                
                <input type="submit" name="update_service" value="💾 Сохранить изменения">
                <a href="admin.php" style="margin-left: 15px;">← Отмена</a>
            </form>
        </div>
    </main>
    <hr>
    <footer>
        <p>&copy; 2026 Юридическая компания «Гестион». Все права защищены.</p>
    </footer>
</body>
</html>