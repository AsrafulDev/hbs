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

// Handle form submission for updating room details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomType = $_POST['room_type'];
    $roomPricePerDay = $_POST['room_price_per_day'];
    $status = $_POST['status'];

    // Validate and update the room details in the database
    $updateRoomQuery = "UPDATE rooms SET room_type = '$roomType', room_price_per_day = '$roomPricePerDay', room_status = '$status' WHERE room_number = '$roomNumber'";
    $updateResult = mysqli_query($conn, $updateRoomQuery);

    if ($updateResult) {
        echo '<div class="alert alert-success">Room details updated successfully</div>';
        // Redirect to the view room page after updating
        header("Location: view_room.php?room_number=$roomNumber");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error updating room details: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Edit Room page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Room
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Room details form -->
        <form method="post" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="room_type">Room Type:</label>
                                <input type="text" class="form-control" id="room_type" name="room_type" value="<?php echo $room['room_type']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="room_price_per_day">Room Price per Day:</label>
                                <input type="text" class="form-control" id="room_price_per_day" name="room_price_per_day" value="<?php echo $room['room_price_per_day']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="booked" <?php echo ($room['room_status'] == 'booked') ? 'selected' : ''; ?>>Booked</option>
                                    <option value="unbooked" <?php echo ($room['room_status'] == 'unbooked') ? 'selected' : ''; ?>>Unbooked</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update button -->
            <button type="submit" class="btn btn-primary">Update Room</button>
        </form>

        <!-- Back button -->
        <a href="view_room.php?room_number=<?php echo $roomNumber; ?>" class="btn btn-default">Back to View Room</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
