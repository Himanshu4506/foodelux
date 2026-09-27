<?php
session_start();
include '../db_connect.php'; // adjust path if needed

// Provision a predictable local development admin if this account is absent.
// Existing administrator passwords are never overwritten.
$defaultEmail = 'admin@foodeluxe.com';
$defaultPassword = 'Admin@12345';
$checkDefault = $conn->prepare("SELECT id FROM admin WHERE email = ?");
$checkDefault->bind_param('s', $defaultEmail);
$checkDefault->execute();
if ($checkDefault->get_result()->num_rows === 0) {
  $defaultName = 'Foodeluxe Admin';
  $defaultHash = password_hash($defaultPassword, PASSWORD_DEFAULT);
  $defaultRole = 'superadmin';
  $createDefault = $conn->prepare("INSERT INTO admin (name, email, password, role) VALUES (?, ?, ?, ?)");
  $createDefault->bind_param('ssss', $defaultName, $defaultEmail, $defaultHash, $defaultRole);
  $createDefault->execute();
  $createDefault->close();
}
$checkDefault->close();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email    = trim($_POST['email']);
  $password = $_POST['password'];

  $stmt = $conn->prepare("SELECT id, name, password FROM admin WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows === 1) {
    $admin = $result->fetch_assoc();
    if (password_verify($password, $admin['password'])) {
      session_regenerate_id(true);
      $_SESSION['admin_logged_in'] = true;
      $_SESSION['admin_id'] = $admin['id'];
      $_SESSION['admin_name'] = $admin['name'];
      header("Location: admin_dashboard.php");
      exit();
    } else {
      $error = "❌ Incorrect password.";
    }
  } else {
    $error = "❌ Admin not found.";
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin Login</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      padding: 40px;
    }
    .form-box {
      max-width: 400px;
      margin: auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2 {
      text-align: center;
      color: #253A4A;
      margin-bottom: 20px;
    }
    label {
      display: block;
      margin-top: 15px;
      font-weight: bold;
    }
    input {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #28a745;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #218838;
    }
    .error {
      color: red;
      margin-top: 10px;
      text-align: center;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>🔐 Admin Login</h2>
  <p>Default login: <strong>admin@foodeluxe.com</strong> / <strong>Admin@12345</strong></p>
  <form method="POST">
    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit">Login</button>
    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
  </form>
</div>

</body>
</html>
