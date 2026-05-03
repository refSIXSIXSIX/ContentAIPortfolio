<?php
require_once 'db.php';
session_start();

header('Content-Type: application/json');

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

$input = json_decode(file_get_contents('php://input'), true);
$action = isset($input['action']) ? $input['action'] : (isset($_GET['action']) ? $_GET['action'] : '');

if ($action == 'sync' || $action == 'save') {
    if ($user_id == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Пользователь не авторизован']);
        exit;
    }
    
    $cart = isset($input['cart']) ? $input['cart'] : [];
    
    $conn->query("DELETE FROM cart WHERE user_id = $user_id");
    
    foreach ($cart as $item) {
        $product_id = (int)$item['id'];
        $quantity = (int)$item['quantity'];
        $added_date = date('Y-m-d H:i:s');
        
        $conn->query("INSERT INTO cart (user_id, product_id, quantity, added_date) 
                      VALUES ($user_id, $product_id, $quantity, '$added_date')");
    }
    
    echo json_encode(['status' => 'ok', 'message' => 'Корзина сохранена']);
    exit;
    
} elseif ($action == 'load') {
    $cart = [];
    
    if ($user_id > 0) {
        $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
        
        while ($row = $result->fetch_assoc()) {
            $prod = $conn->query("SELECT name, price, image FROM product WHERE id = " . $row['product_id']);
            if ($prod && $prod->num_rows > 0) {
                $product = $prod->fetch_assoc();
                $cart[] = [
                    'id' => $row['product_id'],
                    'name' => $product['name'],
                    'price' => (float)$product['price'],
                    'image' => $product['image'],
                    'quantity' => (int)$row['quantity']
                ];
            }
        }
    }
    
    echo json_encode(['status' => 'ok', 'cart' => $cart]);
    exit;
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Неизвестное действие: ' . $action]);
    exit;
}
?>