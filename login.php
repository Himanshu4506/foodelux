<?php
session_start();
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: home.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - Foodeluxe</title>
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
    .password-box {
      position: relative;
    }
    .password-box span {
      position: absolute;
      right: 10px;
      top: 50%;
      transform: translateY(-50%);
      cursor: pointer;
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
      .signup-link {
      text-align: center;
      margin-top: 20px;
      font-size: 14px;
    }
    .signup-link a {
      color: #007bff;
      text-decoration: none;
      font-weight: bold;
    }
  </style>
</head>
<body>
  <div class="form-box">
    <h2>Login to Foodeluxe</h2>
    <form method="POST">
      <label>Email</label>
      <input type="email" name="email" required>

      <label>Password</label>
      <div class="password-box">
        <input type="password" name="password" id="password" required>
        <span onclick="togglePassword()">👁️</span>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="signup-link">
    Don’t have an account? <a href="register.php">Register here</a>
  </div>

    <?php if (isset($error)): ?>
      <div class="error">❌ <?= $error ?></div>
    <?php endif; ?>
  </div>

  <script>
    function togglePassword() {
      const input = document.getElementById("password");
      input.type = input.type === "password" ? "text" : "password";
    }
  </script>
</body>
</html>
