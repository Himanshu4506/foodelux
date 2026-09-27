<?php
session_start();
include 'db_connect.php';

// 1. Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$user_id = intval($_SESSION['user_id']);

// 2. Validate incoming cart item ID
if (!isset($_POST['id'])) {
    header("Location: cart.php");
    exit();
}
$item_id = intval($_POST['id']);

// 3. Delete that item for this user
$stmt = $conn->prepare("DELETE FROM cart WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $item_id, $user_id);
$stmt->execute();
$stmt->close();

// 4. Redirect back to cart
header("Location: cart.php");
exit();
