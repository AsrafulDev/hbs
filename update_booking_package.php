<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $packageId = $_POST['package_id'];
    $packageName = $_POST['package_name'];
    $packageDescription = $_POST['package_description'];
    $packagePrice = $_POST['package_price'];

    // Validate input (add more validation as needed)

    // Update booking package details in the database
    $updatePackageQuery = "UPDATE booking_packages
                           SET package_name = '$packageName',
                               package_description = '$packageDescription',
                               package_price = '$packagePrice'
                           WHERE package_id = $packageId";

    if (mysqli_query($conn, $updatePackageQuery)) {
        // Package updated successfully, redirect to booking package management page
        echo'  <a href="booking_list.php" class="btn btn-default">Back to Booking List</a>';
      
        header('Location: booking_package_management.php');
        exit();
    } else {
        $error = 'Error updating booking package: ' . mysqli_error($conn);
        // Handle the error (display an error message, redirect, etc.)
    }
} else {
    // Invalid request, redirect to booking package management page or display an error message
    header('Location: booking_package_management.php');
    exit();
}

mysqli_close($conn);
?>
