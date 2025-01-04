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

// Fetch specific record based on ID
$id = $_GET['id'];
$sql = "SELECT * FROM bus_pass_applications WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$data = $result->fetch_assoc();

if (!$data) {
    die("Record not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Application and QR Code Generator</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/admin2.jpg') no-repeat center center fixed;
            background-size: cover;
            padding: 20px;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .container {
            max-width: 800px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
            padding: 20px;
            margin-top: 90px; /* Space from the nav-container */
            text-align: center;
        }
        h2 {
            text-align: center;
            color: #007BFF;
        }
        .details {
            text-align: left;
            margin-top: 20px;
        }
        .details p {
            font-size: 1rem;
            margin: 10px 0;
        }
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }
        input[type="text"] {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background-color: #0056b3;
        }
        #qrText {
            width: 90%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        #imgBox {
            margin: 20px 0;
            width: 250px;
            border-radius: 5px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 1s ease-out;
        }
        #imgBox img {
            width: 100%;
            padding: 10px;
        }
        #imgBox.show-img {
            max-height: 350px;
            margin: 15px auto;
            border: 1px solid #d1d1d1;
        }
        .nav-container {
            width: 100%;
            padding: 10px 0;
            position: fixed;
            top: 0;
            display: flex;
            justify-content: center;
            gap: 40px; /* Space between buttons */
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

<div class="container">
    <h2>Application Details</h2>
    <div class="details">
        <p><strong>Full Name:</strong> <?php echo htmlspecialchars($data['full_name']); ?></p>
        <p><strong>Contact Number:</strong> <?php echo htmlspecialchars($data['contact_number']); ?></p>
        <p><strong>Email:</strong> <?php echo htmlspecialchars($data['email']); ?></p>
        <p><strong>Source:</strong> <?php echo htmlspecialchars($data['source']); ?></p>
        <p><strong>Destination:</strong> <?php echo htmlspecialchars($data['destination']); ?></p>
        <p><strong>Pass Type:</strong> <?php echo htmlspecialchars($data['pass_type']); ?></p>
        <p><strong>End Date:</strong> <?php echo htmlspecialchars($data['end_date']); ?></p>
    </div>
    <div class="button-container">
        <button onclick="generateURL()">Generate URL</button>
        <input type="text" id="generatedURL" readonly>
        <button onclick="copyURL()">Copy</button>
    </div>
</div>

<div class="container">
    <h2>QR Code Generator</h2>
    <p style="font-size: 18px; font-weight: bold;">Enter your URL</p>
    <input type="text" placeholder="Text or URL" id="qrText">
    <div id="imgBox">
        <img src="" id="qrimage" alt="QR Code will appear here">
    </div>
    <button onclick="GenerateQR()">Generate QR Code</button>
</div>

<script>
    function generateURL() {
        const source = "<?php echo urlencode($data['source']); ?>";
        const destination = "<?php echo urlencode($data['destination']); ?>";
        const endDate = "<?php echo urlencode($data['end_date']); ?>";

        const url = `https://example.com/details?source=${source}&destination=${destination}&end_date=${endDate}`;
        document.getElementById("generatedURL").value = url;
    }

    function copyURL() {
        const urlField = document.getElementById("generatedURL");
        urlField.select();
        urlField.setSelectionRange(0, 99999); // For mobile devices
        document.execCommand("copy");
        alert("URL copied to clipboard!");
    }

    let imgBox = document.getElementById("imgBox");
    let qrimage = document.getElementById("qrimage");
    let qrText = document.getElementById("qrText");

    function GenerateQR() {
        if (qrText.value.trim() === "") {
            alert("Please enter a valid text or URL!");
            return;
        }
        qrimage.src = "https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=" + encodeURIComponent(qrText.value);
        qrimage.alt = "QR Code";
        imgBox.classList.add("show-img");
    }
</script>

</body>
</html>
<?php $conn->close(); ?>
