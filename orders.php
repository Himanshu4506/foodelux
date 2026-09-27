<?php
session_start();
include 'db_connect.php';

// 1. Ensure user is logged in
$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// 2. Fetch all orders for this user, including status
$stmt = $conn->prepare("
    SELECT 
      id, 
      DATE_FORMAT(created_at, '%d %b %Y | %h:%i %p') AS order_date, 
      grand_total, 
      payment_method,
      status
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
$stmt->close();

// if (in_array($status, ['Pending', 'Delivered', 'Cancelled'])) {
//     $stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
//     $stmt->bind_param("si", $status, $order_id);
//     $stmt->execute();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>My Orders – Foodeluxe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root {
      --dark: #0D1419;
      --cream: #F7F4E3;
      --beige: #F1ECE0;
      --gold: #E0A840;
      --slate: #253A4A;
      --green: #28a745;
      --orange: #f0ad4e;
      --red: #dc3545;
    }
    * { box-sizing: border-box; margin:0; padding:0; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
      padding: 20px;
    }
    .header { text-align: center; margin-bottom: 30px; }
    .header h2 { font-size: 28px; color: var(--gold); }

    .orders-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
      gap: 20px;
    }
    .order-card {
      background: var(--beige);
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      display: flex;
      flex-direction: column;
      padding: 20px;
      transition: transform 0.2s ease;
    }
    .order-card:hover { transform: translateY(-4px); }
    .order-card h3 { font-size: 20px; margin-bottom: 12px; color: var(--slate); }
    .order-details p { font-size: 14px; margin: 6px 0; }

    /* Status badges */
    .status-badge {
      display: inline-block;
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 13px;
      font-weight: bold;
      margin-left: 6px;
      color: #fff;
    }
    .status-pending   { background: var(--orange); }
    .status-delivered { background: var(--green); }
    .status-cancelled { background: var(--red); }

    /* Actions */
    .order-actions { margin-top: auto; text-align: right; }
    .order-actions a {
      display: inline-block;
      padding: 8px 16px;
      background: var(--green);
      color: var(--cream);
      text-decoration: none;
      border-radius: 6px;
      font-size: 14px;
      transition: background 0.2s ease;
    }
    .order-actions a:hover { background: var(--slate); }

    /* Empty */
    .empty { text-align: center; color: var(--slate); padding: 60px 20px; font-size: 16px; }
    .empty a {
      display: inline-block;
      margin-top: 16px;
      padding: 10px 20px;
      background: var(--green);
      color: var(--cream);
      text-decoration: none;
      border-radius: 6px;
      transition: background 0.2s ease;
    }
    .empty a:hover { background: var(--slate); }
  </style>
</head>
<body>

<div class="header">
  <h2>🛍️ My Orders</h2>
</div>

<?php if ($orders->num_rows > 0): ?>
  <div class="orders-container">
    <?php while ($order = $orders->fetch_assoc()): 
        $status = strtolower($order['status'] ?: 'pending');
    ?>
      <div class="order-card">
        <h3>Order #<?= htmlspecialchars($order['id']) ?></h3>
        <div class="order-details">
          <p><strong>Date:</strong> <?= htmlspecialchars($order['order_date']) ?></p>
          <p><strong>Total:</strong> ₹<?= number_format($order['grand_total'], 2) ?></p>
          <p><strong>Payment:</strong> <?= htmlspecialchars(strtoupper($order['payment_method'])) ?></p>
          <p>
            <strong>Status:</strong>
            <span class="status-badge status-<?= $status ?>">
              <?= ucfirst($status) ?>
            </span>
          </p>
        </div>
        <div class="order-actions">
          <a href="bill.php?order_id=<?= urlencode($order['id']) ?>" target="_blank">View Bill</a>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
<?php else: ?>
  <div class="empty">
    You haven’t placed any orders yet.<br>
    <a href="menu.php">Start Ordering</a>
  </div>
<?php endif; ?>

</body>
</html>
