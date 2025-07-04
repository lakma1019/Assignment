<?php
include 'db_connect.php';

// Handle form submission
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $contact = $_POST['contact'];
    $district = $_POST['district'];

    if (!empty($title) && !empty($first_name) && !empty($last_name) && !empty($contact) && !empty($district)) {
        $stmt = $conn->prepare("INSERT INTO customer (title, first_name, middle_name, last_name, contact_no, district) VALUES (?, ?, '', ?, ?, ?)");
        $stmt->bind_param("sssss", $title, $first_name, $last_name, $contact, $district);
        if ($stmt->execute()) {
            $message = "Customer registered successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "All fields are required.";
    }
}

// Fetch customers
$customers = $conn->query("SELECT * FROM customer");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Registration</title>
    <link rel="stylesheet" href="../frontend/css/customer.css">
</head>
<body>
    <div class="container">
        <h2>Customer Registration</h2>
        <?php if ($message) echo "<p class='message'>$message</p>"; ?>
        <form method="POST" onsubmit="return validateForm()">
            <label for="title">Title:</label>
            <select name="title" id="title" required>
                <option value="">Select</option>
                <option value="Mr">Mr</option>
                <option value="Mrs">Mrs</option>
                <option value="Miss">Miss</option>
                <option value="Dr">Dr</option>
            </select>

            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" id="first_name" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" id="last_name" required>

            <label for="contact">Contact Number:</label>
            <input type="text" name="contact" id="contact" required maxlength="10">

            <label for="district">District:</label>
            <select name="district" id="district" required>
                <option value="">Select District</option>
                <?php
                $districts = $conn->query("SELECT * FROM district WHERE active='yes'");
                while ($row = $districts->fetch_assoc()) {
                    echo "<option value='{$row['district']}'>{$row['district']}</option>";
                }
                ?>
            </select>

            <button type="submit">Register</button>
        </form>

        <h3>Registered Customers</h3>
        <table>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Name</th>
                <th>Contact</th>
                <th>District</th>
            </tr>
            <?php
            while ($row = $customers->fetch_assoc()) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['title']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td>{$row['contact_no']}</td>
                        <td>{$row['district']}</td>
                    </tr>";
            }
            ?>
        </table>
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
    </script>
</body>
</html>
