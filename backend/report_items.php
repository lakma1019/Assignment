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
                inv.invoice_no,
                inv.date,
                c.first_name,
                c.last_name,
                i.item_name,
                i.item_code,
                cat.category AS item_category,
                im.unit_price
            FROM invoice_master im
            JOIN invoice inv ON im.invoice_no = inv.invoice_no
            JOIN customer c ON inv.customer = c.id
            JOIN item i ON im.item_id = i.id
            JOIN item_category cat ON i.item_category = cat.id
            WHERE inv.date BETWEEN ? AND ?
            ORDER BY inv.date ASC
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
    <title>Item Report</title>
    <link rel="stylesheet" href="../frontend/report_items.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="report-container">
        <h1>📦 Item Report</h1>
        <p class="subtitle">Search by invoice date range</p>

        <form method="POST" class="filter-form">
            <label for="from_date">From:</label>
            <input type="date" name="from_date" id="from_date" required>

            <label for="to_date">To:</label>
            <input type="date" name="to_date" id="to_date" required>

            <button type="submit" class="btn-search">Search</button>
        </form>

        <?php if (!empty($results) && $results->num_rows > 0): ?>
            <div class="table-section">
                <h3>Invoice Item Details</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>Item</th>
                            <th>Category</th>
                            <th>Unit Price (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['invoice_no'] ?></td>
                                <td><?= $row['date'] ?></td>
                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                <td><?= $row['item_name'] . ' (' . $row['item_code'] . ')' ?></td>
                                <td><?= $row['item_category'] ?></td>
                                <td><?= number_format($row['unit_price'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <p class="no-results">No item data found in this date range.</p>
        <?php endif; ?>
    </div>
</body>
</html>
