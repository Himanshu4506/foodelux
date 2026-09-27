<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

if (isset($_POST['submit'])) {
    $product_name  = mysqli_real_escape_string($conn, $_POST['product_name']);
    $product_price = floatval($_POST['product_price']);
    $product_desc  = mysqli_real_escape_string($conn, $_POST['product_desc']);
    $product_cat   = mysqli_real_escape_string($conn, $_POST['product_category']);

    $image_path = ''; // final path to save in DB

    // âœ… Check if file is uploaded
    if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] === UPLOAD_ERR_OK) {
        $filename = $_FILES['product_image']['name'];
        $tmpname  = $_FILES['product_image']['tmp_name'];
        $ext      = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        $allowed  = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($ext, $allowed)) {
            $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9\.\-_]/', '', $filename);
            $folder  = 'product_images/' . $newName;

            if (move_uploaded_file($tmpname, $folder)) {
                $image_path = $folder;
            } else {
                echo "<script>alert('âœ– Failed to upload image');</script>";
            }
        } else {
            echo "<script>alert('âœ– Invalid image extension');</script>";
        }
    }

    // âœ… If no file uploaded, use manual path
    if (empty($image_path) && !empty($_POST['manual_image'])) {
        $image_path = mysqli_real_escape_string($conn, $_POST['manual_image']); 
    }

    // âœ… Final insert
if (!empty($image_path)) {
    $sql = "INSERT INTO food_items (name, price, image, category, description) 
            VALUES ('$product_name', '$product_price', '$image_path', '$product_cat', '$product_desc')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo "<script>alert('âœ… Product added successfully'); window.location='products.php';</script>";
    } else {
        echo "<script>alert('âœ– Failed to add product: " . mysqli_error($conn) . "');</script>";
    }
} else {
    echo "<script>alert('âœ– Please upload or enter image path');</script>";
}
}
?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Product â€“ Foodeluxe Admin</title>
  <style>
    body { font-family:'Segoe UI',sans-serif; background:#f7f7f7; padding:40px; }
    .form-box {
      max-width:500px; margin:auto;
      background:#fff; padding:30px;
      border-radius:8px; box-shadow:0 2px 6px rgba(0,0,0,0.1);
    }
    h2 { text-align:center; color:#253A4A; margin-bottom:20px; }
    label { display:block; margin-top:12px; font-weight:bold; }
    input,textarea,select {
      width:100%; padding:8px; margin-top:4px;
      border:1px solid #ccc; border-radius:4px;
    }
    button {
      margin-top:16px; padding:10px 20px;
      background:#28a745; color:#fff; border:none;
      border-radius:4px; cursor:pointer;
    }
    button:hover { background:#218838; }
  </style>
</head>
<body>

<div class="form-box">
  <h2>âž• Add New Product</h2>
  <form method="POST" enctype="multipart/form-data">
    <label>Product Name</label>
    <input type="text" name="product_name" required>

    <label>Price</label>
    <input type="number" name="product_price" step="0.01" required>

    <label>Category</label>
    <input type="text" name="product_category" required>

    <label>Description</label>
    <textarea name="product_desc" required></textarea>

    <!-- <label>Upload Image</label>
    <input type="file" name="product_image" accept="image/*"> -->

    <label>Enter Image Path</label>
    <input type="text" name="manual_image" placeholder="product_images/burger1.png">

    <button type="submit" name="submit">Add Product</button>
  </form>
</div>

</body>
</html>
