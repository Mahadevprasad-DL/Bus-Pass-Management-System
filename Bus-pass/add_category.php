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

// Add category logic
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];
    if (!empty($category_name)) {
        // Insert category
        $sql = "INSERT INTO bus_categories (category_name) VALUES ('$category_name')";
        if ($conn->query($sql) === TRUE) {
            $category_id = $conn->insert_id; // Get the ID of the inserted category
            
            // Insert default pass types (Weekly, Monthly, Yearly)
            $pass_types = ['Weekly', 'Monthly', 'Yearly'];
            foreach ($pass_types as $pass_type) {
                $sql_pass_type = "INSERT INTO bus_pass_types (bus_category_id, pass_type) VALUES ($category_id, '$pass_type')";
                $conn->query($sql_pass_type);
            }

            echo "Category added successfully!";
            header("Location: categories.php"); // Redirect to categories page
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
            margin-top: 80px; /* Added margin-top to create a gap between the top buttons and the container */
        }
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .form-container button:hover {
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

<h1 style="text-align: center;">Add New Category</h1>

<div class="form-container">
    <form method="POST" action="">
        <input type="text" name="category_name" placeholder="Enter Category Name" required>
        <button type="submit" name="add_category">Add Category</button>
    </form>
</div>
</body>
</html>

<?php
$conn->close();
?>
