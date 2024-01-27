<?php
session_start();
include('db_connection.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
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
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Summary Details</h3>
                    </div>
                    
                </div>
            </div>
        </div>   
                <!-- Booking Summary Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Booking Summary</h3>
            </div>
            <div class="card-body">
                <canvas id="bookingChart" style="height: 230px; max-height: 230px;"></canvas>
            </div>
        </div>
        <!-- Unpaid Summary Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Unpaid Summary</h3>
            </div>
            <div class="card-body">
                <canvas id="unpaidChart" style="height: 230px; max-height: 230px;"></canvas>
            </div>
        </div>

        <!-- Income Summary Chart -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Income Summary</h3>
            </div>
            <div class="card-body">
                <canvas id="incomeChart" style="height: 230px; max-height: 230px;"></canvas>
            </div>
        </div>

    </section>
    <!-- /.content -->


    <script>
    function fetchBookingSummary() {
        $.ajax({
            url: 'fetch_booking_summary.php', // Replace with your server-side script to fetch booking summary data
            method: 'GET',
            success: function (data) {
                updateBookingChart(data);
            },
            error: function (error) {
                console.error('Error fetching booking summary:', error);
            }
        });
    }

    function fetchIncomeSummary() {
        $.ajax({
            url: 'fetch_income_summary.php', // Replace with your server-side script to fetch income summary data
            method: 'GET',
            success: function (data) {
                updateIncomeChart(data);
            },
            error: function (error) {
                console.error('Error fetching income summary:', error);
            }
        });
    }
    function fetchUnpaidSummary() {
        $.ajax({
            url: 'fetch_unpaid_summary.php', // Replace with your server-side script to fetch unpaid summary data
            method: 'GET',
            success: function (data) {
                updateUnpaidChart(data);
            },
            error: function (error) {
                console.error('Error fetching unpaid summary:', error);
            }
        });
    }
    function updateBookingChart(data) {
        // Parse data and update the booking chart
        var parsedData = JSON.parse(data);
        bookingChart.data.datasets[0].data = parsedData;
        bookingChart.update();
    }

    function updateIncomeChart(data) {
        // Parse data and update the income chart
        var parsedData = JSON.parse(data);
        incomeChart.data.datasets[0].data = parsedData;
        incomeChart.update();
    }

    
    function updateUnpaidChart(data) {
        // Parse data and update the unpaid chart
        var parsedData = JSON.parse(data);
        unpaidChart.data.datasets[0].data = parsedData;
        unpaidChart.update();
    }

    document.addEventListener("DOMContentLoaded", function () {
        fetchBookingSummary();
        fetchIncomeSummary();
        fetchUnpaidSummary(); // Added this line to fetch unpaid summary
    });

    setInterval(function () {
        fetchBookingSummary();
        fetchIncomeSummary();
        fetchUnpaidSummary(); // Added this line to fetch unpaid summary
    }, 300000); // 5 minutes

    
 
    // Example: Bar chart for unpaid summary
    var unpaidChartCtx = document.getElementById('unpaidChart').getContext('2d');
    var unpaidChart = new Chart(unpaidChartCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Unpaid Summary',
                backgroundColor: 'rgba(255, 206, 86, 0.2)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1,
                data: [500, 300, 600, 400, 700, 550, 350] // Default example data
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });


    // Example: Bar chart for booking summary
    var bookingChartCtx = document.getElementById('bookingChart').getContext('2d');
    var bookingChart = new Chart(bookingChartCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Booking Summary',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1,
                data: [65, 59, 80, 81, 56, 55, 40]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Example: Bar chart for income summary
    var incomeChartCtx = document.getElementById('incomeChart').getContext('2d');
    var incomeChart = new Chart(incomeChartCtx, {
        type: 'bar',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [{
                label: 'Income Summary',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1,
                data: [1500, 1200, 2000, 1800, 2500, 2200, 1700]
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<?php
// Include footer
include('footer.php');
?>
