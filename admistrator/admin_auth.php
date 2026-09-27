<?php
// Include after session_start() on every protected administrator page.
if (empty($_SESSION['admin_logged_in']) || empty($_SESSION['admin_id'])) {
    header('Location: admin_login.php');
    exit();
}
