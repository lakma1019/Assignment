<?php
include 'db_connect.php';
include 'header.php';

$results = [];
$from_date = '';
$to_date = '';

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
            <input type="date" name="from_date" id="from_date" required value="<?= htmlspecialchars($from_date) ?>">

            <label for="to_date">To:</label>
            <input type="date" name="to_date" id="to_date" required value="<?= htmlspecialchars($to_date) ?>">

            <button type="submit" class="btn-search">Search</button>
        </form>

        <?php if (!empty($results) && $results->num_rows > 0): ?>
            <div class="table-section" id="reportContent">
                <h3>Invoice Item Details From <?= htmlspecialchars($from_date) ?> to <?= htmlspecialchars($to_date) ?></h3>
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
                <button id="downloadBtn" class="btn-download no-print">Download PDF</button>
            </div>
        <?php elseif ($_SERVER["REQUEST_METHOD"] === "POST"): ?>
            <p class="no-results">No item data found in this date range.</p>
        <?php endif; ?>
    </div>

    <!-- PDF Export Script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        document.getElementById("downloadBtn")?.addEventListener("click", function () {
            const button = document.getElementById("downloadBtn");
            const element = document.getElementById("reportContent");

            // Hide the button before generating PDF
            button.style.display = "none";

            const opt = {
                margin: [0.5, 0.5, 0.5, 0.5],
                filename: 'item_report.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, scrollY: 0 },
                jsPDF: { unit: 'in', format: 'a4', orientation: 'portrait' }
            };

            html2pdf().set(opt).from(element).save().then(() => {
                // Restore the button after PDF is saved
                button.style.display = "inline-block";
            });
        });
    </script>
</body>
</html>
