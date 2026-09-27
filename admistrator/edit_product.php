<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

$id = $_GET['id'];
$product = $conn->query("SELECT * FROM food_items WHERE id = $id")->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name        = $_POST['name'];
  $description = $_POST['description'];
  $price       = $_POST['price'];
  $category    = $_POST['category'];
  $image       = $_POST['image']; // filename only
  $available   = isset($_POST['available']) ? 1 : 0;

  $stmt = $conn->prepare("UPDATE food_items SET name=?, description=?, price=?, category=?, image=?, available=? WHERE id=?");
  $stmt->bind_param("ssdssii", $name, $description, $price, $category, $image, $available, $id);
  $stmt->execute();
  $stmt->close();

  echo "<script>alert('âœ… Product updated successfully'); window.location.href='products.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Product</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      padding: 40px;
    }
    .form-box {
      max-width: 600px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #253A4A;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input, textarea {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    textarea {
      resize: vertical;
      min-height: 80px;
    }
    .checkbox {
      margin-top: 10px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
    .preview {
      margin-top: 10px;
      text-align: center;
    }
    .preview img {
      max-width: 150px;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>âœï¸ Edit Product</h2>
  <form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

    <label>Description</label>
    <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

    <label>Price (â‚¹)</label>
    <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

    <label>Category</label>
    <input type="text" name="category" value="<?= htmlspecialchars($product['category']) ?>" required>

    <label>Image Filename (inside admin/images)</label>
    <input type="text" name="image" value="<?= htmlspecialchars($product['image']) ?>" required placeholder="e.g. snack item 10.jpeg">

    <div class="checkbox">
      <label><input type="checkbox" name="available" <?= $product['available'] ? 'checked' : '' ?>> Available</label>
    </div>

    <button type="submit">Update Product</button>
  </form>
</div>
</body>
</html>
