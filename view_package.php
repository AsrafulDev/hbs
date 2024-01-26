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
?>

<!-- Your View Package page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            View Package
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Package details -->
        <div class="row">
            <div class="col-md-6">
                <div class="box box-primary">
                    <div class="box-body">
                        <h4>Package ID: <?php echo $package['package_id']; ?></h4>
                        <p><strong>Package Name:</strong> <?php echo $package['package_name']; ?></p>
                        <p><strong>Price:</strong> $<?php echo $package['price']; ?></p>
                        <p><strong>Details:</strong> <?php echo $package['details']; ?></p>
                        <p><strong>Created At:</strong> <?php echo $package['created_at']; ?></p>
                        <p><strong>Updated At:</strong> <?php echo $package['updated_at']; ?></p>
                        <!-- Add more details as needed -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Back button -->
        <a href="booking_package.php" class="btn btn-default">Back to Package Management</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
