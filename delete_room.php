<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
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

// Handle the deletion of the room
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deleteRoomQuery = "DELETE FROM rooms WHERE room_number = '$roomNumber'";
    $deleteResult = mysqli_query($conn, $deleteRoomQuery);

    if ($deleteResult) {
        echo '<div class="alert alert-success">Room deleted successfully</div>';
        // Redirect to the room management page after deletion
        header("Location: hotel_room_management.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting room: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Delete Room page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Delete Room
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Room details for confirmation -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Are you sure you want to delete the following room?</h4>
                        <p><strong>Room Number:</strong> <?php echo $room['room_number']; ?></p>
                        <p><strong>Room Type:</strong> <?php echo $room['room_type']; ?></p>
                        <p><strong>Room Price per Day:</strong> $<?php echo $room['room_price_per_day']; ?></p>
                        <p><strong>Status:</strong> <?php echo ($room['room_status'] == 'booked') ? 'Booked' : 'Unbooked'; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation form -->
        <form method="post" action="">
            <p class="text-danger">This action is irreversible. Deleting this room will permanently remove it from the system.</p>
            <!-- Delete button -->
            <button type="submit" class="btn btn-danger">Delete Room</button>
        </form>

        <!-- Back button -->
        <a href="hotel_room_management.php" class="btn btn-default">Back to Room Management</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
