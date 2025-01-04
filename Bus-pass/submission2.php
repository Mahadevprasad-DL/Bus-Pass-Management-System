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

// Fetch data from the database
$sql = "SELECT id, full_name, passnum FROM bus_pass_applications";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submission Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/admin.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
        }
        table {
            width: 80%;
            margin: auto;
            border-collapse: collapse;
            background-color: rgba(255, 255, 255, 0.9);
            color: #333;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #007BFF;
            color: white;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
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
</head>
<body>
    <div class="nav-container">
        <a href="pass_type.php">Pass Type</a>
        <a href="user_status.php">Pass Status</a>
    </div>

    <h2>Submission Details</h2>

    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Full Name</th>
                <th>Pass Number</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $serial_number = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$serial_number}</td>";
                    echo "<td>{$row['full_name']}</td>";
                    echo "<td>{$row['passnum']}</td>";
                    echo "</tr>";
                    $serial_number++;
                }
            } else {
                echo "<tr><td colspan='3' style='text-align:center;'>No data found</td></tr>";
            }
            ?>
        </tbody>
    </table>

    <?php $conn->close(); ?>
</body>
</html>
