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

// Get the record to edit
$id = $_GET['id'];
$sql = "SELECT * FROM bus_pass_applications WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Record not found.";
    exit;
}

// Update the record
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

    $sql = "UPDATE bus_pass_applications 
            SET full_name = '$full_name', 
                contact_number = '$contact_number',
                email = '$email', 
                identity_type = '$identity_type', 
                identity_number = '$identity_number',
                source = '$source',
                destination = '$destination',
                pass_type = '$pass_type',
                start_date = '$start_date',
                end_date = '$end_date',
                cost = '$cost'
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Record updated successfully!'); window.location.href='pass_booking.php';</script>";
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        form {
            width: 50%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            margin-top: 100px; /* Add gap between nav and form */
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
            background-color: #4CAF50;
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
            gap: 110px; /* Space between buttons */
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
</head>

<body>

<div class="nav-container">
        <a href="categories.php">Categories</a>
        <a href="admin_confirm.php">Pass Request</a>
    </div>
    
<form method="POST">
    <h2>Edit Pass Details</h2>
    <div class="form-group">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $row['full_name']; ?>" required>
    </div>
    <div class="form-group">
        <label for="contact_number">Contact Number:</label>
        <input type="text" id="contact_number" name="contact_number" value="<?php echo $row['contact_number']; ?>" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required>
    </div>
    <div class="form-group">
        <label for="identity_type">Identity Type:</label>
        <select id="identity_type" name="identity_type" required>
            <option value="Voter ID" <?php if ($row['identity_type'] === 'Voter ID') echo 'selected'; ?>>Voter ID</option>
            <option value="PAN Card" <?php if ($row['identity_type'] === 'PAN Card') echo 'selected'; ?>>PAN Card</option>
            <option value="Aadhar Card" <?php if ($row['identity_type'] === 'Aadhar Card') echo 'selected'; ?>>Aadhar Card</option>
            <option value="Driving License" <?php if ($row['identity_type'] === 'Driving License') echo 'selected'; ?>>Driving License</option>
            <option value="Passport" <?php if ($row['identity_type'] === 'Passport') echo 'selected'; ?>>Passport</option>
        </select>
    </div>
    <div class="form-group">
        <label for="identity_number">Identity Number:</label>
        <input type="text" id="identity_number" name="identity_number" value="<?php echo $row['identity_number']; ?>" required>
    </div>
    <div class="form-group">
        <label for="source">Source:</label>
        <input type="text" id="source" name="source" value="<?php echo $row['source']; ?>" required>
    </div>
    <div class="form-group">
        <label for="destination">Destination:</label>
        <input type="text" id="destination" name="destination" value="<?php echo $row['destination']; ?>" required>
    </div>
    <div class="form-group">
        <label for="pass_type">Pass Type:</label>
        <input type="text" id="pass_type" name="pass_type" value="<?php echo $row['pass_type']; ?>" required>
    </div>
    <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" value="<?php echo $row['start_date']; ?>" required>
    </div>
    <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" value="<?php echo $row['end_date']; ?>" required>
    </div>
    <div class="form-group">
        <label for="cost">Cost:</label>
        <input type="number" id="cost" name="cost" value="<?php echo $row['cost']; ?>" required>
    </div>
    <button type="submit">Update</button>
</form>
</body>
</html>
