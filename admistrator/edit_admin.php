<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
  die("Access denied.");
}

if (!isset($_GET['id'])) {
  die("Invalid request.");
}

$id = intval($_GET['id']);

// âœ… Fetch current admin details
$stmt = $conn->prepare("SELECT name, email, role FROM admin WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$admin = $result->fetch_assoc();
$stmt->close();

if (!$admin) {
  die("Admin not found.");
}

// âœ… Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name  = trim($_POST['name']);
  $email = trim($_POST['email']);
  $role  = trim($_POST['role']);

  $stmt = $conn->prepare("UPDATE admin SET name=?, email=?, role=? WHERE id=?");
  $stmt->bind_param("sssi", $name, $email, $role, $id);

  if ($stmt->execute()) {
    echo "<script>alert('âœ… Admin updated successfully'); window.location.href='add_admin.php';</script>";
  } else {
    echo "âŒ Error: " . $stmt->error;
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Admin</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      padding: 40px;
    }
    .form-box {
      max-width: 500px;
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
    input, select {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 6px;
    }
    button {
      margin-top: 20px;
      padding: 10px 20px;
      background: #007bff;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
    }
    button:hover {
      background: #0056b3;
    }
  </style>
</head>
<body>

<div class="form-box">
  <h2>âœï¸ Edit Admin</h2>
  <form method="POST">
    <label>Name</label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" required>

    <label>Email</label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($admin['email']); ?>" required>

    <label>Role</label>
    <select name="role">
      <option value="admin" <?php if($admin['role']=="admin") echo "selected"; ?>>Admin</option>
      <option value="superadmin" <?php if($admin['role']=="superadmin") echo "selected"; ?>>Super Admin</option>
    </select>

    <button type="submit">Update Admin</button>
  </form>
</div>

</body>
</html>
