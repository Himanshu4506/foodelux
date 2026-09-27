<?php
session_start();
include 'db_connect.php';

$id = $_POST['id'] ?? 0;
$change = $_POST['change'] ?? 0;

$item = $conn->query("SELECT quantity FROM cart WHERE id = $id")->fetch_assoc();
$newQty = max(1, $item['quantity'] + $change);

$conn->query("UPDATE cart SET quantity = $newQty WHERE id = $id");

echo json_encode(['success' => true, 'newQty' => $newQty]);
?>
