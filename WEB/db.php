<?php
// db.php - подключение к базе данных
$servername = "localhost";
$username = "root";      // по умолчанию в XAMPP
$password = "";          // по умолчанию пустой
$dbname = "gestion_db";

// Создаём подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Устанавливаем кодировку
$conn->set_charset("utf8");
?>