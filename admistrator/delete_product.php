<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

// âœ… Ensure admin login (agar admin check use karna hai to uncomment karlo)
// if (!isset($_SESSION['admin_username'])) {
//     header("Location: admin_login.php");
//     exit();
// }

// âœ… Get Product ID
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($product_id <= 0) {
    die("Invalid Product ID");
}

// âœ… Delete product
$stmt = $conn->prepare("DELETE FROM food_items WHERE id = ?");
$stmt->bind_param("i", $product_id);
if ($stmt->execute()) {
    header("Location: products.php?msg=Product Deleted Successfully");
} else {
    header("Location: products.php?error=Failed to Delete Product");
}
$stmt->close();
exit();
?>
