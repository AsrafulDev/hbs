<?php
session_start();
include('db_connection.php');

$pageTitle = "Add Room";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle form submission and room addition here
    $roomNumber = $_POST['room_number'];
    $roomType = $_POST['room_type'];
    $roomPricePerDay = $_POST['room_price_per_day'];
    $roomStatus = $_POST['room_status']; // Assuming a dropdown with options "booked" and "unbooked"

    // Validate input (add more validation as needed)

    // Insert room details into the database
    $insertRoomQuery = "INSERT INTO rooms (room_number, room_type, room_price_per_day, room_status)
                        VALUES ('$roomNumber', '$roomType', '$roomPricePerDay', '$roomStatus')";

    if (mysqli_query($conn, $insertRoomQuery)) {
        // Room added successfully, redirect to room management page
        header('Location: hotel_room_management.php');
        exit();
    } else {
        $error = 'Error adding room: ' . mysqli_error($conn);
        // Handle the error (display an error message, redirect, etc.)
    }
}

// Include header
include('header.php');
?>

<!-- Your Add Room page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add Room
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <form action="add_room.php" method="post">
                            <div class="form-group">
                                <label for="room_number">Room Number:</label>
                                <input type="text" class="form-control" id="room_number" name="room_number" required>
                            </div>

                            <div class="form-group">
                                <label for="room_type">Room Type:</label>
                                <input type="text" class="form-control" id="room_type" name="room_type" required>
                            </div>

                            <div class="form-group">
                                <label for="room_price_per_day">Room Price per Day:</label>
                                <input type="number" class="form-control" id="room_price_per_day" name="room_price_per_day" required>
                            </div>

                            <div class="form-group">
                                <label for="room_status">Room Status:</label>
                                <select class="form-control" id="room_status" name="room_status" required>
                                    <option value="booked">Booked</option>
                                    <option value="unbooked">Unbooked</option>
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">Add Room</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
// Include footer
include('footer.php');
?>
