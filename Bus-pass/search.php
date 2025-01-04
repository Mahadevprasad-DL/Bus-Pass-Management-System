<?php
// Database connection
$host = "localhost";
$username = "root";
$password = "";
$dbname = "bus_management";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle search query
$search_result = [];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $passnum = $conn->real_escape_string($_POST['passnum']);

    $sql = "SELECT id AS s_no, source, destination, pass_type, start_date, end_date, cost 
            FROM bus_pass_applications 
            WHERE passnum = '$passnum'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $search_result[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Pass</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/home.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
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
            color: white;
            margin-top: 100px;
            font-size: 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .search-container {
            display: flex;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .search-container input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #ccc;
            border-radius: 4px 0 0 4px;
            outline: none;
        }

        .search-container button {
            padding: 10px 20px;
            background-color: #1e90ff;
            color: white;
            border: none;
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .search-container button:hover {
            background-color: #4682b4;
        }

        table {
            width: 80%;
            border-collapse: collapse;
            margin-top: 20px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        table, th, td {
            border: 1px solid #ccc;
        }

        th, td {
            text-align: center;
            padding: 10px;
        }

        th {
            background-color: #1e90ff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }

        p {
            margin-top: 20px;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <div class="nav-container">
        <a href="home.html">Home</a>
        <a href="about2.html">About</a>
        <a href="search.php">View Pass</a>
    </div>

    <h1>View Pass</h1>
    <form method="POST" action="" class="search-container">
        <input type="text" name="passnum" placeholder="Enter Pass Number" required>
        <button type="submit">Search</button>
    </form>

    <?php if (!empty($search_result)): ?>
        <table>
            <thead>
                <tr>
                    <th>S.No</th>
                    <th>Source</th>
                    <th>Destination</th>
                    <th>Pass Type</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Cost</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($search_result as $row): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['s_no']) ?></td>
                        <td><?= htmlspecialchars($row['source']) ?></td>
                        <td><?= htmlspecialchars($row['destination']) ?></td>
                        <td><?= htmlspecialchars($row['pass_type']) ?></td>
                        <td><?= htmlspecialchars($row['start_date']) ?></td>
                        <td><?= htmlspecialchars($row['end_date']) ?></td>
                        <td><?= htmlspecialchars($row['cost']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <p>No records found for the entered pass number.</p>
    <?php endif; ?>
</body>
</html>
