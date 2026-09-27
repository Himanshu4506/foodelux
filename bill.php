<?php
session_start();
include 'db_connect.php';

// 1. Validate input
$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
$user_id  = isset($_SESSION['user_id'])  ? intval($_SESSION['user_id'])  : 0;
if (!$order_id || !$user_id) {
  echo "<h3 style='text-align:center;color:red;'>Invalid access. No order to display.</h3>";
  exit();
}

// 2. Fetch order header
$stmt = $conn->prepare("
    SELECT 
      id, name, address, phone, payment_method,
      subtotal, gst, packing_fee, delivery_fee, grand_total,
      DATE_FORMAT(created_at, '%d %b %Y | %h:%i %p') AS order_date
    FROM orders
    WHERE id = ? AND user_id = ?
");
$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();
$stmt->close();
if (!$order) {
  echo "<h3 style='text-align:center;color:red;'>Order not found.</h3>";
  exit();
}

// 3. Fetch order items into PHP array
$itemStmt = $conn->prepare("
    SELECT item_name, quantity, price, subtotal
    FROM order_items
    WHERE order_id = ?
");
$itemStmt->bind_param("i", $order_id);
$itemStmt->execute();
$result = $itemStmt->get_result();
$items  = [];
while ($row = $result->fetch_assoc()) {
    // prepare each row as [Item, Qty, Price, Subtotal]
    $items[] = [
        $row['item_name'],
        intval($row['quantity']),
        '₹' . number_format($row['price'], 2),
        '₹' . number_format($row['subtotal'], 2),
    ];
}
$itemStmt->close();

// Convert items array for JS
$js_items = json_encode($items);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Foodeluxe Bill #<?= htmlspecialchars($order_id) ?></title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: 'Segoe UI', sans-serif; background:#F7F4E3; color:#0D1419; padding:20px }
    .bill-box { max-width:700px; margin:auto; background:#CDC6B6; border-radius:8px; overflow:hidden }
    .header { background:#E0A840; padding:16px; text-align:center }
    .header h2 { margin:0; color:#F7F4E3; }
    .header p { margin:4px 0 0; font-size:14px; color:#F7F4E3; }
    .info { padding:16px; font-size:14px }
    .info p { margin:6px 0; line-height:1.4 }
    .btn { display:inline-block; margin:20px auto 0; padding:10px 16px; background:#28a745; color:#fff; border-radius:4px; cursor:pointer; text-decoration:none; text-align:center; }
    .btn:hover { background:#253A4A }
  </style>
</head>
<body>

<div class="bill-box" id="billContent">
  <div class="header">
    <h2>🧾 Foodeluxe Order Bill</h2>
    <p>Order #<?= $order['id'] ?> • <?= $order['order_date'] ?></p>
  </div>
  <div class="info">
    <p><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></p>
    <p><strong>Address:</strong><?= nl2br(htmlspecialchars($order['address'])) ?></p>
    <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
    <p><strong>Payment:</strong> <?= htmlspecialchars(strtoupper($order['payment_method'])) ?></p>
  </div>
</div>

<a class="btn" onclick="downloadPDF()">⬇️ Download PDF of Bill</a>

<!-- jsPDF and AutoTable -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>
<script>
  // Prepare data
  const items = <?= $js_items ?>;
  const header = ['Item', 'Qty', 'Price', 'Subtotal'];

  async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF({ unit: 'mm', format: 'a4' });

    // Title
    doc.setFontSize(18);
    doc.text('Foodeluxe Order Bill', 14, 20);

    // Subtitle
    doc.setFontSize(12);
    doc.text('Order #<?= $order['id'] ?> • <?= $order['order_date'] ?>', 14, 28);

    // Customer info box
    doc.setFontSize(10);
    doc.text(`Name: <?= addslashes($order['name']) ?>`, 14, 36);
    doc.text(`Address: <?= addslashes(str_replace(["\r\n","\n"], [' ', ' '], $order['address'])) ?>`, 14, 42);
    doc.text(`Phone: <?= htmlspecialchars($order['phone']) ?>`, 14, 48);
    doc.text(`Payment: <?= strtoupper($order['payment_method']) ?>`, 14, 54);

    // Table start after y=60
    doc.autoTable({
      head: [header],
      body: items,
      startY: 60,
      styles: { fontSize: 10, cellPadding: 3 },
      headStyles: { fillColor: '#253A4A', textColor: '#F7F4E3' },
      alternateRowStyles: { fillColor: '#F7F4E3' },
      theme: 'striped',
      margin: { left: 14, right: 14 },
      didDrawPage: function (data) {
        // Optional: footer or page number
        const page = doc.getCurrentPageInfo().pageNumber;
        doc.setFontSize(8).text(`Page ${page}`, data.settings.margin.left, doc.internal.pageSize.height - 10);
      }
    });

    // Totals below table
    const finalY = doc.lastAutoTable.finalY + 6;
    doc.setFontSize(11);
    doc.text(`Subtotal: ₹<?= number_format($order['subtotal'],2) ?>`, 14, finalY);
    doc.text(`GST (5%): ₹<?= number_format($order['gst'],2) ?>`, 14, finalY + 6);
    doc.text(`Packing Fee: ₹<?= number_format($order['packing_fee'],2) ?>`, 14, finalY + 12);
    doc.text(`Delivery Fee: ₹<?= number_format($order['delivery_fee'],2) ?>`, 14, finalY + 18);
    doc.setFontSize(12).setFont(undefined, 'bold');
    doc.text(`Grand Total: ₹<?= number_format($order['grand_total'],2) ?>`, 14, finalY + 28);

    // Save PDF
    doc.save(`Foodeluxe_Bill_<?= $order['id'] ?>.pdf`);
  }
</script>

</body>
</html>
