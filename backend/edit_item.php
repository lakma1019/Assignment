<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';
$items = [];

// Handle delete request
if (isset($_GET['delete_code'])) {
    $delete_code = $_GET['delete_code'];
    $stmt = $conn->prepare("DELETE FROM item WHERE item_code = ?");
    $stmt->bind_param("s", $delete_code);
    if ($stmt->execute()) {
        $message = "✅ Item with code '$delete_code' deleted successfully.";
        $messageType = "success";
    } else {
        $message = "❌ Failed to delete item.";
        $messageType = "error";
    }
}

// Handle search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_text = trim($_POST['search_text']);
    if (!empty($search_text)) {
        $stmt = $conn->prepare("SELECT * FROM item WHERE item_code = ? OR item_name LIKE ?");
        $likeText = "%" . $search_text . "%";
        $stmt->bind_param("ss", $search_text, $likeText);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $items[] = $row;
        }

        if (count($items) == 0) {
            $message = "❌ No items found matching: $search_text";
            $messageType = "error";
        }
    } else {
        $message = "❗ Please enter item code or name.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Items</title>
    <link rel="stylesheet" href="../frontend/edit_item.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="container">
        <h2>Edit or Delete Items</h2>

        <?php if ($message): ?>
            <div class="message <?= $messageType; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <!-- Search form -->
        <form method="POST" class="search-form">
            <label for="search_text" class="required">🔍 Enter Item Code or Name</label>
            <input type="text" name="search_text" id="search_text" required placeholder="E.g. ITM001 or Printer" value="<?= isset($search_text) ? htmlspecialchars($search_text) : '' ?>">
            <button type="submit" name="search" class="btn-search">Search</button>
        </form>

        <?php if (!empty($items)): ?>
            <div class="item-table">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category ID</th>
                            <th>Subcategory ID</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['item_code']); ?></td>
                                <td><?= htmlspecialchars($item['item_name']); ?></td>
                                <td><?= $item['item_category']; ?></td>
                                <td><?= $item['item_subcategory']; ?></td>
                                <td><?= $item['quantity']; ?></td>
                                <td><?= $item['unit_price']; ?></td>
                                <td>
                                    <a href="update_item.php?code=<?= urlencode($item['item_code']); ?>" class="btn-edit-link">Edit</a>
                                    <a href="edit_item.php?delete_code=<?= urlencode($item['item_code']); ?>" class="btn-delete-link" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
