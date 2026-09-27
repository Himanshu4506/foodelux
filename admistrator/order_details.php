<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

// 1. Order ID le lo
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
if (!$order_id) {
    die("Invalid Order ID");
}

// 2. Fetch order info
$order_sql = $conn->prepare("
    SELECT o.id, o.name, o.phone, o.payment_method, o.status, o.grand_total,
           DATE_FORMAT(o.created_at, '%d %b %Y | %h:%i %p') AS order_date
    FROM orders o
    WHERE o.id = ?
");
$order_sql->bind_param("i", $order_id);
$order_sql->execute();
$order = $order_sql->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found!");
}

// 3. Fetch ordered items
$items_sql = $conn->prepare("
    SELECT item_name, price, quantity, subtotal
    FROM order_items
    WHERE order_id = ?
");
$items_sql->bind_param("i", $order_id);
$items_sql->execute();
$items = $items_sql->get_result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Details â€“ #<?= $order_id ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:#0D1419; --slate:#253A4A; --gold:#E0A840; --cream:#F7F4E3;
      --pending:#fce5b4; --pending-text:#a66f00;
      --delivered:#d4edda; --delivered-text:#155724;
      --cancelled:#f8d7da; --cancelled-text:#721c24;
    }
    *{margin:0;padding:0;box-sizing:border-box;}
    body{font-family:'Segoe UI',sans-serif;background:var(--cream);color:var(--dark);padding:20px;}
    h1{color:var(--gold);margin-bottom:20px;}
    .order-info{background:#fff;padding:20px;border-radius:12px;margin-bottom:30px;box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    .order-info p{margin:6px 0;font-size:15px;}
    .status{padding:6px 12px;border-radius:20px;font-weight:600;font-size:13px;display:inline-block;}
    .pending{background:var(--pending);color:var(--pending-text);}
    .delivered{background:var(--delivered);color:var(--delivered-text);}
    .cancelled{background:var(--cancelled);color:var(--cancelled-text);}
    table{width:100%;border-collapse:collapse;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.05);}
    th,td{padding:14px;text-align:center;border-bottom:1px solid var(--slate);}
    th{background:var(--dark);color:var(--cream);}
    tfoot td{font-weight:bold;background:#f1f1f1;}
    .back-btn{margin-top:20px;display:inline-block;padding:10px 20px;background:var(--gold);color:var(--dark);border-radius:8px;text-decoration:none;font-weight:bold;}
    .back-btn:hover{background:var(--slate);color:#fff;}
  </style>
</head>
<body>

  <h1>ðŸ“¦ Order Details â€“ #<?= $order_id ?></h1>

  <!-- Order Info -->
  <div class="order-info">
    <p><strong>User:</strong> <?= htmlspecialchars($order['name']) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Payment:</strong> <?= strtoupper($order['payment_method']) ?></p>
    <p><strong>Status:</strong> 
      <span class="status <?= strtolower($order['status']) ?>">
        <?= ucfirst($order['status']) ?>
      </span>
    </p>
    <p><strong>Date:</strong> <?= $order['order_date'] ?></p>
  </div>

  <!-- Ordered Items -->
  <table>
    <tr>
      <th>Item</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Subtotal</th>
    </tr>
    <?php while($item = $items->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($item['item_name']) ?></td>
      <td>â‚¹<?= number_format($item['price'],2) ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>â‚¹<?= number_format($item['subtotal'],2) ?></td>
    </tr>
    <?php endwhile; ?>

    <!-- âœ… Grand Total Row -->
    <tfoot>
      <tr>
        <td colspan="3" style="text-align:right;"><strong>Grand Total:</strong></td>
        <td><strong>â‚¹<?= number_format($order['grand_total'],2) ?></strong></td>
      </tr>
    </tfoot>
  </table>

  <a href="orders.php" class="back-btn">â¬… Back to Orders</a>

</body>
</html>
