<?php
session_start();
include 'db_connect.php'; // apna DB connection include karo

$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $message = trim($_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        if ($stmt->execute()) {
            $success = "✅ Thank you $name, your message has been saved!";
        } else {
            $success = "❌ Failed to save message!";
        }
        $stmt->close();
    } else {
        $success = "⚠ Please fill all fields!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Us – Foodeluxe</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark: #0D1419;
      --cream: #F7F4E3;
      --gold: #E0A840;
      --slate: #253A4A;
      --green: #28a745;
    }
    body {
      font-family: 'Segoe UI', sans-serif;
      background: var(--cream);
      margin: 0;
      padding: 0;
    }
    .navbar {
      background: var(--dark);
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      color: var(--cream);
    }
    .navbar a { color: var(--cream); text-decoration: none; margin-left: 20px; }
    .navbar a:hover { color: var(--gold); }

    .container {
      max-width: 600px;
      margin: 50px auto;
      background: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h1 { color: var(--slate); margin-bottom: 20px; }
    label { display: block; margin: 10px 0 6px; font-weight: bold; }
    input, textarea {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 15px;
    }
    button {
      background: var(--green);
      color: white;
      padding: 10px 20px;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-weight: bold;
    }
    button:hover { background: #218838; }
    .success { color: var(--green); margin-bottom: 15px; }
    .error { color: red; margin-bottom: 15px; }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div><b>Foodeluxe</b></div>
    <div>
      <a href="home.php">Home</a>
      <a href="shop.php">Shop</a>
      <a href="cart.php">Cart</a>
      <a href="orders.php">Orders</a>
      <a href="about_us.php">About</a>
      <a href="contact.php">Contact</a>
    </div>
  </div>

  <!-- Contact Content -->
  <div class="container">
    <h1>Contact Us</h1>
    <?php if (!empty($success)): ?>
      <p class="<?= strpos($success, '✅') !== false ? 'success' : 'error' ?>">
        <?= $success ?>
      </p>
    <?php endif; ?>

    <form method="POST">
      <label>Your Name</label>
      <input type="text" name="name" required>

      <label>Your Email</label>
      <input type="email" name="email" required>

      <label>Your Message</label>
      <textarea name="message" rows="5" required></textarea>

      <button type="submit">Send Message</button>
    </form>
  </div>

</body>
</html>
