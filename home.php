<?php
session_start();
include 'db_connect.php';

// if (!isset($_SESSION['user_id'])) {
//     header("Location: login.php");
//     exit();
// }

$user_name = htmlspecialchars($_SESSION['user_name'] ?? 'Guest');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Foodeluxe - Home</title>
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

    /* ===== HERO SECTION ===== */
    .hero {
      margin-top: 60px;
      background-image: url('assets/food-banner.png');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      height: calc(100vh - 60px);
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
      padding: 0 20px;
      text-align: center;
      color: var(--cream);
    }
    .hero::before {
      content: '';
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.4);
      z-index: 1;
    }
    .hero-content {
      position: relative;
      z-index: 2;
      max-width: 600px;
    }
    .hero-content h2 {
      font-size: 40px;
      margin-bottom: 10px;
      color: var(--gold);
    }
    .hero-content p {
      font-size: 20px;
      margin-bottom: 20px;
    }
    .explore-btn {
      background: var(--gold);
      color: var(--dark);
      padding: 12px 24px;
      border-radius: 8px;
      font-weight: bold;
      font-size: 18px;
      transition: background 0.3s ease;
      text-decoration: none;
    }
    .explore-btn:hover {
      background: var(--slate);
      color: var(--cream);
    }

    @media (max-width: 768px) {
      .hero-content h2 {
        font-size: 28px;
      }
      .hero-content p {
        font-size: 16px;
      }
      .explore-btn {
        font-size: 16px;
        padding: 10px 20px;
      }
    }

    /* ===== FOOTER ===== */
    footer {
      background: var(--dark);
      color: var(--cream);
      text-align: center;
      padding: 20px;
      /* margin-top: 40px; */
    }
  </style>
</head>
<body>

  <!-- ===== NAVBAR ===== -->
  <header class="navbar" id="navbar">
    <h1>Foodeluxe</h1>
    <div class="hamburger" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>
    <nav class="nav-links" id="navLinks">
      <a href="home.php">Home</a>
      <a href="menu.php">Menu</a>
      <a href="cart.php">Cart</a>
      <a href="orders.php">Orders</a>
      <a href="about_us.php">About Us</a>
      <a href="contact.php">Contact</a>
      <a href="logout.php">Logout</a>
    </nav>
  </header>

  <!-- ===== HERO SECTION ===== -->
  <section class="hero">
    <div class="hero-content">
      <h2>Welcome, <?= $user_name ?>!</h2>
      <p>Super Delicious Food — Today’s Best Deal</p>
      <a href="menu.php" class="explore-btn">🍽️ Explore Menu</a>
    </div>
  </section>

  <!-- ===== FOOTER ===== -->
  <footer>
    <p>&copy; <?= date("Y") ?> Foodeluxe. Crafted with ❤️ in Rajkot.</p>
  </footer>

  <!-- ===== SCRIPT ===== -->
  <script>
    // Toggle mobile menu
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
  </script>

</body>
</html>
