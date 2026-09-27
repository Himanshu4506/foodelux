<?php
session_start();
include 'db_connect.php';

// Fetch categories
$categories = [];
$cat_query = $conn->query("SELECT DISTINCT category FROM food_items");
while ($row = $cat_query->fetch_assoc()) {
    $categories[] = $row['category'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Foodeluxe - Shop</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark: #0D1419;
      --slate: #253A4A;
      --gold: #E0A840;
      --beige: #F5F5F5;
      --cream: #FAFAFA;
      --success: #28a745;
      --danger: #dc3545;
      --gradient: linear-gradient(135deg, #E0A840, #FF7E5F);
    }
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
      line-height: 1.6;
    }

    /* ===== NAVBAR ===== */
    .navbar {
      position: fixed;
      top: 0; left: 0;
      width: 100%;
      height: 65px;
      background: rgba(13, 20, 25, 0.75);
      backdrop-filter: blur(10px);
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 25px;
      z-index: 999;
      transition: 0.3s ease;
    }
    .navbar.scrolled { background: var(--dark); }
    .navbar h1 { font-size: 22px; color: var(--gold); font-weight: 600; }
    .nav-links { display: flex; gap: 22px; }
    .nav-links a {
      color: var(--cream);
      text-decoration: none;
      font-size: 15px;
      font-weight: 500;
      position: relative;
      transition: color 0.3s;
    }
    .nav-links a:hover { color: var(--gold); }
    .nav-links a::after {
      content: '';
      position: absolute;
      width: 0; height: 2px;
      bottom: -4px; left: 0;
      background: var(--gold);
      transition: width 0.3s;
    }
    .nav-links a:hover::after { width: 100%; }
    .hamburger { display: none; flex-direction: column; cursor: pointer; }
    .hamburger span {
      width: 26px; height: 3px;
      background: var(--cream);
      margin: 4px 0; border-radius: 2px;
    }
    @media (max-width: 768px) {
      .hamburger { display: flex; }
      .nav-links {
        position: absolute;
        top: 65px; left: -100%;
        width: 100%;
        background: var(--dark);
        flex-direction: column;
        text-align: center;
        transition: left 0.3s ease;
        padding: 15px 0;
      }
      .nav-links.active { left: 0; }
    }

    .filter-bar {
  margin: 90px 30px 20px; /* Navbar ke niche */
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 10px;
}
.filter-bar label {
  font-weight: 600;
  color: var(--slate);
}
.filter-bar select {
  padding: 8px 12px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 14px;
}

    /* ===== SHOP LAYOUT ===== */
    .shop-container {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      padding: 100px 30px 30px;
    }
    .sidebar {
  flex: 1 1 220px;
  background: white;
  border-radius: 16px;
  padding: 20px;
  box-shadow: 0 6px 18px rgba(0,0,0,0.08);
  position: sticky;
  top: 80px; /* Navbar ke niche fix */
  height: fit-content;
  transition: transform 0.4s ease, opacity 0.4s ease;
  z-index: 998;
}

.sidebar.hide {
  transform: translateY(-120%);
  opacity: 0;
}

    .sidebar h3 {
      margin-bottom: 14px;
      font-size: 18px;
      color: var(--slate);
    }
    .sidebar ul { list-style: none; }
    .sidebar li {
      padding: 10px 12px;
      border-radius: 10px;
      cursor: pointer;
      font-size: 15px;
      transition: background 0.2s, transform 0.2s;
    }
    .sidebar li:hover { 
      background: var(--beige); 
      color: var(--gold);
      transform: translateX(5px);
    }

    .products { flex: 3; min-width: 280px; }
    .grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
      gap: 24px;
      animation: fadeInUp 0.7s ease;
    }
    .category-title {
      margin: 30px 0 12px;
      font-size: 22px;
      color: var(--slate);
      border-left: 5px solid var(--gold);
      padding-left: 10px;
      font-weight: 600;
    }
    .card {
      background: rgba(255,255,255,0.9);
      backdrop-filter: blur(8px);
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      padding: 15px;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      position: relative;
      overflow: hidden;
    }
    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    }
    .card img {
      width: 100%;
      height: 180px;
      object-fit: cover;
      border-radius: 12px;
      transition: transform 0.4s ease;
    }
    .card:hover img { transform: scale(1.05); }
    .card h4 { margin: 12px 0 6px; font-size: 18px; }
    .card p { font-size: 14px; color: var(--slate); }
    .card button {
      margin-top: 12px;
      background: var(--gradient);
      color: white;
      border: none;
      padding: 10px 16px;
      border-radius: 10px;
      cursor: pointer;
      font-weight: bold;
      font-size: 14px;
      transition: transform 0.2s, opacity 0.3s;
    }
    .card button:hover {
      opacity: 0.9;
      transform: scale(1.05);
    }

    /* ===== POPUP ===== */
    #cart-popup {
      position: fixed;
      bottom: 30px; right: 30px;
      background: var(--success);
      color: white;
      padding: 12px 22px;
      border-radius: 12px;
      font-weight: bold;
      box-shadow: 0 6px 14px rgba(0,0,0,0.15);
      opacity: 0;
      transform: translateY(20px);
      transition: opacity 0.4s, transform 0.4s;
      z-index: 999;
    }
    #cart-popup.show {
      opacity: 1;
      transform: translateY(0);
    }

    footer {
      background: var(--dark);
      color: var(--cream);
      text-align: center;
      padding: 25px;
      margin-top: 50px;
    }

    /* Animations */
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeInUp {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
  .shop-container { flex-direction: column; }
  .sidebar { width: 100%; order: 1; }  /* Sidebar pehle */
  .products { order: 2; }              /* Products baad me */
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

  <!-- POPUP -->
  <div id="cart-popup">Item added to cart!</div>

  <!-- SHOP LAYOUT -->
  <div class="shop-container">
    <!-- Sidebar -->
    <aside class="sidebar">
      <h3>Categories</h3>
      <ul>
        <li onclick="filterCategory('all')">All</li>
        <?php foreach ($categories as $cat): ?>
          <li onclick="filterCategory('<?= htmlspecialchars($cat) ?>')">
            <?= htmlspecialchars($cat) ?>
          </li>
        <?php endforeach; ?>
      </ul>
    </aside>

    <!-- Products -->
<div class="products">
  <div class="grid" id="productGrid">
    <?php
    $items = $conn->query("SELECT * FROM food_items ORDER BY id DESC");
    while ($row = $items->fetch_assoc()):
    ?>
      <div class="card" data-category="<?= htmlspecialchars($row['category']) ?>">
        <img src="admin/<?= htmlspecialchars($row['image']) ?>" alt="<?= htmlspecialchars($row['name']) ?>">
        <h4><?= htmlspecialchars($row['name']) ?></h4>
        <p>₹<?= number_format($row['price'], 2) ?></p>
        <button onclick="addToCart(<?= intval($row['id']) ?>)">🛒 Buy Now</button>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<!-- SORT FILTER -->
<div class="filter-bar">
  <label for="sort">Sort By:</label>
  <select id="sort" onchange="sortProducts()">
    <option value="latest">Latest</option>
    <option value="price_low_high">Price: Low to High</option>
    <option value="price_high_low">Price: High to Low</option>
    <option value="name_az">Name: A to Z</option>
    <option value="name_za">Name: Z to A</option>
  </select>
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

    // Navbar scroll effect
    window.addEventListener('scroll', () => {
      const navbar = document.getElementById('navbar');
      navbar.classList.toggle('scrolled', window.scrollY > 50);
    });

    let lastScrollTop = 0;
window.addEventListener("scroll", function() {
  let st = window.scrollY || document.documentElement.scrollTop;
  const sidebar = document.querySelector(".sidebar");

  if (st > lastScrollTop) {
    // Downscroll → hide sidebar
    sidebar.classList.add("hide");
  } else {
    // Upscroll → show sidebar
    sidebar.classList.remove("hide");
  }
  lastScrollTop = st <= 0 ? 0 : st; // Avoid negative
}, false);


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
        popup.style.background = status === 'success' ? 'var(--success)' : 'var(--danger)';
        popup.classList.add('show');
        setTimeout(() => popup.classList.remove('show'), 2500);
      });
    }

    // Category filter
