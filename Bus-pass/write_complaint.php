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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $place = $_POST['place'];
    $complaint = $_POST['complaint'];

    if (strlen($complaint) <= 200) {
        $stmt = $conn->prepare("INSERT INTO complaints (full_name, email, place, complaint) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $full_name, $email, $place, $complaint);
        $stmt->execute();
        $stmt->close();
        echo "<script>alert('Complaint submitted successfully!'); window.location.href='write_complaint.php';</script>";
    } else {
        echo "<script>alert('Complaint must not exceed 200 words!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Write Complaint</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: url('images/admin.jpg') no-repeat center center fixed;
            background-size: cover;

        }
        .container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-size: 14px;
            color: #555;
        }
        input, textarea, button {
            margin-top: 5px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        textarea {
            resize: none;
        }
        button {
            margin-top: 20px;
            background: #007BFF;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
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
        <a href="pass_type.php">Pass Type</a>
        <a href="user_status.php">Pass Status</a>
    </div>

    <div class="container">
        <h2>Write a Complaint</h2>
        <form method="POST">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="place">Place</label>
            <input type="text" id="place" name="place" required>
            
            <label for="complaint">Complaint (Max 200 words)</label>
            <textarea id="complaint" name="complaint" rows="6" maxlength="200" required></textarea>
            
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
