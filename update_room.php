<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomId = $_POST['room_id'];
    $roomNumber = $_POST['room_number'];
    $roomType = $_POST['room_type'];
    $roomPricePerDay = $_POST['room_price_per_day'];
    $roomStatus = $_POST['room_status'];

    // Validate input (add more validation as needed)

    // Update room details in the database
    $updateRoomQuery = "UPDATE rooms
                        SET room_number = '$roomNumber',
                            room_type = '$roomType',
                            room_price_per_day = '$roomPricePerDay',
                            room_status = '$roomStatus'
                        WHERE id = $roomId";

    if (mysqli_query($conn, $updateRoomQuery)) {
        // Room updated successfully, redirect to room management page
        header('Location: hotel_room_management.php');
        exit();
    } else {
        $error = 'Error updating room: ' . mysqli_error($conn);
        // Handle the error (display an error message, redirect, etc.)
    }
} else {
    // Invalid request, redirect to room management page or display an error message
    header('Location: hotel_room_management.php');
    exit();
}

mysqli_close($conn);
?>
