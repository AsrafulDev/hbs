<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');
include('header.php');

// Fetch all bookings
$fetchBookingsQuery = "SELECT * FROM bookings";
$bookingsResult = mysqli_query($conn, $fetchBookingsQuery);
?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Booking List
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Booking list table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Room Number</th>
                    <th>Check-in Date</th>
                    <th>Check-out Date</th>
                    <th>Guest Name</th>
                    <th>Total Amount</th>
                    <th>Paid Amount</th>
                    <th>Unpaid Amount</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($booking = mysqli_fetch_assoc($bookingsResult)) : ?>
                    <tr>
                        <td><?php echo $booking['booking_id']; ?></td>
                        <td><?php echo $booking['room_number']; ?></td>
                        <td><?php echo $booking['checkin_date']; ?></td>
                        <td><?php echo $booking['checkout_date']; ?></td>
                        <td><?php echo $booking['guest_name']; ?></td>
                        <td>$<?php echo $booking['total_amount']; ?></td>
                        
                        <td>$<?php echo $booking['paid_amount']; ?></td>
                        <td>$<?php echo $booking['total_amount'] - $booking['paid_amount']; ?></td>
                        <td>
                            <!-- View button -->
                            <a href="view_booking.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-info btn-sm">View</a>
                            <a href="invoice.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-info btn-sm">Invoice</a>
                            <!-- Edit button -->
                            <a href="edit_booking.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Delete button -->
                            <a href="delete_booking.php?booking_id=<?php echo $booking['booking_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this booking?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- /.content -->


<?php
include('footer.php');
?>
