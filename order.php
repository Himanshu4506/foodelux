<?php
session_start();
include 'db_connect.php';

// 1. Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// 2. Get delivery details from POST
$name      = $_POST['name']         ?? '';
$address   = $_POST['address']      ?? '';
$phone     = $_POST['phone']        ?? '';
$method    = $_POST['method']       ?? 'COD';

// 3. Fetch cart items & calculate totals
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
$total      = 0;
$items      = [];

while ($row = $cart_items->fetch_assoc()) {
    $subtotal = $row['price'] * $row['quantity'];
    $total   += $subtotal;
    $items[]  = $row;
}

// 4. Compute fees & grand total
$tax_rate     = 0.06;
$packing_fee  = 20;
$delivery_fee = ($total > 120) ? 0 : 120;
$gst          = $total * $tax_rate;
$grand_total  = $total + $gst + $packing_fee + $delivery_fee;

// 5. Insert into orders
$stmt = $conn->prepare("
    INSERT INTO orders 
      (user_id, name, address, phone, subtotal, gst, delivery_fee, packing_fee, grand_total, payment_method)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
");
$stmt->bind_param(
    "isssddddds",
    $user_id, $name, $address, $phone,
    $total, $gst, $delivery_fee, $packing_fee, $grand_total, $method
);
$stmt->execute();
$order_id = $conn->insert_id;
$stmt->close();

// 6. Insert each item into order_items
foreach ($items as $item) {
    $item_subtotal = $item['price'] * $item['quantity'];
    $stmt = $conn->prepare("
        INSERT INTO order_items 
          (order_id, item_name, price, quantity, subtotal)
        VALUES (?, ?, ?, ?, ?)
    ");
    $stmt->bind_param(
        "isddd",
        $order_id,
        $item['name'],
        $item['price'],
        $item['quantity'],
        $item_subtotal
    );
    $stmt->execute();
    $stmt->close();
}

// 7. Clear the cart
$conn->query("DELETE FROM cart WHERE user_id = $user_id");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Order Confirmation - Foodeluxe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark: #0D1419;
      --cream: #F7F4E3;
      --beige: #CDC6B6;
      --gold: #E0A840;
      --green: #28a745;
      --slate: #253A4A;
    }
    * { box-sizing: border-box; margin:0; padding:0; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }
    .box {
      background: var(--beige);
      padding: 30px;
      border-radius: 12px;
      text-align: center;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
      max-width: 360px;
      width: 100%;
    }
    .box h2 {
      color: var(--green);
      margin-bottom: 24px;
    }
    .box p {
      font-size: 16px;
      margin: 8px 0;
    }
    .btn {
      display: block;
      width: 100%;
      text-decoration: none;
      padding: 12px;
      margin-top: 16px;
      border-radius: 8px;
      font-weight: bold;
      color: var(--dark);
      background: var(--gold);
      transition: background 0.3s ease, color 0.3s ease;
    }
    .btn:hover {
      background: var(--slate);
      color: var(--cream);
    }
    .btn-home {
      background: var(--slate);
      color: var(--cream);
    }
    .btn-home:hover {
      background: var(--gold);
      color: var(--dark);
    }
  </style>
</head>
<body>
  <div class="box">
    <h2>✅ Order Placed Successfully!</h2>
    <p><strong>Order ID:</strong> #<?= htmlspecialchars($order_id) ?></p>
    <p><strong>Grand Total:</strong> ₹<?= number_format($grand_total, 2) ?></p>
    <p><strong>Payment Method:</strong> <?= htmlspecialchars($method) ?></p>

    <!-- View/Download Bill -->
    <a 
      href="bill.php?order_id=<?= urlencode($order_id) ?>" 
      target="_blank" 
      class="btn"
    >
      🧾 View & Download Bill
    </a>

    <!-- Back to Home -->
    <a 
      href="home.php" 
      class="btn btn-home"
    >
      ⬅️ Back to Home
    </a>
  </div>
</body>
</html>
