<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

// âœ… Fetch products from food_items
$products = $conn->query("
    SELECT id, name, description, price, image, category, available
    FROM food_items
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products â€“ Foodeluxe Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:#0D1419; --slate:#253A4A; --gold:#E0A840; --cream:#F7F4E3;
      --green:#28a745; --red:#dc3545; --blue:#007bff;
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Segoe UI',sans-serif;background:var(--cream);color:var(--dark);}
    
    .navbar{background:var(--dark);color:var(--cream);padding:15px 20px;display:flex;justify-content:space-between;align-items:center;}
    .navbar h1{font-size:22px;}
    .nav-links{display:flex;gap:20px;}
    .nav-links a{color:var(--cream);text-decoration:none;font-weight:bold;}
    .nav-links a:hover{color:var(--gold);}
    
    .container{max-width:1100px;margin:40px auto;padding:20px;}
    h2{text-align:center;color:var(--gold);margin-bottom:30px;font-size:24px;}
    
    /* table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    th,td{padding:14px;text-align:center;border-bottom:1px solid #ddd;font-size:14px;}
    th{background:var(--dark);color:var(--cream);} */
    
    table{display:none;}
      .product-card{background:#fff;border-left:6px solid var(--gold);padding:20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.05);margin-bottom:20px;}
      .product-card img{max-width:100px;display:block;margin-bottom:10px;}
      .product-card strong{color:var(--slate);}
      .card-actions{margin-top:10px;}

    img{max-width:60px;border-radius:6px;}
    
    .badge{padding:5px 10px;border-radius:12px;font-size:12px;font-weight:bold;}
    .yes{background:var(--green);color:#fff;}
    .no{background:var(--red);color:#fff;}
    
    .btn{padding:6px 12px;border-radius:6px;font-size:13px;font-weight:bold;text-decoration:none;display:inline-block;margin:2px;}
    .btn-edit{background:var(--blue);color:#fff;}
    .btn-delete{background:var(--red);color:#fff;}
    .btn:hover{opacity:0.9;}
    
    @media(max-width:768px){
      table{display:none;}
      .product-card{background:#fff;border-left:6px solid var(--gold);padding:20px;border-radius:12px;box-shadow:0 4px 12px rgba(0,0,0,0.05);margin-bottom:20px;}
      .product-card img{max-width:100px;display:block;margin-bottom:10px;}
      .product-card strong{color:var(--slate);}
      .card-actions{margin-top:10px;}
    }
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <h1>Foodeluxe Admin</h1>
  <div class="nav-links">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="orders.php">Orders</a>
    <a href="products.php">Products</a>
    <a href="admin_logout.php">Logout</a>
  </div>
</div>

<!-- <div>

</div> -->
<div class="container">
  <h2>ðŸ½ï¸ Manage Products</h2>

  <div style="text-align:right; margin-bottom:20px;">
  <a href="add_product.php" class="btn btn-edit" style="background:var(--gold); color:#000;">âž• Add Product</a>
</div>

  <!-- Mobile Cards -->
  <?php mysqli_data_seek($products, 0); while($row=$products->fetch_assoc()): ?>
  <div class="product-card">
    <img src="../assets/images/<?= htmlspecialchars($row['image']) ?>" alt="">
    <div><strong>Name:</strong> <?= htmlspecialchars($row['name']) ?></div>
    <div><strong>Category:</strong> <?= htmlspecialchars($row['category']) ?></div>
    <div><strong>Price:</strong> â‚¹<?= number_format($row['price'],2) ?></div>
    <div><strong>Status:</strong> 
      <span class="badge <?= $row['available'] ? 'yes' : 'no' ?>">
        <?= $row['available'] ? 'Yes' : 'No' ?>
      </span>
    </div>
    <div class="card-actions">
  <a href="edit_product.php?id=<?= $row['id'] ?>" class="btn btn-edit">Edit</a>
  <a href="delete_product.php?id=<?= $row['id'] ?>" class="btn btn-delete" onclick="return confirm('Delete this product?')">Delete</a>
</div>
  </div>
  <?php endwhile; ?>

</div>
</body>
</html>
