<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_management";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch category name and pass types
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : '';
$category_name = '';
$pass_types = ["Weekly", "Monthly", "Yearly"];

if (!empty($category_id)) {
    $sql = "SELECT category_name FROM bus_categories WHERE id = $category_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $category_name = $result->fetch_assoc()['category_name'];
    }
}

// Function to generate a unique pass number
function generatePassNumber($conn, $category_id) {
    $prefix = "Bus{$category_id}pass";
    $sql = "SELECT COUNT(*) as total FROM bus_pass_applications";
    $result = $conn->query($sql);
    $count = ($result && $result->num_rows > 0) ? $result->fetch_assoc()['total'] : 0;
    $unique_number = str_pad($count + 1, 2, '0', STR_PAD_LEFT);
    return $prefix . $unique_number;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $contact_number = $_POST['contact_number'];
    $email = $_POST['email'];
    $identity_type = $_POST['identity_type'];
    $identity_number = $_POST['identity_number'];
    $source = $_POST['source'];
    $destination = $_POST['destination'];
    $pass_type = $_POST['pass_type'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $cost = $_POST['cost'];
    $profile_image = $_FILES['profile_image']['name'];
    $passnum = generatePassNumber($conn, $category_id);

    // Handle image upload
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    $target_file = $target_dir . basename($profile_image);
    move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file);

    // Insert into database
    $sql = "INSERT INTO bus_pass_applications (full_name, profile_image, contact_number, email, identity_type, identity_number, category_name, source, destination, pass_type, start_date, end_date, cost, passnum)
            VALUES ('$full_name', '$profile_image', '$contact_number', '$email', '$identity_type', '$identity_number', '$category_name', '$source', '$destination', '$pass_type', '$start_date', '$end_date', '$cost', '$passnum')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Your pass application has been successfully received! Your Pass Number: $passnum');</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pass Booking</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/admin.jpg') no-repeat center center fixed;
            background-size: cover;
            margin-top: 80px;
        }
        form {
            margin: auto;
            width: 80%;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007BFF;
            color: white;
            cursor: pointer;
        }
        .nav-container {
            width: 100%;
            padding: 10px 0;
            position: fixed;
            top: 0;
            display: flex;
            justify-content: center;
            gap: 110px;
            z-index: 1000;
        }
        .nav-container a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px 20px;
            border-radius: 20px;
            transition: background-color 0.3s, color 0.3s;
        }
        .nav-container a:hover {
            background-color: white;
            color: #ff4500;
        }
    </style>
    <script>
        function updateCost() {
            var passType = document.getElementById('pass_type').value;
            var costField = document.getElementById('cost');
            var cost = 0;

            if (passType == "Weekly") {
                cost = 600;
            } else if (passType == "Monthly") {
                cost = 1500;
            } else if (passType == "Yearly") {
                cost = 7500;
            }

            costField.value = cost;

            // Automatically set end date based on pass type and start date
            var startDate = new Date(document.getElementById('start_date').value);
            var endDate = new Date(startDate);

            if (passType === "Weekly") {
                endDate.setDate(startDate.getDate() + 7);
            } else if (passType === "Monthly") {
                endDate.setMonth(startDate.getMonth() + 1);
            } else if (passType === "Yearly") {
                endDate.setFullYear(startDate.getFullYear() + 1);
            }

            document.getElementById('end_date').value = endDate.toISOString().split('T')[0];
        }
    </script>
</head>
<body>

    <div class="nav-container">
        <a href="pass_type.php">Pass Type</a>
        <a href="submission2.php">Manage pass</a>
        <a href="user_status.php">Pass Status</a>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <h2>Pass Booking</h2>
        <!-- Form fields -->
        <div class="form-group">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" required>
        </div>
        <div class="form-group">
            <label for="profile_image">Profile Image:</label>
            <input type="file" id="profile_image" name="profile_image" required>
        </div>
        <div class="form-group">
            <label for="contact_number">Contact Number:</label>
            <input type="text" id="contact_number" name="contact_number" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="identity_type">Identity Type:</label>
            <select id="identity_type" name="identity_type" required>
                <option value="Voter ID">Voter ID</option>
                <option value="PAN Card">PAN Card</option>
                <option value="Aadhar Card">Aadhar Card</option>
                <option value="Driving License">Driving License</option>
                <option value="Passport">Passport</option>
            </select>
        </div>
        <div class="form-group">
            <label for="identity_number">Identity Number:</label>
            <input type="text" id="identity_number" name="identity_number" required>
        </div>
        <div class="form-group">
            <label for="source">Source:</label>
            <input type="text" id="source" name="source" required>
        </div>
        <div class="form-group">
            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>
        </div>
        <div class="form-group">
            <label for="pass_type">Pass Type:</label>
            <select id="pass_type" name="pass_type" onchange="updateCost()" required>
                <?php foreach ($pass_types as $type) {
                    echo "<option value='$type'>$type</option>";
                } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required onchange="updateCost()">
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" readonly required>
        </div>
        <div class="form-group">
            <label for="cost">Cost:</label>
            <input type="number" id="cost" name="cost" readonly required>
        </div>
        <button type="submit">Apply</button>
    </form>
</body>
</html>
