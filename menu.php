<?php
session_start();
include 'db_connect.php';

// Fetch categories
$categories = [];
$cat_query = $conn->query("SELECT DISTINCT category FROM food_items");
while ($row = $cat_query->fetch_assoc()) {
    $categories[] = $row['category'];
}

// Fetch products
$products = $conn->query("SELECT * FROM food_items ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Foodeluxe - Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:    #0D1419;
      --slate:   #253A4A;
      --gold:    #E0A840;
      --beige:   #CDC6B6;
      --cream:   #F7F4E3;
      --success: #28a745;
    }
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
    }

    /* ===== NAVBAR ===== */
    .navbar {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 60px;
      background: var(--dark);
      color: var(--cream);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 20px;
      z-index: 999;
      transition: top 0.3s ease;
    }
    .navbar.hidden {
      top: -70px;
    }
    .navbar h1 {
      font-size: 22px;
    }
    .nav-links {
      display: flex;
      gap: 20px;
    }
    .nav-links a {
      color: var(--cream);
      text-decoration: none;
      font-size: 16px;
      transition: color 0.2s;
    }
    .nav-links a:hover {
      color: var(--gold);
    }
    .hamburger {
      display: none;
      flex-direction: column;
      cursor: pointer;
    }
    .hamburger span {
      width: 25px;
      height: 3px;
      background: var(--cream);
      margin: 4px 0;
      border-radius: 2px;
    }
    @media (max-width: 768px) {
      .hamburger {
        display: flex;
      }
      .nav-links {
        position: absolute;
        top: 60px;
        left: -100%;
        width: 100%;
        background: var(--dark);
        flex-direction: column;
        text-align: center;
        transition: left 0.3s ease;
        padding: 10px 0;
      }
      .nav-links.active {
        left: 0;
      }
      /* .nav-links a {
        padding: 12px 0;
        border-top: 1px solid rgba(255,255,255,0.1);
      } */
    }

    /* ===== SHOP LAYOUT ===== */
    .shop-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      padding: 100px 30px 30px; /* top padding accounts for fixed navbar */
    }
    .sidebar {
      flex: 1 1 250px;
      background: var(--beige);
      padding: 20px;
      border-radius: 12px;
      min-width: 220px;
    }
    .sidebar h3 {
      margin-bottom: 10px;
      color: var(--dark);
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar li {
      margin-bottom: 8px;
      font-size: 14px;
      cursor: pointer;
    }
    .sidebar li:hover {
      color: var(--gold);
    }
    .price-filter {
      margin-top: 20px;
    }
    .products {
      flex: 3;
      min-width: 300px;
    }
    .sort-bar {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
    }
    .sort-bar select {
      padding: 8px;
      border-radius: 6px;
      border: 1px solid var(--slate);
      background: var(--cream);
    }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 20px;
    }
    .card {
      background: var(--beige);
      padding: 15px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.08);
      text-align: center;
      transition: transform 0.3s ease;
    }
    .card:hover {
      transform: scale(1.03);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 8px;
    }
    .card h4 {
      margin: 10px 0;
      font-size: 18px;
    }
    .card p {
      font-size: 14px;
      color: var(--slate);
    }
    .card button {
      background: var(--success);
      color: white;
      border: none;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
      margin-top: 10px;
    }
    .card button:hover {
      background: #218838;
    }

    /* ===== POPUP ===== */
    #cart-popup {
      position: fixed;
      top: 80px;
      left: 50%;
      transform: translateX(-50%);
      background: var(--success);
      color: white;
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: bold;
      box-shadow: 0 4px 12px rgba(0,0,0,0.2);
      opacity: 0;
      transition: opacity 0.4s ease;
      z-index: 999;
    }

    /* ===== FOOTER ===== */
    footer {
      background: var(--dark);
      color: var(--cream);
      text-align: center;
      padding: 20px;
      margin-top: 40px;
    }
    @media (max-width: 768px) {
      .shop-container {
        flex-direction: column;
        padding-top: 100px;
      }
      .sidebar {
        width: 100%;
      }
    }
  </style>
