<?php
session_start();
include('db_connection.php');

$pageTitle = "Dashboard";

// Get total number of bookings
$totalBookingsQuery = "SELECT COUNT(*) AS total_bookings FROM bookings";
$totalBookingsResult = mysqli_query($conn, $totalBookingsQuery);
$totalBookings = mysqli_fetch_assoc($totalBookingsResult)['total_bookings'];

// Get total revenue
$totalRevenueQuery = "SELECT SUM(total_amount) AS total_revenue FROM bookings";
$totalRevenueResult = mysqli_query($conn, $totalRevenueQuery);
$totalRevenue = mysqli_fetch_assoc($totalRevenueResult)['total_revenue'];

// Get latest bookings
$latestBookingsQuery = "SELECT * FROM bookings ORDER BY checkin_date DESC LIMIT 5";
$latestBookingsResult = mysqli_query($conn, $latestBookingsQuery);
$latestBookings = [];

while ($booking = mysqli_fetch_assoc($latestBookingsResult)) {
    $latestBookings[] = $booking;
}

// Get monthly recap report
$currentMonth = date('m');
$monthlyRecapQuery = "SELECT COUNT(*) AS monthly_bookings, SUM(total_amount) AS monthly_revenue FROM bookings 
                      WHERE MONTH(checkin_date) = $currentMonth";
$monthlyRecapResult = mysqli_query($conn, $monthlyRecapQuery);
$monthlyRecap = mysqli_fetch_assoc($monthlyRecapResult);

mysqli_close($conn);

// Include header
include('header.php');
?>

<!-- Your Dashboard content goes here -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- Booking Statistics Card -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="fa fa-book"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Bookings</span>
                        <span class="info-box-number"><?php echo $totalBookings; ?></span>
                    </div>
                </div>
            </div>

            <!-- Total Revenue Card -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="fa fa-dollar-sign"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Total Revenue</span>
                        <span class="info-box-number">$<?php echo number_format($totalRevenue, 2); ?></span>
                    </div>
                </div>
            </div>

            <!-- Monthly Recap Report Card -->
            <div class="col-md-4">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="fa fa-calendar"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Monthly Recap</span>
                        <span class="info-box-number">Bookings: <?php echo $monthlyRecap['monthly_bookings']; ?></span>
                        <span class="info-box-number">Revenue: $<?php echo number_format($monthlyRecap['monthly_revenue'], 2); ?></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Latest Bookings Card -->
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Latest Bookings</h3>
                    </div>
                    <div class="box-body">
                        <ul class="list-group">
                            <?php foreach ($latestBookings as $booking) : ?>
                                <li class="list-group-item">
                                    <?php echo $booking['guest_name']; ?> -
                                    Check-in: <?php echo $booking['checkin_date']; ?>,
                                    Check-out: <?php echo $booking['checkout_date']; ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
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
