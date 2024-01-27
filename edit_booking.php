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

// Handle form submission for updating booking details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkinDate = $_POST['checkin_date'];
    $checkoutDate = $_POST['checkout_date'];
    $guestName = $_POST['guest_name'];
    $roomNumber = $_POST['room_number'];

    // Validate and update the booking details in the database
    $updateBookingQuery = "UPDATE bookings SET checkin_date = '$checkinDate', checkout_date = '$checkoutDate', guest_name = '$guestName', room_number = '$roomNumber' WHERE booking_id = '$bookingId'";
    $updateResult = mysqli_query($conn, $updateBookingQuery);

    if ($updateResult) {
        echo '<div class="alert alert-success">Booking details updated successfully</div>';
        // Redirect to the view booking page after updating
        echo'  <a href="booking_list.php" class="btn btn-default">Back to Booking List</a>';
       // header("Location: view_booking.php?booking_id=$bookingId");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error updating booking details: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Edit Booking page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Booking
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Booking details form -->
        <form method="post" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="checkin_date">Check-in Date:</label>
                                <input type="date" class="form-control" id="checkin_date" name="checkin_date" value="<?php echo $booking['checkin_date']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="checkout_date">Check-out Date:</label>
                                <input type="date" class="form-control" id="checkout_date" name="checkout_date" value="<?php echo $booking['checkout_date']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="guest_name">Guest Name:</label>
                                <input type="text" class="form-control" id="guest_name" name="guest_name" value="<?php echo $booking['guest_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="room_number">Room Number:</label>
                                <input type="text" class="form-control" id="room_number" name="room_number" value="<?php echo $booking['room_number']; ?>" required>
                            </div>
                            <div class="form-group">
                            <label for="total_amount">Total Amount:</label>
                            <input type="text" name="total_amount" value="<?php echo $booking['total_amount']; ?>" disabled>
                            </div>
                            <div class="form-group">
                            <label for="paid_amount">Paid Amount:</label>
                            <input type="number" name="paid_amount" value="<?php echo $booking['paid_amount']; ?>" required>
                            </div>
                            <label for="total_amount">Unpaid Amount:</label>
                            <input type="text" name="total_amount" value="<?php echo $booking['unpaid_amount']; ?>" disabled>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update button -->
            <button type="submit" class="btn btn-primary">Update Booking</button>
        </form>

        <!-- Back button -->
        <a href="view_booking.php?booking_id=<?php echo $bookingId; ?>" class="btn btn-default">Back to View Booking</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
