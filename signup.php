<?php
require 'config.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $fullname = trim($_POST['fullname'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username === '' || $email === '' || strlen($password) < 6) {
        $msg = 'Fill all fields (password at least 6 characters).';
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare('INSERT INTO users (username, fullname, email, password_hash) VALUES (?,?,?,?)');
        $stmt->bind_param('ssss', $username, $fullname, $email, $hash);
        if ($stmt->execute()) {
            $msg = 'Account created. <a href="login.php">Log in</a>';
        } else {
            $msg = 'Error: username or email already exists.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><h2>Sign Up</h2>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body{font-family:Arial,sans-serif;background:#f0f2f5;display:flex;justify-content:center;padding:40px}
form{background:#fff;padding:28px;border-radius:8px;width:320px;box-shadow:0 2px 8px #0002}
input,button{width:100%;padding:10px;margin:8px 0;box-sizing:border-box}
button{background:#2563eb;color:#fff;border:0;border-radius:4px;cursor:pointer}
.msg{color:#065f46}
</style></head><body>
<form method="post">
  <h2>Sign Up</h2>
  <p class="msg"><?= $msg ?></p>
  <input name="username" placeholder="Username" required>
  <input name="fullname" placeholder="Full name">
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Password" required>
  <button type="submit">Create account</button>
  <p>Have an account? <a href="login.php">Login</a></p>
</form>
</body></html>
