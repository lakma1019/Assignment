<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';

// Fetch item categories and subcategories
$categories = $conn->query("SELECT * FROM item_category");
$subcategories = $conn->query("SELECT * FROM item_subcategory");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $item_code = trim($_POST['item_code']);
    $item_name = trim($_POST['item_name']);
    $item_category = $_POST['item_category'];
    $item_subcategory = $_POST['item_subcategory'];
    $quantity = $_POST['quantity'];
    $unit_price = $_POST['unit_price'];

    // Validate form fields
    if (!empty($item_code) && !empty($item_name) && !empty($item_category) && !empty($item_subcategory) && !empty($quantity) && !empty($unit_price)) {
        $stmt = $conn->prepare("INSERT INTO item (item_code, item_category, item_subcategory, item_name, quantity, unit_price) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssis", $item_code, $item_category, $item_subcategory, $item_name, $quantity, $unit_price);

        if ($stmt->execute()) {
            $message = "✅ Item registered successfully!";
            $messageType = "success";
        } else {
            $message = "❌ Database Error: " . $conn->error;
            $messageType = "error";
        }
    } else {
        $message = "❗ All fields are required.";
        $messageType = "error";
    }
}

// Load item list for display
$items = $conn->query("SELECT i.*, 
                              c.category AS category_name, 
                              s.sub_category AS subcategory_name 
                       FROM item i
                       LEFT JOIN item_category c ON i.item_category = c.id
                       LEFT JOIN item_subcategory s ON i.item_subcategory = s.id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Registration</title>
    <link rel="stylesheet" href="../frontend/item.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="container">
        <h2>Item Registration</h2>
        <p class="subtitle">Enter new inventory items</p>

        <?php if ($message): ?>
            <div class="message <?= $messageType; ?>">
                <?= $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateItemForm()">
            <div class="form-row">
                <label class="required">🆔 Item Code</label>
                <input type="text" name="item_code" required placeholder="E.g. ITM001">
            </div>

            <div class="form-row">
                <label class="required">📦 Item Name</label>
                <input type="text" name="item_name" required placeholder="E.g. HP Laser Printer">
            </div>

            <div class="form-row">
                <label class="required">📁 Item Category</label>
                <select name="item_category" required>
                    <option value="">Select Category</option>
                    <?php while ($cat = $categories->fetch_assoc()): ?>
                        <option value="<?= $cat['id']; ?>"><?= $cat['category']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-row">
                <label class="required">📂 Item Subcategory</label>
                <select name="item_subcategory" required>
                    <option value="">Select Sub Category</option>
                    <?php while ($sub = $subcategories->fetch_assoc()): ?>
                        <option value="<?= $sub['id']; ?>"><?= $sub['sub_category']; ?></option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="form-row">
                <label class="required">🔢 Quantity</label>
                <input type="number" name="quantity" required min="1" placeholder="E.g. 10">
            </div>

            <div class="form-row">
                <label class="required">💰 Unit Price</label>
                <input type="number" name="unit_price" step="0.01" required min="0" placeholder="E.g. 2500.00">
            </div>

            <div class="form-row full-width">
                <button type="submit" name="register" class="btn-primary">Register Item</button>
            </div>
        </form>

        <button onclick="toggleItemTable()" class="btn-secondary">📊 Show Registered Items</button>

        <div id="itemTable" style="display: none;">
            <h3>Registered Items</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Subcategory</th>
                        <th>Qty</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $items->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id']; ?></td>
                            <td><?= $row['item_code']; ?></td>
                            <td><?= $row['item_name']; ?></td>
                            <td><?= $row['category_name']; ?></td>
                            <td><?= $row['subcategory_name']; ?></td>
                            <td><?= $row['quantity']; ?></td>
                            <td><?= $row['unit_price']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function validateItemForm() {
            const code = document.querySelector("input[name='item_code']").value.trim();
            const name = document.querySelector("input[name='item_name']").value.trim();
            const qty = document.querySelector("input[name='quantity']").value;
            const price = document.querySelector("input[name='unit_price']").value;

            if (!code || !name || qty <= 0 || price < 0) {
                alert("❗ Please fill all fields correctly.");
                return false;
            }
            return true;
        }

        function toggleItemTable() {
            const table = document.getElementById("itemTable");
            const btn = document.querySelector(".btn-secondary");
            if (table.style.display === "none" || table.style.display === "") {
                table.style.display = "block";
                btn.textContent = "📊 Hide Registered Items";
            } else {
                table.style.display = "none";
                btn.textContent = "📊 Show Registered Items";
            }
        }
    </script>
</body>
</html>
