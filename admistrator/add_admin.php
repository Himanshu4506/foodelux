<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php'; // adjust path if needed

// âœ… Optional: restrict access to logged-in admins
if (!isset($_SESSION['admin_logged_in'])) {
  die("Access denied.");
}

// âœ… Handle Delete request
if (isset($_GET['delete'])) {
  $id = intval($_GET['delete']);
  $conn->query("DELETE FROM admin WHERE id=$id");
  echo "<script>alert('ðŸ—‘ï¸ Admin deleted successfully'); window.location.href='add_admin.php';</script>";
  exit();
}

// âœ… Count total admins
$countResult = $conn->query("SELECT COUNT(*) AS total FROM admin");
$row = $countResult->fetch_assoc();
$totalAdmins = $row['total'];

// âœ… Fetch all admins
$adminsResult = $conn->query("SELECT id, name, email, role FROM admin ORDER BY id DESC");

// âœ… Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name     = trim($_POST['name']);
  $email    = trim($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role     = trim($_POST['role']);

  $stmt = $conn->prepare("INSERT INTO admin (name, email, password, role) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $name, $email, $password, $role);

  if ($stmt->execute()) {
    echo "<script>alert('âœ… New admin added successfully'); window.location.href='add_admin.php';</script>";
  } else {
    echo "âŒ Error: " . $stmt->error;
  }

  $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Admin & List</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f7f7f7;
      padding: 40px;
    }
    .box {
      max-width: 800px;
      margin: 20px auto;
      background: white;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    h2, h3 {
      text-align: center;
      color: #253A4A;
      margin-bottom: 20px;
    }
    .count-box {
      text-align: center;
      font-size: 18px;
      color: #333;
      margin-bottom: 20px;
      padding: 10px;
      background: #e9f7ef;
      border: 1px solid #d4edda;
      border-radius: 8px;
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
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ddd;
      text-align: center;
    }
    th {
      background: #253A4A;
      color: white;
    }
    tr:nth-child(even) {
      background: #f9f9f9;
    }
    .action-btn {
      padding: 6px 12px;
      border-radius: 6px;
      font-size: 14px;
      text-decoration: none;
      color: white;
      margin: 0 4px;
      display: inline-block;
    }
    .edit-btn { background: #007bff; }
    .edit-btn:hover { background: #0056b3; }
    .delete-btn { background: #dc3545; }
    .delete-btn:hover { background: #b02a37; }
  </style>
</head>
<body>

<!-- âœ… Add Admin Form Box -->
<div class="box">
  <h2>Add New Admin</h2>
  <form method="POST">
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <label>Role</label>
    <select name="role">
      <option value="admin">Admin</option>
      <option value="superadmin">Super Admin</option>
    </select>

    <button type="submit">Create Admin</button>
  </form>
</div>

<!-- âœ… Admin List Box -->
<div class="box">
  <h3>Admin List</h3>
  <div class="count-box">
   Total Admins: <strong><?php echo $totalAdmins; ?></strong>
  </div>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Email</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
    <?php while ($admin = $adminsResult->fetch_assoc()) { ?>
      <tr>
        <td><?php echo $admin['id']; ?></td>
        <td><?php echo htmlspecialchars($admin['name']); ?></td>
        <td><?php echo htmlspecialchars($admin['email']); ?></td>
        <td><?php echo ucfirst($admin['role']); ?></td>
        <td>
          <a href="edit_admin.php?id=<?php echo $admin['id']; ?>" class="action-btn edit-btn">Edit</a>
          <a href="add_admin.php?delete=<?php echo $admin['id']; ?>" 
             class="action-btn delete-btn"
             onclick="return confirm('Are you sure you want to delete this admin?');">Delete</a>
        </td>
      </tr>
    <?php } ?>
  </table>
</div>

</body>
</html>
