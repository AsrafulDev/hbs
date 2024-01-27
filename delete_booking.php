<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');

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

// Handle the deletion of the booking
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deleteBookingQuery = "DELETE FROM bookings WHERE booking_id = '$bookingId'";
    $deleteResult = mysqli_query($conn, $deleteBookingQuery);

    if ($deleteResult) {
        echo '<div class="alert alert-success">Booking deleted successfully</div>';
        // Redirect to the booking list page after deletion
        header("Location: booking_list.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting booking: ' . mysqli_error($conn) . '</div>';
    }
}
  // Include header
  include('header.php');
?>

<!-- Your Delete Booking page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Delete Booking
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Booking details for confirmation -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Are you sure you want to delete the following booking?</h4>
                        <p><strong>Booking ID:</strong> <?php echo $booking['booking_id']; ?></p>
                        <p><strong>Room Number:</strong> <?php echo $booking['room_number']; ?></p>
                        <p><strong>Check-in Date:</strong> <?php echo $booking['checkin_date']; ?></p>
                        <p><strong>Check-out Date:</strong> <?php echo $booking['checkout_date']; ?></p>
                        <p><strong>Guest Name:</strong> <?php echo $booking['guest_name']; ?></p>
                        <p><strong>Total Amount:</strong> $<?php echo $booking['total_amount']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation form -->
        <form method="post" action="">
            <p class="text-danger">This action is irreversible. Deleting this booking will permanently remove it from the system.</p>
            <!-- Delete button -->
            <button type="submit" class="btn btn-danger">Delete Booking</button>
        </form>

        <!-- Back button -->
        <a href="booking_list.php" class="btn btn-default">Back to Booking List</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
