<?php
session_start();
include 'db_connect.php';

// echo '<pre>'; print_r($_POST); echo '</pre>';

// Get user delivery details from POST
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Fetch cart items
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
$total = 0;

?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Summary - Foodeluxe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark: #0D1419;
      --slate: #253A4A;
      --gold: #E0A840;
      --beige: #CDC6B6;
      --cream: #F7F4E3;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
    }

    .container {
      max-width: 800px;
      margin: 40px auto;
      background: var(--beige);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    h2 {
      text-align: center;
      color: var(--gold);
      margin-bottom: 30px;
    }

    .user-info {
      background: var(--cream);
      padding: 20px;
      border-radius: 12px;
      margin-bottom: 30px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .user-info p {
      margin: 8px 0;
      font-size: 16px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      padding: 12px;
      text-align: center;
      border-bottom: 1px solid var(--slate);
    }

    th {
      background: var(--dark);
      color: var(--cream);
    }

    .summary {
      font-size: 16px;
      line-height: 1.6;
      background: var(--cream);
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
    }

    .summary hr {
      margin: 12px 0;
      border: none;
      border-top: 1px solid var(--slate);
    }

    .confirm-btn {
      margin-top: 20px;
      background: var(--gold);
      color: var(--dark);
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s ease;
      display: block;
      margin-left: auto;
      margin-right: auto;
    }

    .confirm-btn:hover {
      background: var(--slate);
      color: var(--cream);
    }

    footer {
      background: var(--dark);
      color: var(--cream);
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
  </style>
</head>
<body>

<div class="container">
  <h2>🧾 Order Summary</h2>

  <div class="user-info">
    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($address)) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
  </div>

  <table>
    <tr>
      <th>Item</th>
      <th>Price</th>
      <th>Qty</th>
      <th>Subtotal</th>
    </tr>
    <?php while ($item = $cart_items->fetch_assoc()):
      $subtotal = $item['price'] * $item['quantity'];
      $total += $subtotal;
    ?>
    <tr>
      <td><?= htmlspecialchars($item['name']) ?></td>
      <td>₹<?= number_format($item['price'], 2) ?></td>
      <td><?= $item['quantity'] ?></td>
      <td>₹<?= number_format($subtotal, 2) ?></td>
    </tr>
    <?php endwhile; ?>
  </table>

  <?php
    $tax_rate = 0.06;
    $packing_fee = 20;
    $delivery_fee = ($total > 120) ? 0 : 120;
    $gst = $total * $tax_rate;
    $grand_total = $total + $gst + $packing_fee + $delivery_fee;
  ?>

  <div class="summary">
    <p>Subtotal: ₹<?= number_format($total, 2) ?></p>
    <p>GST (6%): ₹<?= number_format($gst, 2) ?></p>
    <p>Packing Fee: ₹<?= number_format($packing_fee, 2) ?></p>
    <p>Delivery Fee: ₹<?= number_format($delivery_fee, 2) ?> <?= $delivery_fee == 0 ? '(Free)' : '' ?></p>
    <hr>
    <p><strong>Grand Total: ₹<?= number_format($grand_total, 2) ?></strong></p>
  </div>
  
  <form method="POST" action="payment.php">
  <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
  <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
  <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
  <input type="hidden" name="grand_total" value="<?= $grand_total ?>">
  <button type="submit" class="confirm-btn">Proceed to Pay</button>
</form>

</div>

<footer>
  <p>&copy; <?= date("Y") ?> Foodeluxe. Crafted with ❤️ in Rajkot.</p>
</footer>

</body>
</html>
