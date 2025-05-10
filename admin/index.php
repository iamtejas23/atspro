<?php
// admin.php
include '../db.php'; // Include the database connection file

$result = $mysqli->query("SELECT * FROM resumes ORDER BY score DESC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>ATS Resume Admin Panel</title>
  <style>
    body { font-family: Arial; padding: 20px; background: #f4f4f4; }
    table { border-collapse: collapse; width: 100%; background: #fff; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background-color: #222; color: white; }
    h2 { margin-bottom: 20px; }
  </style>
</head>
<body>

<h2>Submitted Resumes</h2>

<table>
  <tr>
    <th>ID</th>
    <th>Name</th>
    <th>Email</th>
    <th>Phone</th>
    <th>Score</th>
    <th>Uploaded At</th>
  </tr>

  <?php while($row = $result->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($row['id']) ?></td>
      <td><?= htmlspecialchars($row['name']) ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?= htmlspecialchars($row['phone']) ?></td>
      <td><?= htmlspecialchars($row['score']) ?>%</td>
      <td><?= htmlspecialchars($row['uploaded_at']) ?></td>
    </tr>
  <?php endwhile; ?>

</table>

</body>
</html>
