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

// Fetch category details based on ID
if (isset($_GET['id'])) {
    $category_id = $_GET['id'];
    $sql = "SELECT * FROM bus_categories WHERE id = $category_id";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
    } else {
        echo "Category not found.";
        exit();
    }
} else {
    echo "Category ID is missing.";
    exit();
}

// Update category logic
if (isset($_POST['update_category'])) {
    $new_category_name = $_POST['category_name'];
    if (!empty($new_category_name)) {
        // Update the category name
        $sql_update = "UPDATE bus_categories SET category_name = '$new_category_name' WHERE id = $category_id";
        if ($conn->query($sql_update) === TRUE) {
            echo "Category updated successfully!";
            header("Location: categories.php"); // Redirect to categories page after updating
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
    <title>Edit Category</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
            margin-top: 80px; /* Creating a gap between the nav bar and form */
        }
        .form-container {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .form-container input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
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
        .pass-types {
            margin: 10px 0;
        }
        .pass-types label {
            margin-right: 20px;
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
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="nav-container">
        <a href="categories.php">Categories</a>
        <a href="admin_confirm.php">Pass Request</a>
    </div>

    <h1>Edit Category</h1>

    <div class="form-container">
        <form method="POST" action="">
            <div>
                <label for="category_name">Category Name:</label>
                <input type="text" id="category_name" name="category_name" value="<?php echo htmlspecialchars($category['category_name']); ?>" required>
            </div>

            <div class="pass-types">
                <label>Pass Types:</label>
                <span>Weekly</span>
                <span>Monthly</span>
                <span>Yearly</span>
            </div>

            <button type="submit" name="update_category">Update Category</button>
        </form>
    </div>
</body>
</html>

<?php
$conn->close();
?>
