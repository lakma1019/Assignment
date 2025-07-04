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
                i.invoice_no, i.date, c.first_name, c.last_name, c.district, i.item_count, i.amount 
            FROM invoice i
            JOIN customer c ON i.customer = c.id
            WHERE i.date BETWEEN ? AND ?
            ORDER BY i.date ASC
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
    <title>Invoice Report</title>
    <link rel="stylesheet" href="../frontend/report_invoice.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="report-container">
        <h1>🧾 Invoice Report</h1>
        <p class="subtitle">Search invoices by date range</p>

        <form method="POST" class="filter-form">
            <label for="from_date">From Date:</label>
            <input type="date" name="from_date" id="from_date" required>

            <label for="to_date">To Date:</label>
            <input type="date" name="to_date" id="to_date" required>

            <button type="submit" class="btn-search">Search</button>
        </form>

        <?php if (!empty($results) && $results->num_rows > 0): ?>
            <div class="table-section">
                <h3>Results</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Invoice No</th>
                            <th>Date</th>
                            <th>Customer</th>
                            <th>District</th>
                            <th>Item Count</th>
                            <th>Amount (Rs.)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $results->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['invoice_no'] ?></td>
                                <td><?= $row['date'] ?></td>
                                <td><?= $row['first_name'] . ' ' . $row['last_name'] ?></td>
                                <td><?= $row['district'] ?></td>
                                <td><?= $row['item_count'] ?></td>
                                <td><?= number_format($row['amount'], 2) ?></td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <p class="no-results">No invoices found in this date range.</p>
        <?php endif; ?>
    </div>
</body>
</html>
