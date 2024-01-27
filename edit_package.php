<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
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

// Handle form submission for updating package details
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $packageName = $_POST['package_name'];
    $price = $_POST['price'];
    $details = $_POST['details'];

    // Validate and update the package details in the database
    $updatePackageQuery = "UPDATE booking_packages SET package_name = '$packageName', price = '$price', details = '$details' WHERE package_id = '$packageId'";
    $updateResult = mysqli_query($conn, $updatePackageQuery);

    if ($updateResult) {
        echo '<div class="alert alert-success">Package details updated successfully</div>';
        // Redirect to the view package page after updating
        header("Location: view_package.php?package_id=$packageId");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error updating package details: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Edit Package page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Edit Package
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Package details form -->
        <form method="post" action="">
            <div class="row">
                <div class="col-md-6">
                    <div class="box box-primary">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="package_name">Package Name:</label>
                                <input type="text" class="form-control" id="package_name" name="package_name" value="<?php echo $package['package_name']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="price" name="price" value="<?php echo $package['price']; ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="details">Details:</label>
                                <textarea class="form-control" id="details" name="details" rows="4"><?php echo $package['details']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Update button -->
            <button type="submit" class="btn btn-primary">Update Package</button>
        </form>

        <!-- Back button -->
        <a href="view_package.php?package_id=<?php echo $packageId; ?>" class="btn btn-default">Back to View Package</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