function filterCategory(cat) {
  document.querySelectorAll('.card').forEach(card => {
    card.style.display = (cat === 'all' || card.dataset.category === cat)
      ? 'block' : 'none';
  });
}

function sortProducts() {
  const sortValue = document.getElementById("sort").value;
  const grid = document.getElementById("productGrid");
  const cards = Array.from(grid.getElementsByClassName("card"));

  let sortedCards;
  switch (sortValue) {
    case "price_low_high":
      sortedCards = cards.sort((a, b) =>
        parseFloat(a.querySelector("p").textContent.replace("₹", "")) -
        parseFloat(b.querySelector("p").textContent.replace("₹", ""))
      );
      break;

    case "price_high_low":
      sortedCards = cards.sort((a, b) =>
        parseFloat(b.querySelector("p").textContent.replace("₹", "")) -
        parseFloat(a.querySelector("p").textContent.replace("₹", ""))
      );
      break;

    case "name_az":
      sortedCards = cards.sort((a, b) =>
        a.querySelector("h4").textContent.localeCompare(b.querySelector("h4").textContent)
      );
      break;

    case "name_za":
      sortedCards = cards.sort((a, b) =>
        b.querySelector("h4").textContent.localeCompare(a.querySelector("h4").textContent)
      );
      break;

    case "latest":
    default:
      sortedCards = cards; // By default keep order (latest added)
  }

  // Re-append sorted cards
  grid.innerHTML = "";
  sortedCards.forEach(card => grid.appendChild(card));
}


  </script>

</body>
</html>
