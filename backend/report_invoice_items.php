<?php
include 'db_connect.php';
include 'header.php';

$results = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $from_date = $_POST['from_date'];
    $to_date = $_POST['to_date'];

    if (!empty($from_date) && !empty($to_date)) {
        $query = "
            SELECT 
                i.item_name,
                cat.category AS item_category,
                sub.sub_category AS item_subcategory,
                SUM(im.quantity) AS total_quantity
            FROM invoice_master im
            JOIN item i ON im.item_id = i.id
            JOIN invoice inv ON im.invoice_no = inv.invoice_no
            JOIN item_category cat ON i.item_category = cat.id
            JOIN item_subcategory sub ON i.item_subcategory = sub.id
            WHERE inv.date BETWEEN ? AND ?
            GROUP BY i.item_name, item_category, item_subcategory
            ORDER BY i.item_name ASC
        ";

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ss", $from_date, $to_date);
        $stmt->execute();
        $results = $stmt->get_result();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Item Invoices Report</title>
    <link rel="stylesheet" href="../frontend/report_invoice_items.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="report-container">
        <h1>🧾 Item Invoices Report</h1>
        <p class="subtitle">Aggregated by item (no repetition)</p>

        <form method="POST" class="filter-form">
            <label for="from_date">From:</label>
            <input type="date" name="from_date" id="from_date" required>

            <label for="to_date">To:</label>
            <input type="date" name="to_date" id="to_date" required>

            <button type="submit" class="btn-search">Search</button>
        </form>

        <?php if (!empty($results) && $results->num_rows > 0): ?>
            <div class="table-section">
                <h3>Invoice Summary by Item</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Total Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['item_name']) ?></td>
                                <td><?= htmlspecialchars($row['item_category']) ?></td>
                                <td><?= htmlspecialchars($row['item_subcategory']) ?></td>
                                <td><?= htmlspecialchars($row['total_quantity']) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <p class="no-results">No item invoices found in this date range.</p>
        <?php endif; ?>
    </div>
</body>
</html>
