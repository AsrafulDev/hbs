<?php
session_start();
include('db_connection.php');
include('header.php');

// Assuming you have the package_id passed as a query parameter
$packageId = $_GET['package_id'] ?? null;

// Fetch package details based on the provided package_id
if ($packageId) {
    $fetchPackageQuery = "SELECT * FROM booking_packages WHERE package_id = '$packageId'";
    $packageResult = mysqli_query($conn, $fetchPackageQuery);

    if ($packageResult && mysqli_num_rows($packageResult) > 0) {
        $package = mysqli_fetch_assoc($packageResult);
    } else {
        echo "Error fetching package details: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid package ID";
    exit();
}

// Handle the deletion of the package
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $deletePackageQuery = "DELETE FROM booking_packages WHERE package_id = '$packageId'";
    $deleteResult = mysqli_query($conn, $deletePackageQuery);

    if ($deleteResult) {
        echo '<div class="alert alert-success">Package deleted successfully</div>';
        // Redirect to the package management page after deletion
        header("Location: booking_package.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error deleting package: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Delete Package page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Delete Package
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Package details for confirmation -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Are you sure you want to delete the following package?</h4>
                        <p><strong>Package ID:</strong> <?php echo $package['package_id']; ?></p>
                        <p><strong>Package Name:</strong> <?php echo $package['package_name']; ?></p>
                        <p><strong>Price:</strong> $<?php echo $package['price']; ?></p>
                        <p><strong>Details:</strong> <?php echo $package['details']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete confirmation form -->
        <form method="post" action="">
            <p class="text-danger">This action is irreversible. Deleting this package will permanently remove it from the system.</p>
            <!-- Delete button -->
            <button type="submit" class="btn btn-danger">Delete Package</button>
        </form>

        <!-- Back button -->
        <a href="booking_package.php" class="btn btn-default">Back to Package Management</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
