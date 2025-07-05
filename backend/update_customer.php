<?php
include 'db_connect.php';
include 'header.php';

$message = '';
$messageType = '';

if (!isset($_GET['id'])) {
    die("Invalid request. Customer ID missing.");
}

$id = intval($_GET['id']);

// Fetch customer data
$result = $conn->query("SELECT * FROM customer WHERE id = $id");

if ($result->num_rows !== 1) {
    die("Customer not found.");
}

$customer = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $district = $_POST['district'];

    if (!empty($title) && !empty($first_name) && !empty($last_name) && !empty($contact) && !empty($district)) {
        $stmt = $conn->prepare("UPDATE customer SET title=?, first_name=?, middle_name=?, last_name=?, contact_no=?, district=? WHERE id=?");
        $stmt->bind_param("ssssssi", $title, $first_name, $middle_name, $last_name, $contact, $district, $id);

        if ($stmt->execute()) {
            $message = "Customer updated successfully!";
            $messageType = "success";

            // Refresh the customer variable
            $result = $conn->query("SELECT * FROM customer WHERE id = $id");
            $customer = $result->fetch_assoc();
        } else {
            $message = "Error: " . $conn->error;
            $messageType = "error";
        }
    } else {
        $message = "All required fields must be filled.";
        $messageType = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Customer</title>
    <link rel="stylesheet" href="../frontend/update_customer.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
<div class="container">
    <h2>Update Customer</h2>

    <?php if ($message): ?>
        <div class="message <?php echo $messageType; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST">
        <div class="form-row">
            <label for="title" class="required">👤 Title</label>
            <select name="title" id="title" required>
                <option value="">Select Title</option>
                <?php
                $titles = ['Mr', 'Mrs', 'Miss', 'Dr'];
                foreach ($titles as $t) {
                    $selected = $customer['title'] == $t ? 'selected' : '';
                    echo "<option value='$t' $selected>$t</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row">
            <label for="first_name" class="required">✏️ First Name</label>
            <input type="text" name="first_name" id="first_name" value="<?= htmlspecialchars($customer['first_name']) ?>" required>
        </div>

        <div class="form-row">
            <label for="middle_name">✏️ Middle Name</label>
            <input type="text" name="middle_name" id="middle_name" value="<?= htmlspecialchars($customer['middle_name']) ?>">
        </div>

        <div class="form-row">
            <label for="last_name" class="required">✏️ Last Name</label>
            <input type="text" name="last_name" id="last_name" value="<?= htmlspecialchars($customer['last_name']) ?>" required>
        </div>

        <div class="form-row">
            <label for="contact" class="required">📞 Contact Number</label>
            <input type="text" name="contact" id="contact" maxlength="10" value="<?= htmlspecialchars($customer['contact_no']) ?>" required>
        </div>

        <div class="form-row">
            <label for="district" class="required">📍 District</label>
            <select name="district" id="district" required>
                <option value="">Select District</option>
                <?php
                $districts = $conn->query("SELECT * FROM district WHERE active='yes'");
                while ($row = $districts->fetch_assoc()) {
                    $selected = $customer['district'] == $row['district'] ? 'selected' : '';
                    echo "<option value='{$row['district']}' $selected>{$row['district']}</option>";
                }
                ?>
            </select>
        </div>

        <div class="form-row full-width">
            <button type="submit" name="update" class="btn-update">Update Customer</button>
        </div>
    </form>
</div>
</body>
</html>
