<?php
require 'config.php';
if (!isset($_SESSION['user'])) { header('Location: login.php'); exit; }
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $rating  = (int)($_POST['rating'] ?? 0);
    $comment = trim($_POST['comment'] ?? '');
    $stmt = $conn->prepare('INSERT INTO feedback (name, rating, comment) VALUES (?,?,?)');
    $stmt->bind_param('sis', $name, $rating, $comment);
    $msg = $stmt->execute() ? 'Feedback saved (POST successful).' : 'Error saving feedback.';
}
$rows = $conn->query('SELECT id, name, rating, comment, created_at FROM feedback ORDER BY id DESC');
?>
<!DOCTYPE html>
<html lang="en"><head><meta charset="utf-8"><title>Feedback</title>
<style>
body{font-family:Arial,sans-serif;padding:30px;max-width:700px;margin:auto}
input,select,textarea,button{width:100%;padding:8px;margin:6px 0;box-sizing:border-box}
table{border-collapse:collapse;width:100%;margin-top:20px}
td,th{border:1px solid #ccc;padding:6px;text-align:left}
</style></head><body>
<h2>Course Feedback Form</h2>
<p><?= htmlspecialchars($msg) ?></p>
<form method="post">
  <input name="name" placeholder="Your name" required>
  <select name="rating"><option value="5">5 - Excellent</option><option value="4">4</option><option value="3">3</option><option value="2">2</option><option value="1">1</option></select>
  <textarea name="comment" placeholder="Comment" required></textarea>
  <button type="submit">Submit</button>
</form>
<h3>Stored feedback (retrieved from CAT2.feedback)</h3>
<table><tr><th>ID</th><th>Name</th><th>Rating</th><th>Comment</th><th>Date</th></tr>
<?php while ($r = $rows->fetch_assoc()): ?>
<tr><td><?= $r['id'] ?></td><td><?= htmlspecialchars($r['name']) ?></td><td><?= $r['rating'] ?></td><td><?= htmlspecialchars($r['comment']) ?></td><td><?= $r['created_at'] ?></td></tr>
<?php endwhile; ?>
</table>
<p><a href="dashboard.php">Back</a></p>
</body></html>