</head>
<body>

  <!-- NAVBAR -->
  <header class="navbar" id="navbar">
    <h1>Foodeluxe</h1>
    <div class="hamburger" onclick="toggleMenu()">
      <span></span><span></span><span></span>
    </div>
    <nav class="nav-links" id="navLinks">
      <a href="home.php">Home</a>
      <a href="cart.php">Cart</a>
      <a href="orders.php">Orders</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- SEARCH BAR -->
<div style="text-align:center; margin:120px 20px 20px;">
  <input type="text" id="searchBox" placeholder="Search for food..." 
         style="padding:10px 15px; width:80%; max-width:400px; border-radius:8px; border:1px solid #ccc; font-size:16px;">
</div>

  <!-- POPUP -->
  <div id="cart-popup">Item added to cart!</div>

  <!-- SHOP LAYOUT -->
  <div class="shop-container">

    <!-- Products Grid -->
    <div class="products">
    
      <?php foreach ($categories as $cat): ?>
     <h2 style="margin: 30px 0 10px; font-size: 22px; color: var(--slate); border-bottom: 2px solid var(--gold); padding-bottom: 6px;">
     <?= htmlspecialchars($cat) ?>
     </h2>
     <div class="grid">
      <?php
      $items = $conn->query("SELECT * FROM food_items WHERE category='$cat' ORDER BY id DESC");
      while ($row = $items->fetch_assoc()):
      ?>
      <div class="card" data-category="<?= htmlspecialchars($row['category']) ?>">
        <img src="admin/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h4><?= htmlspecialchars($row['name']) ?></h4>
        <p>₹<?= number_format($row['price'], 2) ?></p>
        <button onclick="addToCart(<?= intval($row['id']) ?>)">Buy Now</button>
       </div>
        <?php endwhile; ?>
      </div>
     <?php endforeach; ?>

      </div>
   </div>

  <!-- FOOTER -->
  <footer>
    <p>&copy; <?= date("Y") ?> Foodeluxe. Crafted with ❤️ in Rajkot.</p>
  </footer>

  <!-- SCRIPTS -->
  <script>
    // Mobile menu toggle
    function toggleMenu() {
      document.getElementById('navLinks').classList.toggle('active');
    }

    // Hide navbar on scroll down, show on scroll up
    let lastScroll = 0;
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      const current = window.pageYOffset;
      if (current <= 0) {
        navbar.classList.remove('hidden');
        return;
      }
      if (current > lastScroll) {
        navbar.classList.add('hidden');
      } else {
        navbar.classList.remove('hidden');
      }
      lastScroll = current;
    });

    // Add to cart with popup feedback
    function addToCart(id) {
      fetch('add_to_cart.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: 'id=' + id
      })
      .then(res => res.text())
      .then(status => {
        const popup = document.getElementById('cart-popup');
        popup.textContent = status === 'success' 
          ? '✅ Item added to cart!' 
          : '❌ Failed to add item.';
        popup.style.background = status === 'success' 
          ? 'var(--success)' 
          : '#dc3545';
        popup.style.opacity = 1;
        setTimeout(() => popup.style.opacity = 0, 2500);
      });
    }

    // Category filter (example)
    function filterCategory(cat) {
      document.querySelectorAll('.card').forEach(card => {
        card.style.display = (cat === 'all' || card.dataset.category === cat)
          ? 'block' : 'none';
      });
    }
    // Sorting stub (implement as needed)
    function sortProducts(val) {
      console.log('Sort by:', val);
    }

    // Live Search (AJAX)
document.getElementById("searchBox").addEventListener("keyup", function() {
  let query = this.value.trim();
  
  fetch("search_items.php", {
    method: "POST",
    headers: {"Content-Type": "application/x-www-form-urlencoded"},
    body: "query=" + encodeURIComponent(query)
  })
  .then(res => res.text())
  .then(data => {
    document.querySelector(".products").innerHTML = data;
  });
});
  </script>

</body>
</html>
