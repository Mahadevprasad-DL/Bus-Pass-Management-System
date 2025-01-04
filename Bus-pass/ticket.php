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

$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = rand(100000, 999999); // Generate random ticket ID
    $username = $conn->real_escape_string($_POST['username']);
    $source = $conn->real_escape_string($_POST['source']);
    $destination = $conn->real_escape_string($_POST['destination']);
    $time_date = $conn->real_escape_string($_POST['time_date']);
    $num_seats = (int) $_POST['num_seats'];
    $phone = $conn->real_escape_string($_POST['phone']);
    $price = (float) $_POST['price'];
    $bus_number = $conn->real_escape_string($_POST['bus_number']);

    if ($source === $destination) {
        $message = "Your source and destination are the same.";
    } else {
        $sql = "INSERT INTO tickets (ticket_id, username, source, destination, time_date, num_seats, price, phone, bus_number) 
                VALUES ('$ticket_id', '$username', '$source', '$destination', '$time_date', '$num_seats', '$price', '$phone', '$bus_number')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to pay2.html with ticket ID
            header("Location: pay2.html?id=$ticket_id");
            exit(); // Ensure no further code is executed after the redirect
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket</title>
    <style>
        /* Include your previous styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('images/home.jpg'); /* Replace with your image path */
            background-size: cover;
            background-position: center;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
            width: 400px;
        }

        .form-container h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container select,
        .form-container input[type="text"],
        .form-container input[type="number"],
        .form-container input[type="datetime-local"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            outline: none;
        }

        .form-container input[type="submit"] {
            background-color: #1e90ff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }

        .form-container input[type="submit"]:hover {
            background-color: #4682b4;
        }

        .message {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            color: yellow;
        }
    </style>
    <script>
        const prices = {
            "Mysuru-Bengaluru": { price: 250, bus: "KA01AB1234" },
            "Bengaluru-Mysuru": { price: 250, bus: "KA01AB1234" },
            "Bagalkot-Mysuru": { price: 1400, bus: "KA02XY5678" },
            "Mysuru-Bagalkot": { price: 1400, bus: "KA02XY5678" },
            "Hubli-Mysuru": { price: 1200, bus: "KA03PQ9012" },
            "Mysuru-Hubli": { price: 1200, bus: "KA03PQ9012" },
            "Bengaluru-Hubli": { price: 800, bus: "KA04LM3456" },
            "Hubli-Bengaluru": { price: 800, bus: "KA04LM3456" },
            "Bagalkot-Bengaluru": { price: 1000, bus: "KA05GH7890" },
            "Bengaluru-Bagalkot": { price: 1000, bus: "KA05GH7890" }
        };

        function calculatePrice() {
            const source = document.getElementById("source").value;
            const destination = document.getElementById("destination").value;
            const numSeats = document.getElementById("num_seats").value;
            const priceField = document.getElementById("price");
            const busField = document.getElementById("bus_number");

            if (source && destination && source !== destination) {
                const route = `${source}-${destination}`;
                const routeInfo = prices[route];
                if (routeInfo) {
                    priceField.value = (routeInfo.price * numSeats).toFixed(2);
                    busField.value = routeInfo.bus;
                } else {
                    priceField.value = "";
                    busField.value = "";
                }
            } else if (source === destination) {
                alert("Your source and destination are the same.");
                priceField.value = "";
                busField.value = "";
            }
        }
    </script>
</head>
<body>
    <div class="form-container">
        <h1>Book Your Ticket</h1>
        <?php if (!empty($message)): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="ticket_id">Ticket ID</label>
            <input type="text" id="ticket_id" name="ticket_id" value="<?php echo rand(100000, 999999); ?>" readonly>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" required>

            <label for="source">Source</label>
            <select id="source" name="source" onchange="calculatePrice()" required>
                <option value="">Select Source</option>
                <option value="Mysuru">Mysuru</option>
                <option value="Bengaluru">Bengaluru</option>
                <option value="Bagalkot">Bagalkot</option>
                <option value="Hubli">Hubli</option>
                <option value="Dharwad">Dharwad</option>
            </select>

            <label for="destination">Destination</label>
            <select id="destination" name="destination" onchange="calculatePrice()" required>
                <option value="">Select Destination</option>
                <option value="Mysuru">Mysuru</option>
                <option value="Bengaluru">Bengaluru</option>
                <option value="Bagalkot">Bagalkot</option>
                <option value="Hubli">Hubli</option>
                <option value="Dharwad">Dharwad</option>
            </select>

            <label for="time_date">Time and Date</label>
            <input type="datetime-local" id="time_date" name="time_date" required>

            <label for="num_seats">Number of Seats</label>
            <input type="number" id="num_seats" name="num_seats" onchange="calculatePrice()" required>

            <label for="price">Price</label>
            <input type="text" id="price" name="price" readonly required>

            <label for="bus_number">Bus Number</label>
            <input type="text" id="bus_number" name="bus_number" readonly required>

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" required>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
