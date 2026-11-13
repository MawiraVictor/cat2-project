<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Dashboard</title>
<style>body{font-family:Arial,sans-serif;padding:40px}</style></head><body>
<h2>Login successful</h2>
<p>Welcome, <b><?= htmlspecialchars($_SESSION['user']) ?></b>!</p>
<p><a href="feedback.php">Submit feedback</a> | <a href="logout.php">Logout</a></p>
</body></html>
