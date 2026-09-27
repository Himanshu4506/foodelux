<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

// âœ… Update status if admin submits
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $_POST['status'];

    if (in_array($status, ['Pending', 'Delivered', 'Cancelled'])) {
        $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $order_id);
        $stmt->execute();
    }
}

// âœ… Fetch orders
$orders = $conn->query("
  SELECT 
    orders.id,
    orders.name,
    orders.phone,
    orders.payment_method,
    orders.status,
    orders.grand_total,
    orders.address,
    DATE_FORMAT(orders.created_at, '%d %b %Y | %h:%i %p') AS order_date
  FROM orders
  ORDER BY orders.created_at DESC
");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Orders â€“ Foodeluxe Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:#0D1419; --slate:#253A4A; --gold:#E0A840; --cream:#F7F4E3;
      --pending:#fce5b4; --pending-text:#a66f00;
      --delivered:#d4edda; --delivered-text:#155724;
      --cancelled:#f8d7da; --cancelled-text:#721c24;
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Segoe UI',sans-serif;background:var(--cream);color:var(--dark);}
    
    /* Navbar */
    .navbar{background:var(--dark);color:var(--cream);padding:15px 20px;display:flex;justify-content:space-between;align-items:center;}
    .navbar h1{font-size:22px;}
    .nav-links{display:flex;gap:20px;}
    .nav-links a{color:var(--cream);text-decoration:none;font-weight:bold;}
    .nav-links a:hover{color:var(--gold);}
    .hamburger{display:none;}

    /* Container */
    .container{max-width:1000px;margin:40px auto;padding:20px;}
    h2{text-align:center;color:var(--gold);margin-bottom:30px;font-size:24px;}

    /* Table */
    table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    th,td{padding:14px;text-align:center;border-bottom:1px solid var(--slate);}
    th{background:var(--dark);color:var(--cream);font-size:15px;}
    td{font-size:14px;}

    .status{padding:6px 12px;border-radius:20px;font-weight:600;font-size:13px;display:inline-block;}
    .pending{background:var(--pending);color:var(--pending-text);}
    .delivered{background:var(--delivered);color:var(--delivered-text);}
    .cancelled{background:var(--cancelled);color:var(--cancelled-text);}

    .btn{background:var(--gold);color:var(--dark);padding:6px 12px;border-radius:6px;font-weight:bold;text-decoration:none;transition:.3s;}
    .btn:hover{background:var(--slate);color:#fff;}

    .status-form select{padding:6px 10px;border-radius:6px;}
    .status-form button{margin-left:6px;}
  </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <h1>Foodeluxe Admin</h1>
  <div class="nav-links" id="navLinks">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="orders.php">Orders</a>
    <a href="products.php">Products</a>
    <a href="categories.php">Categories</a>
    <a href="logout.php">Logout</a>
  </div>
</div>

<div class="container">
  <h2>ðŸ“¦ All Orders</h2>
  <table>
    <tr>
      <th>ID</th><th>User</th><th>Phone</th><th>Payment</th>
      <th>Status</th><th>Total</th><th>Date</th><th>Action</th>
    </tr>
    <?php while($row=$orders->fetch_assoc()): ?>
    <tr>
      <td>#<?= $row['id'] ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= strtoupper($row['payment_method']) ?></td>
     <td>
 <?php if (strtolower($row['status']) === "pending"): ?>
    <!-- Agar status Pending hai to admin change kar sakta hai -->
    <form method="POST" class="status-form">
      <input type="hidden" name="order_id" value="<?= $row['id'] ?>">
      <select name="status">
        <option value="Pending" <?= strtolower($row['status'])=="pending"?"selected":"" ?>>Pending</option>
        <option value="Delivered" <?= strtolower($row['status'])=="delivered"?"selected":"" ?>>Delivered</option>
        <option value="Cancelled" <?= strtolower($row['status'])=="cancelled"?"selected":"" ?>>Cancelled</option>
      </select>
      <button type="submit" name="update_status">âœ”</button>
    </form>
<?php else: ?>
    <!-- Agar Delivered ya Cancelled hai to sirf badge dikhega -->
    <span class="status <?= strtolower($row['status']) ?>">
      <?= ucfirst($row['status']) ?>
    </span>
<?php endif; ?>
</td>


      <td>â‚¹<?= number_format($row['grand_total'],2) ?></td>
      <td><?= $row['order_date'] ?></td>
      <td><a href="order_details.php?order_id=<?= $row['id'] ?>" class="btn">View</a></td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>

</body>
</html>
