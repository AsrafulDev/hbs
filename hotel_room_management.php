<?php
session_start();
include('db_connection.php');
include('header.php');

// Fetch all rooms
$fetchRoomsQuery = "SELECT * FROM rooms";
$roomsResult = mysqli_query($conn, $fetchRoomsQuery);
?>

<!-- Your Room Management page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Room Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Room list table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Room Number</th>
                    <th>Room Type</th>
                    <th>Room Price per Day</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($room = mysqli_fetch_assoc($roomsResult)) : ?>
                    <tr>
                        <td><?php echo $room['room_number']; ?></td>
                        <td><?php echo $room['room_type']; ?></td>
                        <td>$<?php echo $room['room_price_per_day']; ?></td>
                        <td><?php echo ($room['room_status'] == 'booked') ? 'Booked' : 'Unbooked'; ?></td>
                        <td>
                            <!-- View button -->
                            <a href="view_room.php?room_number=<?php echo $room['room_number']; ?>" class="btn btn-info btn-sm">View</a>
                            <!-- Edit button -->
                            <a href="edit_room.php?room_number=<?php echo $room['room_number']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Delete button -->
                            <a href="delete_room.php?room_number=<?php echo $room['room_number']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this room?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
