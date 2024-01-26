<?php
session_start();
include('db_connection.php');
include('header.php');

// Fetch all booking packages
$fetchPackagesQuery = "SELECT * FROM booking_packages";
$packagesResult = mysqli_query($conn, $fetchPackagesQuery);
?>

<!-- Your Package Management page content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Package Management
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Package list table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Package Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php while ($package = mysqli_fetch_assoc($packagesResult)) : ?>
                    <tr>
                        <td><?php echo $package['package_id']; ?></td>
                        <td><?php echo $package['package_name']; ?></td>
                        <td>$<?php echo $package['price']; ?></td>
                        <td>
                            <!-- View button -->
                            <a href="view_package.php?package_id=<?php echo $package['package_id']; ?>" class="btn btn-info btn-sm">View</a>
                            <!-- Edit button -->
                            <a href="edit_package.php?package_id=<?php echo $package['package_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <!-- Delete button -->
                            <a href="delete_package.php?package_id=<?php echo $package['package_id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this package?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Add new package button -->
        <a href="add_package.php" class="btn btn-success">Add New Package</a>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->

<?php
include('footer.php');
?>
