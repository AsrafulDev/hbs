<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');

$pageTitle = "Edit Booking Package";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['package_id'])) {
    $packageId = $_GET['package_id'];

    // Fetch booking package details from the database
    $fetchPackageQuery = "SELECT * FROM booking_packages WHERE package_id = $packageId";
    $packageResult = mysqli_query($conn, $fetchPackageQuery);

    if ($package = mysqli_fetch_assoc($packageResult)) {
        // Package details found
        // Include header
        include('header.php');
?>

        <!-- Your Edit Booking Package page content goes here -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Edit Booking Package
                </h1>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="box box-primary">
                            <div class="box-body">
                                <form action="update_booking_package.php" method="post">
                                    <!-- Include hidden input for package_id -->
                                    <input type="hidden" name="package_id" value="<?php echo $packageId; ?>">

                                    <div class="form-group">
                                        <label for="package_name">Package Name:</label>
                                        <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo $package['package_name']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="package_description">Package Description:</label>
                                        <textarea class="form-control" id="package_description" name="package_description" rows="3" required><?php echo $package['package_description']; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="package_price">Package Price:</label>
                                        <input type="number" class="form-control" id="package_price" name="package_price" value="<?php echo $package['package_price']; ?>" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update Booking Package</button>
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
    } else {
        // Package not found, redirect to booking package management page or display an error message
        header('Location: booking_package_management.php');
        exit();
    }
} else {
    // Invalid request, redirect to booking package management page or display an error message
    header('Location: booking_package_management.php');
    exit();
}

mysqli_close($conn);
?>
