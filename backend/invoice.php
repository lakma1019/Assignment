<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';

// Get next invoice number
$invoice_no = 1001;

$result = mysqli_query($conn, "SELECT MAX(CAST(invoice_no AS UNSIGNED)) as max_inv FROM invoice");
if ($result) {
    $row = mysqli_fetch_assoc($result);
    if ($row['max_inv'] !== null) {
        $invoice_no = intval($row['max_inv']) + 1;
    }
}

$current_time = date('H:i:s');
$current_date = date('Y-m-d');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $invoice_no = $_POST['invoice_no'];
    $customer = $_POST['customer'];
    $item_code = $_POST['item_code'];
    $item_count = $_POST['item_count'];
    $amount = $_POST['amount'];

    $time = date('H:i:s');
    $date = date('Y-m-d');

    $query = "INSERT INTO invoice (date, time, invoice_no, customer, item_count, amount) 
              VALUES ('$date', '$time', '$invoice_no', '$customer', '$item_count', '$amount')";

    if (mysqli_query($conn, $query)) {
        $message = "Invoice placed successfully!";
        $messageType = "success";
        $invoice_no++;
    } else {
        $message = "Error placing invoice: " . mysqli_error($conn);
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Place an Order</title>
    <link rel="stylesheet" href="../frontend/header.css">
    <link rel="stylesheet" href="../frontend/invoice.css">
</head>
<body>
<div class="container">
    <h1>Place an Order</h1>

    <?php if ($message): ?>
        <p class="<?= htmlspecialchars($messageType) ?>"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" action="">
        <label for="invoice_no">Invoice No:</label>
        <input type="number" id="invoice_no" name="invoice_no" value="<?= $invoice_no ?>" readonly>

        <label for="customer">Customer ID:</label>
        <input type="number" id="customer" name="customer" required min="1">

        <label for="item_code">Item Code:</label>
        <input type="text" id="item_code" name="item_code" required placeholder="e.g. JK007">

        <label for="item_count">Item Count:</label>
        <input type="number" id="item_count" name="item_count" value="1" required min="1">

        <label for="amount">Amount (Rs):</label>
        <input type="number" id="amount" name="amount" required min="0" step="0.01">

        <label for="time">Time:</label>
        <input type="text" id="time" name="time" value="<?= $current_time ?>" readonly>

        <button type="submit">Place Order</button>
    </form>

    <a href="report_invoice.php"><button class="show-btn">Show Invoices</button></a>
</div>

<script>
// Update time every second
function updateTime() {
    const now = new Date();
    const timeStr = now.toTimeString().split(' ')[0];
    document.getElementById('time').value = timeStr;
}
updateTime();
setInterval(updateTime, 1000);
</script>
</body>
</html>
