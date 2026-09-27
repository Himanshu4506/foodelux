<?php
session_start();
require_once 'admin_auth.php';
include 'db_connect.php';

// âœ… Delete Message
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM contact_messages WHERE id=$id");
    header("Location: admin_messages.php?msg=deleted");
    exit();
}

// âœ… Fetch all messages
$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Contact Messages â€“ Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    :root {
      --dark:#0D1419; --slate:#253A4A; --gold:#E0A840; 
      --cream:#F7F4E3; --red:#dc3545;
    }
    body { font-family:'Segoe UI',sans-serif; background:var(--cream); margin:0; }
    .navbar {
      background: var(--dark);
      color: var(--cream);
      padding: 15px 20px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      flex-wrap: wrap;
    }
    .navbar a { color: var(--cream); text-decoration:none; margin-left: 20px; }
    .navbar a:hover { color: var(--gold); }

    .container { 
      max-width:1000px; margin:30px auto; 
      background:#fff; padding:20px; 
      border-radius:12px; 
      box-shadow:0 4px 12px rgba(0,0,0,0.1); 
    }
    h2 { text-align:center; color:var(--gold); margin-bottom:20px; }

    .table-wrapper { 
      overflow-x:auto; 
      -webkit-overflow-scrolling: touch; 
    }
    table { 
      width:100%; border-collapse: collapse; 
      font-size: 14px; min-width: 600px;
    }
    th,td { 
      border:1px solid #ddd; 
      padding:10px; 
      text-align:left; 
      vertical-align: top; 
    }
    th { background: var(--dark); color: var(--cream); }
    tr:nth-child(even) { background:#f9f9f9; }

    .btn-delete {
      background: var(--red);
      color: white;
      padding: 6px 12px;
      border-radius: 6px;
      text-decoration: none;
      font-size: 13px;
      display: inline-block;
    }
    .btn-delete:hover { background: #a71d2a; }

    /* âœ… Responsive adjustments */
    @media (max-width: 768px) {
      table { font-size: 13px; min-width: 100%; }
      th,td { padding: 8px; }
    }
    @media (max-width: 500px) {
      .navbar { flex-direction: column; align-items: flex-start; }
      .navbar a { margin: 5px 0 0 0; }
      h2 { font-size: 20px; }
      .btn-delete { font-size: 12px; padding: 5px 10px; }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <div class="navbar">
    <div><b>Foodeluxe Admin</b></div>
    <div>
      <a href="admin_dashboard.php">Dashboard</a>
    </div>
  </div>

  <div class="container">
    <h2>ðŸ“© Contact Messages</h2>
    <?php if (isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
      <p style="color:green; text-align:center;">âœ… Message deleted successfully.</p>
    <?php endif; ?>

    <?php if ($result->num_rows > 0): ?>
      <div class="table-wrapper">
        <table>
          <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Date</th>
            <th>Action</th>
          </tr>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($row['name']) ?></td>
              <td><?= htmlspecialchars($row['email']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['message'])) ?></td>
              <td><?= $row['created_at'] ?></td>
              <td>
                <a class="btn-delete" href="admin_messages.php?delete=<?= $row['id'] ?>" 
                   onclick="return confirm('Are you sure you want to delete this message?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        </table>
      </div>
    <?php else: ?>
      <p style="text-align:center;">No messages yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
