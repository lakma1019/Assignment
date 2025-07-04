<?php
include 'db_connect.php';
include 'header.php'; 


$message = '';
$messageType = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $district = $_POST['district'];

    if (!empty($title) && !empty($first_name) && !empty($last_name) && !empty($contact) && !empty($district)) {
        $stmt = $conn->prepare("INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $title, $first_name, $middle_name, $last_name, $contact, $district);
        if ($stmt->execute()) {
            $message = "Customer registered successfully!";
            $messageType = "success";
        } else {
            $message = "Error: " . $conn->error;
            $messageType = "error";
        }
    } else {
        $message = "All required fields must be filled.";
        $messageType = "error";
    }
}

$customers = $conn->query("SELECT * FROM customer");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="../frontend/customer.css">
    <link rel="stylesheet" href="../frontend/header.css">
</head>
<body>
    <div class="container">
        <h2>Customer Registration</h2>
        <p class="subtitle">Join our community today</p>

        <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()">
            <div class="form-row">
                <label for="title" class="required">👤 Title</label>
                <select name="title" id="title" required>
                    <option value="">Select Title</option>
                    <option value="Mr">Mr</option>
                    <option value="Mrs">Mrs</option>
                    <option value="Miss">Miss</option>
                    <option value="Dr">Dr</option>
                </select>
            </div>

            <div class="form-row">
                <label for="first_name" class="required">✏️ First Name</label>
                <input type="text" name="first_name" id="first_name" required placeholder="Enter your first name">
            </div>

            <div class="form-row">
                <label for="middle_name">✏️ Middle Name</label>
                <input type="text" name="middle_name" id="middle_name" placeholder="Enter your middle name (optional)">
            </div>

            <div class="form-row">
                <label for="last_name" class="required">✏️ Last Name</label>
                <input type="text" name="last_name" id="last_name" required placeholder="Enter your last name">
            </div>

            <div class="form-row">
                <label for="contact" class="required">📞 Contact Number</label>
                <input type="text" name="contact" id="contact" required maxlength="10" placeholder="Enter 10-digit contact number">
            </div>

            <div class="form-row">
                <label for="district" class="required">📍 District</label>
                <select name="district" id="district" required>
                    <option value="">Select District</option>
                    <?php
                    $districts = $conn->query("SELECT * FROM district WHERE active='yes'");
                    while ($row = $districts->fetch_assoc()) {
                        echo "<option value='{$row['district']}'>{$row['district']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-row full-width">
                <button type="submit" name="register" class="btn-primary">Register Customer</button>
            </div>
        </form>

        <button onclick="toggleTable()" class="btn-secondary">📊 Show Registered Customers</button>

        <div id="customerTable" style="display: none;">
            <h3>Registered Customers</h3>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>First Name</th>
                        <th>Middle Name</th>
                        <th>Last Name</th>
                        <th>Contact</th>
                        <th>District</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $customers->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['title'] ?></td>
                            <td><?= $row['first_name'] ?></td>
                            <td><?= $row['middle_name'] ?></td>
                            <td><?= $row['last_name'] ?></td>
                            <td><?= $row['contact_no'] ?></td>
                            <td><?= $row['district'] ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function validateForm() {
            const contact = document.getElementById('contact').value;
            if (!/^[0-9]{10}$/.test(contact)) {
                alert("Contact number must be exactly 10 digits.");
                return false;
            }
            return true;
        }

        function toggleTable() {
            const table = document.getElementById("customerTable");
            const btn = document.querySelector(".btn-secondary");
            if (table.style.display === "none" || table.style.display === "") {
                table.style.display = "block";
                btn.textContent = "📊 Hide Registered Customers";
            } else {
                table.style.display = "none";
                btn.textContent = "📊 Show Registered Customers";
            }
        }
    </script>
</body>
</html>
