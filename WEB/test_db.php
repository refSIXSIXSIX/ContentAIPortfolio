<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gestion_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("❌ Ошибка подключения: " . $conn->connect_error);
} else {
    echo "✅ Подключение к базе данных успешно!";
}

$conn->close();
?>