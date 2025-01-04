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

// Fetch data with status
$sql = "SELECT id, full_name, email, cost, status FROM bus_pass_applications WHERE status IS NOT NULL";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Status</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: url('images/admin.jpg') no-repeat center center fixed;
            background-size: cover;

        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
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
        .payment-btn {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }
        .payment-btn:hover {
            background-color: #218838;
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

    <h2>User Status</h2>
    <table>
        <thead>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Cost</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['full_name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['cost']}</td>
                            <td>{$row['status']}</td>
                            <td>";
                    if ($row['status'] === 'Accepted') {
                        echo "<a href='pay2.html?id={$row['id']}' class='payment-btn'>Make Payment</a>";
                    }
                    echo "</td></tr>";
                }
            } else {
                echo "<tr><td colspan='5'>No applications found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
