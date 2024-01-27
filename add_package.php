<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');
include('header.php');

// Handle form submission for adding a new package
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $packageName = $_POST['package_name'];
    $price = $_POST['price'];
    $details = $_POST['details'];

    // Validate and insert the new package into the database
    $addPackageQuery = "INSERT INTO booking_packages (package_name, price, details) VALUES ('$packageName', '$price', '$details')";
    $addResult = mysqli_query($conn, $addPackageQuery);

    if ($addResult) {
        echo '<div class="alert alert-success">New package added successfully</div>';
        // Redirect to the package management page after adding
        header("Location: booking_package.php");
        exit();
    } else {
        echo '<div class="alert alert-danger">Error adding package: ' . mysqli_error($conn) . '</div>';
    }
}
?>

<!-- Your Add Package page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Add New Package
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
                                <input type="text" class="form-control" id="package_name" name="package_name" required>
                            </div>
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="text" class="form-control" id="price" name="price" required>
                            </div>
                            <div class="form-group">
                                <label for="details">Details:</label>
                                <textarea class="form-control" id="details" name="details" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add button -->
            <button type="submit" class="btn btn-success">Add Package</button>
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
