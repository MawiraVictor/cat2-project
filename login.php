<?php
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = $conn->prepare('SELECT id, password_hash FROM users WHERE username = ?');
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password_hash'])) {
            $_SESSION['user'] = $username;
            header('Location: dashboard.php');
            exit;
        }
    }
    $msg = 'Invalid username or password.';
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Arial,sans-serif;background:#f0f2f5;display:flex;justify-content:center;padding:40px}
form{background:#fff;padding:28px;border-radius:8px;width:320px;box-shadow:0 2px 8px #0002}
input,button{width:100%;padding:10px;margin:8px 0;box-sizing:border-box}
button{background:#2563eb;color:#fff;border:0;border-radius:4px;cursor:pointer}
.msg{color:#b91c1c}
</style></head><body>
<form method="post">
  <h2>Login</h2>
  <p class="msg"><?= htmlspecialchars($msg) ?></p>
  <input name="username" placeholder="Username" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Login</button>
  <p>No account? <a href="signup.php">Sign up</a></p>
</form>
</body></html>
