<?php
session_start();
include 'db_connect.php';
require_once 'admin_auth.php';

$total_orders  = $conn->query("SELECT COUNT(*) AS total FROM orders")->fetch_assoc()['total'];
$total_items   = $conn->query("SELECT COUNT(*) AS total FROM food_items")->fetch_assoc()['total'];
$total_revenue = $conn->query("SELECT SUM(grand_total) AS revenue FROM orders")->fetch_assoc()['revenue'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Foodeluxe Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:   #0D1419;
      --slate:  #253A4A;
      --gold:   #E0A840;
      --beige:  #CDC6B6;
      --cream:  #F7F4E3;
      --success:#28a745;
    }

    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      color: var(--dark);
    }

    .navbar {
      background: var(--dark);
      color: var(--cream);
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
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
      font-weight: bold;
      transition: color 0.2s ease;
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
  height: 3px;
  width: 25px;
  background: var(--cream);
  margin: 4px 0;
  border-radius: 2px;
}

@media (max-width: 768px) {
  .hamburger {
    display: flex;
  }

  .nav-links {
    flex-direction: column;
    position: absolute;
    top: 60px;
    left: -100%;
    width: 100%;
    background: var(--dark);
    text-align: center;
    transition: left 0.3s ease;
    padding: 10px 0;
  }

  .nav-links.active {
    left: 0;
  }

  .nav-links a {
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
  }
}


    .dashboard {
      max-width: 1000px;
      margin: 40px auto;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
      gap: 30px;
      padding: 0 20px;
    }

    .card {
      background: var(--beige);
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-4px);
    }

    .card h2 {
      font-size: 20px;
      margin-bottom: 10px;
      color: var(--slate);
    }

    .card p {
      font-size: 24px;
      font-weight: bold;
      color: var(--dark);
    }

    .card i {
      font-size: 32px;
      color: var(--gold);
      margin-bottom: 12px;
    }

    @media (max-width: 600px) {
      .card p {
        font-size: 20px;
      }
    }
  </style>
  <!-- Optional: Font Awesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

<!-- Navbar -->
<div class="navbar">
  <h1>Foodeluxe Admin</h1>
  <div class="hamburger" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <div class="nav-links" id="navLinks">
    <a href="admin_dashboard.php">Dashboard</a>
    <a href="orders.php">Orders</a>
    <a href="products.php">Products</a>
     <a href="admin_messages.php">User Review</a>
    <a href="add_admin.php">Manage Admin</a>
    <a href="admin_logout.php">Logout</a>
  </div>
</div>

<!-- Dashboard Cards -->
<div class="dashboard">
  <div class="card">
    <i class="fas fa-shopping-cart"></i>
    <h2>Total Orders</h2>
    <p><?= $total_orders ?></p>
  </div>
  <div class="card">
    <i class="fas fa-burger"></i>
    <h2>Total Products</h2>
    <p><?= $total_items ?></p>
  </div>
  <div class="card">
    <i class="fas fa-rupee-sign"></i>
    <h2>Total Revenue</h2>
    <p>₹<?= number_format($total_revenue, 2) ?></p>
  </div>
</div>

</body>
<script>
  function toggleMenu() {
    document.getElementById('navLinks').classList.toggle('active');
  }
</script>

</html>
