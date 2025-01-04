<?php
session_start();

// Database connection using MySQLi
$host = 'localhost';
$dbname = 'bookingseat';  // Database name
$username = 'root';  // Database username
$password = '';  // Database password

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Connection failed, show an error message but continue
    echo "Connection failed: " . $conn->connect_error;
} else {
    // Connection successful
    // echo "Connected successfully to the database."; // Optional for debugging
}

// Initialize session data
if (!isset($_SESSION['available_seats'])) {
    $_SESSION['available_seats'] = 40;
    $_SESSION['selected_seats'] = [];
    $_SESSION['total_price'] = 0;
}

$seat_price = 500; // Price per seat

if (isset($_POST['select_seat'])) {
    $seat = $_POST['select_seat'];
    if (!in_array($seat, $_SESSION['selected_seats'])) {
        $_SESSION['selected_seats'][] = $seat;
        $_SESSION['available_seats'] -= 1;
        $_SESSION['total_price'] += $seat_price;
    }
}

// Store booking in the database when finalizing the booking
if (isset($_POST['book_seats'])) {
    $ticket_quantity = count($_SESSION['selected_seats']);
    $ticket_price = $_SESSION['total_price'];  // Store total price in ticket_price column

    // Insert the data directly into the 'users' table
     $query = "INSERT INTO users (ticket_quantity, ticket_price) VALUES ($ticket_quantity, $ticket_price)";
   

    
    if ($conn->query($query) === TRUE) {
        // Reset session after booking
        $_SESSION['selected_seats'] = [];
        $_SESSION['total_price'] = 0;
        $_SESSION['available_seats'] = 40;

        echo "Booking Successful!";
    } else {
        echo 'Error while booking: ' . $conn->error;
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seating Layout</title>
</head>
<body>
    <div>
        <h2>Available Seats</h2>
        <h2><?php echo $_SESSION['available_seats']; ?></h2>
    </div>
    <form method="POST">
        <div class="seating-grid">
            <?php
            for ($i = 1; $i <= 40; $i++) {
                $disabled = '';
                if (in_array($i, $_SESSION['selected_seats'])) {
                    $disabled = 'disabled';
                }
                echo '<button name="select_seat" value="' . $i . '" class="seat" ' . $disabled . '>' . $i . '</button>';
                if ($i % 4 == 0) {
                    echo '<div class="aisle"></div>';
                }
            }
            ?>
        </div>
        <section class="total">
            <h1>Seat Booking</h1>
            <p>Booked Seats: <?php echo count($_SESSION['selected_seats']); ?></p>
            <p>Selected Seats: 
                <?php 
                if (empty($_SESSION['selected_seats'])) {
                    echo 'None';
                } else {
                    foreach ($_SESSION['selected_seats'] as $seat) {
                        echo $seat . ' ';
                    }
                }
                ?>
            </p>
            <span>Total Price:</span> <span><?php echo $_SESSION['total_price']; ?> Tk</span><br>
            <button name="book_seats" value="1">Book Seats</button>
        </section>
    </form>
</body>
</html>
