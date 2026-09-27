<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? 0;
$item_id = $_POST['id'] ?? 0;

if ($user_id && $item_id) {
    $check = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND item_id = $item_id");
    if ($check->num_rows > 0) {
        $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE user_id = $user_id AND item_id = $item_id");
    } else {
        $item = $conn->query("SELECT * FROM food_items WHERE id = $item_id")->fetch_assoc();
        $name = $conn->real_escape_string($item['name']);
        $price = $item['price'];
        $conn->query("INSERT INTO cart (user_id, item_id, name, price, quantity) VALUES ($user_id, $item_id, '$name', $price, 1)");
    }
    echo "success";
} else {
    echo "error";
}
?>
