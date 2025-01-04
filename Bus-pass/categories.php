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

// Delete record logic
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    // Delete the category and all related pass types
    $sql = "DELETE FROM bus_categories WHERE id = $delete_id";
    if ($conn->query($sql) === TRUE) {
        echo "Record deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
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
    <title>Categories</title>
    <style>
        body {
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            margin-top: 80px; /* Added gap between the top navigation and body content */
        }

        /* Table Styles */
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #4682B4;
            color: white;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        td {
            color: #333;
        }

        .action-btn {
            padding: 8px 15px;
            margin: 5px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
        }

        .edit-btn {
            background-color: #4CAF50;
            color: white;
        }

        .remove-btn {
            background-color: #f44336;
            color: white;
        }

        .add-category-form {
            margin: 20px 0;
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .add-category-form button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-category-form button:hover {
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

    </style>
</head>

<body>
    <div class="nav-container">
        <a href="categories.php">Categories</a>
        <a href="admin_confirm.php">Pass Request</a>
    </div>

    <h1 style="text-align: center; color: #ffff;">Bus Categories</h1>

    <!-- Add Category Form -->
    <div class="add-category-form">
        <a href="add_category.php" style="padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">+ Add Category</a>
    </div>

    <!-- Table to display bus categories and pass types -->
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
                    echo "<td>
                            <a href='edit_category.php?id=" . $category['id'] . "' class='action-btn edit-btn'>Edit</a> 
                            <a href='categories.php?delete_id=" . $category['id'] . "' class='action-btn remove-btn'>Remove</a>
                          </td>";
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
