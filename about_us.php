<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us - Foodeluxe</title>
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

/* Navbar */
.navbar {
  background: var(--dark);
  color: var(--cream);
  padding: 15px 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  transition: top 0.3s ease;
  z-index: 999;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.navbar h2 {
  margin: 0;
  font-size: 22px;
  font-weight: bold;
}
.nav-links {
  display: flex;
  gap: 20px;
  margin-right: 60px;
}
.nav-links a {
  color: var(--cream);
  text-decoration: none;
  font-size: 16px;
  font-weight: 500;
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
@media(max-width:768px) {
  .hamburger {
    display: flex;
    margin-right: 40px;
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
}

/* Hero Section */
.hero {
  background: linear-gradient(to right, var(--gold), #ff944d);
  color: var(--dark);
  padding: 100px 30px 60px;
  text-align: center;
  animation: fadeIn 0.6s ease-in;
}
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}
.hero h1 {
  font-size: 3em;
  margin-bottom: 10px;
}
.hero p {
  font-size: 1.2em;
  max-width: 700px;
  margin: auto;
  color: var(--dark);
}

/* Content */
.container {
  max-width: 900px;
  margin: 20px auto;
  padding: 20px;
}
.section {
  background: var(--beige);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.05);
  margin-bottom: 30px;
}
.section h2 {
  color: var(--gold);
  margin-bottom: 10px;
}
.section p {
  line-height: 1.6;
  color: var(--slate);
}
.highlight {
  background: var(--cream);
  padding: 20px;
  border-left: 5px solid var(--gold);
  border-radius: 6px;
  margin-top: 20px;
  font-size: 14px;
}

/* Creator Badge */
strong.creator {
  background: var(--gold);
  color: var(--dark);
  padding: 4px 8px;
  border-radius: 6px;
  box-shadow: 0 0 6px rgba(224, 168, 64, 0.4);
}

/* Footer */
footer {
  background: var(--dark);
  color: var(--cream);
  text-align: center;
  padding: 20px;
  font-size: 14px;
}

    </style>
</head>
<body>

<!-- Navbar -->
<div class="navbar">
    <h2>Foodeluxe</h2>
    <div class="hamburger" onclick="toggleMenu()">
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="nav-links">
        <a href="home.php">Home</a>
        <a href="shop.php">Shop</a>
        <a href="cart.php">Cart</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<!-- Hero Section -->
<div class="hero">
    <h1>About Foodeluxe</h1>
    <p>Where flavors meet technology. Foodeluxe is more than a food ordering platform—it's a celebration of taste, speed, and simplicity.</p>
</div>

<!-- Main Content -->
<div class="container">
    <div class="section">
        <h2>Our Story</h2>
        <p>Foodeluxe was born in Rajkot, Gujarat, with a simple vision: make food ordering effortless and enjoyable. Whether you're craving spicy Punjabi, comforting South Indian, or cheesy Italian, we bring it all to your fingertips.</p>
    </div>

    <div class="section">
        <h2>What Makes Us Different</h2>
        <p>We don’t just deliver food—we deliver experiences. With a clean UI, real-time order tracking, secure login, and a responsive admin dashboard, Foodeluxe is built for both users and restaurant partners.</p>
        <div class="highlight">
            <strong>✨ Fast Ordering</strong> — Just a few clicks and your meal is on its way.<br>
            <strong>🔒 Secure Platform</strong> — Built with PHP/MySQL and session-based logic.<br>
            <strong>📱 Mobile Friendly</strong> — Designed to look great on every screen.
        </div>
    </div>

    <div class="section">
        <h2>Meet the Creator</h2>
        <p>Foodeluxe is handcrafted by <strong>Prashant</strong>, a passionate web developer from Gujarat. With a love for clean design and robust backend logic, he’s built Foodeluxe from the ground up—one feature at a time.</p>
    </div>
</div>

<!-- Footer -->
<footer>
    &copy; <?php echo date("Y"); ?> Foodeluxe. Crafted with ❤️ in Gujarat.
</footer>

<!-- Navbar JS -->
<script>
let timer;
function toggleMenu() {
    const menu = document.querySelector('.nav-links');
    menu.classList.toggle('active');

    clearTimeout(timer);
    if (menu.classList.contains('active')) {
        timer = setTimeout(() => {
            menu.classList.remove('active');
        }, 5000);
    }
}

let lastScroll = 0;
window.addEventListener("scroll", () => {
    const navbar = document.querySelector(".navbar");
    let currentScroll = window.pageYOffset;

    if (currentScroll > lastScroll) {
        navbar.style.top = "-70px";
    } else {
        navbar.style.top = "0";
    }
    lastScroll = currentScroll;
});
</script>

</body>
</html>
