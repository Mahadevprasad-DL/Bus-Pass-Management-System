<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bus_management";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];  // Use full_name instead of username
    $pass = $_POST['password'];

    // Update the query to search by full_name instead of username
    $sql = "SELECT * FROM users WHERE full_name='$full_name'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            header("Location: index.html");
        } else {
            echo "<p class='error'>Wrong Password!</p>";
        }
    } else {
        echo "<p class='error'>User not found!</p>";
    }
}

$conn->close();
?>
