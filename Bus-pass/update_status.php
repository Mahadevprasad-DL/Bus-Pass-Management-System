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

// Update status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $action = $_POST['action'];

    $sql = "UPDATE bus_pass_applications SET status='$action' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        header("Location: admin_confirm.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$conn->close();
?>
