<?php
session_start();

// Initialize or reset data
if (!isset($_SESSION['available_seats'])) {
    $_SESSION['available_seats'] = 40;
    $_SESSION['selected_seats'] = [];
    $_SESSION['total_price'] = 0;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['select_seat'])) {
    $seat = $_POST['select_seat'];
    if (!in_array($seat, $_SESSION['selected_seats'])) {
        $_SESSION['selected_seats'][] = $seat;
        $_SESSION['available_seats'] -= 1;
        $_SESSION['total_price'] += 500; // Assuming 500 Tk per seat
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div>
        <h2>Available seat</h2>
        <h2 id="available-seat"><?= $_SESSION['available_seats'] ?></h2>
    </div>
    <form method="POST">
        <div class="seating-grid">
            <?php
            $rows = range('A', 'J');
            foreach ($rows as $row) {
                echo '<div class="row">';
                echo '<span class="row-label">' . $row . '</span>';
                for ($i = 1; $i <= 4; $i++) {
                    if ($i === 3) echo '<div class="aisle"></div>';
                    $seat = $row . $i;
                    $disabled = in_array($seat, $_SESSION['selected_seats']) ? 'disabled' : '';
                    echo '<button name="select_seat" value="' . $seat . '" class="seat" ' . $disabled . '>' . $seat . '</button>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <section class="total">
            <h1>Seat Booking</h1>
            <p id="booked-seat"><?= count($_SESSION['selected_seats']) ?></p>
            <p id="seat-select">
                <?= empty($_SESSION['selected_seats']) ? 'No Seat Booking' : implode(', ', $_SESSION['selected_seats']) ?>
            </p>
            <span>Total Price:</span><span id="total-price"><?= $_SESSION['total_price'] ?> Tk</span><br>
            <button name="reset" value="1">Reset</button>
        </section>
    </form>
</body>
</html>
