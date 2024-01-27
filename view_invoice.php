<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');
include('header.php');

// Fetch booking details based on the provided booking_id
if (isset($_GET['booking_id'])) {
    $bookingId = $_GET['booking_id'];
    $fetchBookingQuery = "SELECT * FROM bookings WHERE booking_id = $bookingId";
    $bookingResult = mysqli_query($conn, $fetchBookingQuery);

    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $booking = mysqli_fetch_assoc($bookingResult);
    } else {
        // Handle the case where the booking ID is invalid or doesn't exist
        echo "Invalid Booking ID. Please go back to the Booking List.";
    }
} else {
    // Handle the case where the booking ID is not provided
    echo "Booking ID not provided. Please go back to the Booking List.";
}
?>

<!-- Your View Invoice page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Invoice for Booking ID <?php echo $booking['booking_id']; ?>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Your detailed invoice content goes here -->
        <p>Room Number: <?php echo $booking['room_number']; ?></p>
        <p>Check-in Date: <?php echo $booking['checkin_date']; ?></p>
        <p>Check-out Date: <?php echo $booking['checkout_date']; ?></p>
        <p>Guest Name: <?php echo $booking['guest_name']; ?></p>
        <p>Total Amount: <?php echo $booking['total_amount']; ?></p>
        <!-- Add more details as needed -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
