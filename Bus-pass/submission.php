<?php
// Start the session
session_start();

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

// Fetch all records
$sql = "SELECT * FROM bus_pass_applications";
$result = $conn->query($sql);

// Check if the user is logged in
$user_logged_in = isset($_SESSION['username']) ? $_SESSION['username'] : null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Applications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        h2 {
            text-align: center;
            color: #007BFF;
            font-size: 2rem;
            margin-top: 80px;
            margin-bottom: 10px;
        }

        table {
            margin: auto;
            width: 80%;
            background: #fff;
            border-collapse: collapse;
            border-radius: 8px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        table:hover {
            transform: scale(1.02);
        }

        table th, table td {
            text-align: left;
            padding: 12px;
            border-bottom: 1px solid #ddd;
            font-size: 1rem;
            transition: background-color 0.3s ease;
        }

        table th {
            background-color: black;
            color: white;
        }

        table td {
            background-color: #f8f8f8;
        }

        table tr:hover td {
            background-color: #e1f5fe;
        }

        .action-btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .edit-btn {
            background-color: #4CAF50;
        }

        .view-btn {
            background-color: #007BFF;
        }

        .action-btn:hover {
            opacity: 0.8;
        }

        .action-btn:active {
            transform: scale(0.98);
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

<h2>Submitted Applications</h2>
<table>
    <tr>
        <th>S. No</th>
        <th>Full Name</th>
        <th>Email</th>
        <th>Contact</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['full_name']; ?></td>
        <td><?php echo $row['email']; ?></td>
        <td><?php echo $row['contact_number']; ?></td>
        <td>
            <a href="edit_pass.php?id=<?php echo $row['id']; ?>" class="action-btn edit-btn">Edit</a>
            <a href="view_pass.php?id=<?php echo $row['id']; ?>" class="action-btn view-btn">View</a>
        </td>
    </tr>
    <?php } ?>
</table>

</body>
</html>

<?php
$conn->close();
?>
