<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch categories and pass types from the database
$sql = "SELECT * FROM bus_categories";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bus Pass Types</title>
    <style>
        body {
            background: url('images/admin.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: white;
        }
        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f7f9;
        }
        .action-btn {
            padding: 5px 10px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            color: white;
            background-color: #4CAF50;
        }
        .action-btn:hover {
            background-color: #45a049;
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
        h1 {
            text-align: center;
            margin-top: 100px; /* Gap between navigation and heading */
        }
    </style>
</head>
<body>

    <div class="nav-container">
        <a href="pass_type.php">Pass Type</a>
        <a href="user_status.php">Pass Status</a>
    </div>

    <h1>Bus Pass Types</h1>

    <!-- Table to display bus categories, pass types, and apply button -->
    <table>
        <thead>
            <tr>
                <th>S.No</th>
                <th>Category Name</th>
                <th>Pass Types</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $sno = 1;
                while ($category = $result->fetch_assoc()) {
                    $category_id = $category['id'];
                    // Fetch the pass types for each category
                    $pass_types_sql = "SELECT pass_type FROM bus_pass_types WHERE bus_category_id = $category_id";
                    $pass_types_result = $conn->query($pass_types_sql);
                    $pass_types = [];
                    while ($pass_type = $pass_types_result->fetch_assoc()) {
                        $pass_types[] = $pass_type['pass_type'];
                    }
                    // Display category and pass types
                    echo "<tr>";
                    echo "<td>" . $sno++ . "</td>";
                    echo "<td>" . $category['category_name'] . "</td>";
                    echo "<td>" . implode(", ", $pass_types) . "</td>";
                    echo "<td><a href='pass_booking.php?category_id=" . $category['id'] . "&sno=" . ($sno - 1) . "' class='action-btn'>Apply</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No categories available.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
