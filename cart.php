<?php
session_start();
include 'db_connect.php';

$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
    header("Location: login.php");
    exit();
}

// Fetch cart items
$cart_items = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
$has_items  = $cart_items->num_rows > 0;
$total      = 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>My Cart – Foodeluxe</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    :root {
      --dark:    #0D1419;
      --slate:   #253A4A;
      --gold:    #E0A840;
      --beige:   #CDC6B6;
      --cream:   #F7F4E3;
      --success: #28a745;
    }
    * { margin:0; padding:0; box-sizing:border-box; }
    body, html {
      font-family:'Segoe UI',sans-serif;
      background:var(--cream);
      color:var(--dark);
      height:100%;
    }
    .page-wrapper {
      display:flex; flex-direction:column;
      min-height:100vh;
    }
    /* ===== NAVBAR ===== */
    .navbar {
      position:fixed; top:0; left:0;
      width:100%; height:60px;
      background:var(--dark); color:var(--cream);
      display:flex; align-items:center;
      justify-content:space-between;
      padding:0 20px; z-index:999;
      transition:top .3s ease;
    }
    .navbar.hidden { top:-70px; }
    .navbar h1 { font-size:22px; }
    .nav-links { display:flex; gap:20px; }
    .nav-links a {
      color:var(--cream);
      text-decoration:none;
      transition:color .2s;
    }
    .nav-links a:hover { color:var(--gold); }
    .hamburger {
      display:none; flex-direction:column; cursor:pointer;
    }
    .hamburger span {
      width:25px; height:3px; background:var(--cream);
      margin:3px 0; border-radius:2px;
    }
    @media (max-width:768px) {
      .hamburger { display:flex; }
      .nav-links {
        position:absolute; top:60px; left:-100%;
        width:100%; background:var(--dark);
        flex-direction:column; text-align:center;
        transition:left .3s;
      }
      .nav-links.active { left:0; }
      .nav-links a {
        padding:12px 0;
        border-bottom:1px solid rgba(255,255,255,0.1);
      }
    }

    main {
      flex:1; padding-top:80px; /* leave space for navbar */
    }
    /* ===== DELIVERY DETAILS ===== */
    .user-details {
      background:var(--beige);
      max-width:800px; margin:20px auto;
      padding:20px; border-radius:12px;
      box-shadow:0 4px 12px rgba(0,0,0,0.08);
    }
    .user-details h2 {
      margin-bottom:12px; color:var(--gold);
      text-align:center;
    }
    .user-details label {
      display:block; margin-top:12px; font-weight:bold;
    }
    .user-details input,
    .user-details textarea {
      width:100%; margin-top:6px; padding:10px;
      border:1px solid var(--slate); border-radius:6px;
      background:var(--cream);
    }

    /* ===== CART SECTION ===== */
    .cart-container {
      max-width:800px; margin:20px auto;
      background:var(--beige); padding:30px;
      border-radius:12px;
      box-shadow:0 6px 16px rgba(0,0,0,0.1);
    }
    .cart-container h2 {
      text-align:center; color:var(--gold);
      margin-bottom:20px;
    }
    table {
      width:100%; border-collapse:collapse;
    }
    th, td {
      padding:12px; text-align:center;
      border-bottom:1px solid var(--slate);
    }
    th { background:var(--dark); color:var(--cream); }
    .qty-control {
      display:flex; justify-content:center; gap:8px;
    }
    .qty-control button {
      background:var(--gold); border:none; padding:4px 8px;
      border-radius:4px; cursor:pointer;
      transition:background .2s;
    }
    .qty-control button:hover {
      background:var(--slate); color:var(--cream);
    }
    .remove-btn {
      background:#dc3545; border:none; padding:6px 12px;
      color:#fff; border-radius:6px; cursor:pointer;
      transition:background .2s;
    }
    .remove-btn:hover { background:#c82333; }

    /* ===== ORDER SUMMARY ===== */
    .charges {
      background:var(--cream); margin-top:20px;
      padding:16px; border-radius:8px;
      text-align:center; box-shadow:0 4px 12px rgba(0,0,0,0.08);
    }
    .charges p { margin:6px 0; }
    .charges hr {
      margin:12px 0; border:none;
      border-top:1px solid var(--slate);
    }

    /* ===== CHECKOUT BUTTON ===== */
    .checkout-btn {
      display:block; width:220px; margin:20px auto 40px;
      padding:12px 0; background:var(--gold);
      color:var(--dark); font-weight:bold;
      text-align:center; border-radius:8px;
      cursor:pointer; transition:background .3s;
      text-decoration:none;
    }
    .checkout-btn:hover {
      background:var(--slate); color:var(--cream);
    }

    /* ===== EMPTY CART ===== */
    .empty-cart {
      text-align:center; margin:80px auto; max-width:600px;
    }
    .empty-cart h2 { margin-bottom:12px; color:var(--gold); }
    .empty-cart a {
      display:inline-block; margin-top:12px;
      background:var(--gold); color:var(--dark);
      padding:10px 20px; border-radius:8px;
      text-decoration:none; transition:background .3s;
    }
    .empty-cart a:hover {
      background:var(--slate); color:var(--cream);
    }

    /* ===== FOOTER ===== */
    footer {
      background:var(--dark); color:var(--cream);
      text-align:center; padding:20px; margin-top:auto;
    }
  </style>
</head>
<body>
  <div class="page-wrapper">
    <!-- NAVBAR -->
    <header class="navbar" id="navbar">
      <h1>Foodeluxe</h1>
      <div class="hamburger" onclick="toggleMenu()">
        <span></span><span></span><span></span>
      </div>
      <nav class="nav-links" id="navLinks">
        <a href="home.php">Home</a>
        <a href="menu.php">Menu</a>
        <a href="orders.php">Orders</a>
        <a href="logout.php">Logout</a>
      </nav>
    </header>

    <main>
      <?php if ($has_items): ?>
        <!-- DELIVERY FORM -->
        <section class="user-details">
          <h2>👤 Delivery Details</h2>
          <form id="deliveryForm" method="POST" action="view_cart.php">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>

            <label for="address">Address</label>
            <textarea id="address" name="address" rows="3" required></textarea>

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" required>
          </form>
        </section>

        <!-- CART ITEMS -->
        <section class="cart-container">
          <h2>🛒 My Cart</h2>
          <table>
            <tr>
              <th>Item</th>
              <th>Price</th>
              <th>Qty</th>
              <th>Subtotal</th>
              <th>Action</th>
            </tr>
            <?php while ($item = $cart_items->fetch_assoc()):
              $subtotal = $item['price'] * $item['quantity'];
              $total += $subtotal;
            ?>
            <tr>
              <td><?= htmlspecialchars($item['name']) ?></td>
              <td>₹<?= number_format($item['price'],2) ?></td>
              <td>
                <div class="qty-control">
                  <button type="button" onclick="updateQty(<?= $item['id'] ?>,-1)">−</button>
                  <span id="qty-<?= $item['id'] ?>"><?= $item['quantity'] ?></span>
                  <button type="button" onclick="updateQty(<?= $item['id'] ?>,1)">+</button>
                </div>
              </td>
              <td>₹<?= number_format($subtotal,2) ?></td>
              <td>
                <form method="POST" action="remove_from_cart.php">
                  <input type="hidden" name="id" value="<?= $item['id'] ?>">
                  <button type="submit" class="remove-btn">Remove</button>
                </form>
              </td>
            </tr>
            <?php endwhile; ?>
          </table>

          <?php
            $tax_rate     = 0.06;
            $packing_fee  = 20;
            $delivery_fee = ($total>100)?0:20;
            $gst          = $total*$tax_rate;
            $grand_total  = $total+$gst+$packing_fee+$delivery_fee;
          ?>
          <div class="charges">
            <p>Subtotal: ₹<?= number_format($total,2) ?></p>
            <p>GST (6%): ₹<?= number_format($gst,2) ?></p>
            <p>Packing Fee: ₹<?= number_format($packing_fee,2) ?></p>
            <p>Delivery Fee: ₹<?= number_format($delivery_fee,2) ?> <?= $delivery_fee==0?'(Free)':'' ?></p>
            <hr>
            <p><strong>Grand Total: ₹<?= number_format($grand_total,2) ?></strong></p>
          </div>

          <!-- Proceed button targets deliveryForm -->
          <button type="submit"
                  form="deliveryForm"
                  class="checkout-btn">
            ✅ Proceed to Payment
          </button>
        </section>

      <?php else: ?>
        <div class="empty-cart">
          <h2>🛒 Your cart is empty</h2>
          <p>Add some delicious items to carry on 🥪🍔</p>
          <a href="menu.php">Go to Menu</a>
        </div>
      <?php endif; ?>
    </main>

    <footer>
      <p>&copy; <?= date("Y") ?> Foodeluxe. Crafted with ❤️ in Rajkot.</p>
    </footer>
  </div>

  <script>
    // Mobile nav
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('active');
    }

    // Hide/show navbar on scroll
    let lastScroll=0,
        nav=document.getElementById('navbar');
    window.addEventListener('scroll',()=> {
      let cur=window.pageYOffset;
      if(cur<=0) nav.classList.remove('hidden');
      else if(cur>lastScroll) nav.classList.add('hidden');
      else nav.classList.remove('hidden');
      lastScroll=cur;
    });

    // AJAX qty update
    function updateQty(id, change) {
      fetch('update_qty.php', {
        method:'POST',
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`id=${id}&change=${change}`
      })
      .then(r=>r.json())
      .then(data=>{
        if(data.success) {
          document.getElementById(`qty-${id}`).textContent = data.newQty;
          location.reload();
        }
      });
    }
  </script>
</body>
</html>
