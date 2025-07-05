<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';

// Handle delete action
if (isset($_GET['delete_id'])) {
    $id = intval($_GET['delete_id']);
    if ($conn->query("DELETE FROM customer WHERE id = {$id}")) {
        $message = "Customer #{$id} deleted.";
        $messageType = "success";
    } else {
        $message = "Error deleting customer: " . $conn->error;
        $messageType = "error";
    }
}

// Handle search
$searchTerm = '';
$customers = [];
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    $searchTerm = $conn->real_escape_string(trim($_GET['q']));
    if ($searchTerm !== '') {
        $sql = "SELECT * FROM customer
                WHERE id = '{$searchTerm}'
                   OR first_name LIKE '%{$searchTerm}%'
                   OR last_name  LIKE '%{$searchTerm}%'
                   OR contact_no LIKE '%{$searchTerm}%'
                   OR district  LIKE '%{$searchTerm}%'";
        $res = $conn->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $customers[] = $row;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit / Delete Customers</title>
    <link rel="stylesheet" href="../frontend/edit_customer.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
  <div class="container">
    <h2>Edit / Delete Customers</h2>

    <?php if ($message): ?>
      <div class="message <?php echo $messageType; ?>">
        <?php echo $message; ?>
      </div>
    <?php endif; ?>

    <form method="GET" class="search-form">
      <input
        type="text"
        name="q"
        value="<?php echo htmlspecialchars($searchTerm); ?>"
        placeholder="🔍 Search by ID, name, contact or district..."
        required
      />
      <button type="submit">Search</button>
    </form>

    <?php if (!empty($customers)): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Name</th>
            <th>Contact</th>
            <th>District</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($customers as $c): ?>
          <tr>
            <td><?php echo $c['id']; ?></td>
            <td><?php echo $c['title']; ?></td>
            <td><?php echo "{$c['first_name']} {$c['middle_name']} {$c['last_name']}"; ?></td>
            <td><?php echo $c['contact_no']; ?></td>
            <td><?php echo $c['district']; ?></td>
            <td class="actions">
              <!-- ✅ Updated to point to update_customer.php -->
              <a href="update_customer.php?id=<?php echo $c['id']; ?>" class="btn-edit">✏️ Edit</a>
              
              <a href="?delete_id=<?php echo $c['id']; ?>"
                 class="btn-delete"
                 onclick="return confirm('Are you sure you want to delete this customer?');"
              >🗑️ Delete</a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php elseif ($searchTerm !== ''): ?>
      <p class="no-results">No customers found for “<?php echo htmlspecialchars($searchTerm); ?>”.</p>
    <?php endif; ?>
  </div>
</body>
</html>
