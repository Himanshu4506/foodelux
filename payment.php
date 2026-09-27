<?php
session_start();
include 'db_connect.php';

// Validate incoming data
$name = $_POST['name'] ?? '';
$address = $_POST['address'] ?? '';
$phone = $_POST['phone'] ?? '';
$grand_total = $_POST['grand_total'] ?? 0;

if (!$name || !$address || !$phone || !$grand_total) {
  echo "<h3 style='text-align:center; color:red;'>Missing payment details. Please go back and fill the form correctly.</h3>";
  exit();
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Payment - Foodeluxe</title>
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
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
      margin: 0;
      padding: 0;
    }

    .container {
      max-width: 600px;
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

    .summary p {
      font-size: 16px;
      margin: 10px 0;
    }

    .payment-methods {
      margin-top: 20px;
    }

    .payment-methods label {
      display: block;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .payment-methods select,
    .payment-methods input {
      width: 100%;
      padding: 10px;
      border-radius: 6px;
      border: 1px solid var(--slate);
      background: var(--cream);
      margin-bottom: 10px;
    }

    .pay-btn {
      margin-top: 30px;
      background: var(--gold);
      color: var(--dark);
      padding: 12px 24px;
      border: none;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      font-size: 16px;
      transition: background 0.3s ease;
    }

    .pay-btn:hover {
      background: var(--slate);
      color: var(--cream);
    }

  </style>
</head>
<body>

<div class="container">
  <h2>💳 Payment</h2>

  <div class="summary">
    <p><strong>Name:</strong> <?= htmlspecialchars($name) ?></p>
    <p><strong>Address:</strong> <?= nl2br(htmlspecialchars($address)) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($phone) ?></p>
    <hr>
    <p><strong>Amount to Pay:</strong> ₹<?= number_format($grand_total, 2) ?></p>
  </div>

  <form method="POST" action="order.php" target="_blank">
    <input type="hidden" name="name" value="<?= htmlspecialchars($name) ?>">
    <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
    <input type="hidden" name="phone" value="<?= htmlspecialchars($phone) ?>">
    <input type="hidden" name="grand_total" value="<?= $grand_total ?>">

    <div class="payment-methods">
      <label for="method">Select Payment Method</label>
      <select name="method" id="method" onchange="toggleUpiField()" required>
        <option value="">-- Choose --</option>
        <option value="COD">Cash on Delivery</option>
      </select>

    </div>

    <button type="submit" class="pay-btn">Confirm & Pay</button>
  </form>
</div>

<script>
document.getElementById('method').addEventListener('change', toggleUpiField);
</script>

</body>
</html>
