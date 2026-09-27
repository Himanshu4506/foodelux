<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm'] ?? '';

    if ($name && $email && $password && $password === $confirm) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed);
        if ($stmt->execute()) {
            header("Location: login.php?registered=1");
            exit();
        } else {
            $error = "Email already exists or invalid data.";
        }
    } else {
        $error = "Please fill all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Register - Foodeluxe</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #F7F4E3;
      padding: 40px;
      color: #0D1419;
    }
    .form-box {
      max-width: 500px;
      margin: auto;
      background: #CDC6B6;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #E0A840;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 6px;
      border: 1px solid #253A4A;
      border-radius: 6px;
      background: #F7F4E3;
    }
    button {
      margin-top: 20px;
      background: #28a745;
      color: white;
      padding: 12px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }
    .error {
      color: red;
      text-align: center;
      margin-top: 15px;
    }
     .login-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }
    .login-link a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<script>
function togglePassword(id) {
  const input = document.getElementById(id);
  input.type = input.type === "password" ? "text" : "password";
}
</script>
<body>
  <div class="form-box">
    <h2>Create Account</h2>
    <form method="POST">
      <label>Name</label>
      <input type="text" name="name" required>

      <label>Email</label>
      <input type="email" name="email" required>

      <label>Phone</label>
      <input type="text" name="phone">

      <label>Password</label>
<div style="position:relative;">
  <input type="password" name="password" id="password" required>
  <span onclick="togglePassword('password')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">👁️</span>
</div>

<label>Confirm Password</label>
<div style="position:relative;">
  <input type="password" name="confirm" id="confirm" required>
  <span onclick="togglePassword('confirm')" style="position:absolute; right:10px; top:50%; transform:translateY(-50%); cursor:pointer;">👁️</span>
</div>


      <button type="submit">Register</button>
    </form>

     <div class="login-link">
    Already have an account? <a href="login.php">Login here</a>
  </div>
    <?php if (isset($error)): ?>
      <div class="error">❌ <?= $error ?></div>
    <?php endif; ?>
  </div>
</body>
</html>
