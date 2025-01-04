<?php
session_start();

// Initialize or reset data
if (!isset($_SESSION['available_seats'])) {
    $_SESSION['available_seats'] = 40;
    $_SESSION['selected_seats'] = [];
    $_SESSION['total_price'] = 0;
   

}

if (isset($_POST['select_seat'])) {
    $seat = $_POST['select_seat'];
    if (!in_array($seat, $_SESSION['selected_seats'])) {
        $_SESSION['selected_seats'][] = $seat;
        $_SESSION['available_seats'] -= 1;
        $_SESSION['total_price'] += 500; // Assuming 500 Tk per seat
    }
} elseif (isset($_POST['reset'])) {
    $_SESSION['available_seats'] = 40;
    $_SESSION['selected_seats'] = [];
    $_SESSION['total_price'] = 0;
}
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
                    echo '<div class="aisle"></div>'; // Add an aisle after every 4 seats
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
            <button name="reset" value="1">Reset</button>
        </section>
    </form>
</body>
</html>
