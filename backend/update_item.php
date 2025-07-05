<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';
$item = null;

// Fetch subcategories from DB
$subcategories = $conn->query("SELECT * FROM item_subcategory");

// Get item code from URL
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $stmt = $conn->prepare("SELECT * FROM item WHERE item_code = ?");
    $stmt->bind_param("s", $code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $item = $result->fetch_assoc();
    } else {
        $message = "❌ Item not found.";
        $messageType = "error";
    }
} else {
    $message = "❗ No item code provided.";
    $messageType = "error";
}

// Update logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $code = $_POST['item_code'];
    $name = $_POST['item_name'];
    $category = $_POST['item_category'];
    $subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    if (!empty($code) && !empty($name) && !empty($category) && !empty($subcategory) && !empty($quantity) && !empty($unit_price)) {
        $stmt = $conn->prepare("UPDATE item SET item_name = ?, item_category = ?, item_subcategory = ?, quantity = ?, unit_price = ? WHERE item_code = ?");
        $stmt->bind_param("sssids", $name, $category, $subcategory, $quantity, $unit_price, $code);

        if ($stmt->execute()) {
            $message = "✅ Item updated successfully!";
            $messageType = "success";

            // Reload item
            $stmt = $conn->prepare("SELECT * FROM item WHERE item_code = ?");
            $stmt->bind_param("s", $code);
            $stmt->execute();
            $item = $stmt->get_result()->fetch_assoc();
        } else {
            $message = "❌ Update failed: " . $conn->error;
            $messageType = "error";
        }
    } else {
        $message = "❗ All fields are required.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Item</title>
    <link rel="stylesheet" href="../frontend/update_item.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="container">
        <h2>Update Item Details</h2>

        <?php if ($message): ?>
            <div class="message <?= $messageType; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <?php if ($item): ?>
        <form method="POST" class="update-form">
            <div class="form-row">
                <label class="required">🆔 Item Code</label>
                <input type="text" name="item_code" readonly value="<?= htmlspecialchars($item['item_code']) ?>">
            </div>

            <div class="form-row">
                <label class="required">📦 Item Name</label>
                <input type="text" name="item_name" required value="<?= htmlspecialchars($item['item_name']) ?>">
            </div>

            <div class="form-row">
                <label class="required">📁 Category ID</label>
                <input type="text" name="item_category" required value="<?= htmlspecialchars($item['item_category']) ?>">
            </div>

            <div class="form-row">
                <label class="required">📂 Subcategory</label>
                <select name="item_subcategory" required>
                    <option value="">Select Subcategory</option>
                    <?php while ($sub = $subcategories->fetch_assoc()): ?>
                        <option value="<?= $sub['id'] ?>" <?= $item['item_subcategory'] == $sub['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($sub['sub_category']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-row">
                <label class="required">🔢 Quantity</label>
                <input type="number" name="quantity" required min="1" value="<?= $item['quantity'] ?>">
            </div>

            <div class="form-row">
                <label class="required">💰 Unit Price</label>
                <input type="number" name="unit_price" step="0.01" required min="0" value="<?= $item['unit_price'] ?>">
            </div>

            <div class="form-row full-width">
                <button type="submit" name="update" class="btn-update">Update Item</button>
            </div>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
