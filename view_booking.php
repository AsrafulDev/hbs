<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');
include('header.php');

// Assuming you have the booking_id passed as a query parameter
$bookingId = $_GET['booking_id'] ?? null;

// Fetch booking details based on the provided booking_id
if ($bookingId) {
    $fetchBookingQuery = "SELECT * FROM bookings WHERE booking_id = '$bookingId'";
    $bookingResult = mysqli_query($conn, $fetchBookingQuery);

    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $booking = mysqli_fetch_assoc($bookingResult);
    } else {
        echo "Error fetching booking details: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid booking ID";
    exit();
}
?>

<!-- Your View Booking page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Booking
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Booking details -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Booking ID: <?php echo $booking['booking_id']; ?></h4>
                        <p><strong>Room Number:</strong> <?php echo $booking['room_number']; ?></p>
                        <p><strong>Check-in Date:</strong> <?php echo $booking['checkin_date']; ?></p>
                        <p><strong>Check-out Date:</strong> <?php echo $booking['checkout_date']; ?></p>
                        <p><strong>Guest Name:</strong> <?php echo $booking['guest_name']; ?></p>
                        <p><strong>Total Amount:</strong> $<?php echo $booking['total_amount']; ?></p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Back button -->
        <a href="booking_list.php" class="btn btn-default">Back to Booking List</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
