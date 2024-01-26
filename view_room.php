<?php
session_start();
include('db_connection.php');
include('header.php');

// Assuming you have the room_number passed as a query parameter
$roomNumber = $_GET['room_number'] ?? null;

// Fetch room details based on the provided room_number
if ($roomNumber) {
    $fetchRoomQuery = "SELECT * FROM rooms WHERE room_number = '$roomNumber'";
    $roomResult = mysqli_query($conn, $fetchRoomQuery);

    if ($roomResult && mysqli_num_rows($roomResult) > 0) {
        $room = mysqli_fetch_assoc($roomResult);
    } else {
        echo "Error fetching room details: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid room number";
    exit();
}
?>

<!-- Your View Room page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Room
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Room details -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Room Number: <?php echo $room['room_number']; ?></h4>
                        <p><strong>Room Type:</strong> <?php echo $room['room_type']; ?></p>
                        <p><strong>Room Price per Day:</strong> $<?php echo $room['room_price_per_day']; ?></p>
                        <p><strong>Status:</strong> <?php echo ($room['room_status'] == 'booked') ? 'Booked' : 'Unbooked'; ?></p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Back button -->
        <a href="hotel_room_management.php" class="btn btn-default">Back to Room Management</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
