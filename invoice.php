<?php
session_start();
include('db_connection.php');
include('header.php');

// Assuming you have the booking_id passed as a query parameter
$bookingId = $_GET['booking_id'] ?? null;

// Fetch booking details based on the provided booking_id
if ($bookingId) {
    $fetchBookingQuery = "SELECT * FROM bookings WHERE booking_id = '$bookingId'";
    $bookingResult = mysqli_query($conn, $fetchBookingQuery);

    if ($bookingResult && mysqli_num_rows($bookingResult) > 0) {
        $booking = mysqli_fetch_assoc($bookingResult);
    } else {
        echo "Error fetching booking details: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Invalid booking ID";
    exit();
}
?>

<script>
    function printInvoice(el) {
                var restorepage = document.body.innerHTML;
                var printcontent = document.getElementById(el).innerHTML;
                document.body.innerHTML = printcontent;
                window.print();
                document.body.innerHTML = restorepage;
            }
</script>

   
<!-- Your Invoice page content goes here -->
<div class="content-wrapper" id="print-invoice">
<style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin-bottom: 20px;
        }

        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .invoice-table th,
        .invoice-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .invoice-total {
            text-align: right;
        }

        .invoice-footer {
            text-align: center;
        }
    </style>
<div class="invoice">
        <div class="invoice-header">
            <h2>Invoice</h2>
            <p>Hotel Copy</p>
        </div>

        <div class="invoice-details">
            <p><strong>Booking ID:</strong> <?php echo $booking['booking_id']; ?></p>
            <p><strong>Customer Name:</strong> <?php echo $booking['guest_name']; ?></p>
            <p><strong>Check-in Date:</strong> <?php echo $booking['checkin_date']; ?></p>
            <p><strong>Check-out Date:</strong> <?php echo $booking['checkout_date']; ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Room</td>
                    <td><?php echo 'Room ' . $booking['room_number']; ?></td>
                    <td>$<?php echo $booking['total_amount']; ?></td>
                </tr>
                <!-- Add additional items or details as needed -->
            </tbody>
        </table>

        <div class="invoice-total">
            <p><strong>Total Amount:</strong> $<?php echo $booking['total_amount']; ?></p>
            <p><strong>Paid Amount:</strong> $<?php echo $booking['paid_amount']; ?></p>
            <p><strong>Unpaid Amount:</strong> $<?php echo $booking['total_amount'] - $booking['paid_amount']; ?></p>
        </div>

       
    </div>
    <div class="invoice">
        <div class="invoice-header">
            <h2>Invoice</h2>
            <p>Guest Copy</p>
        </div>

        <div class="invoice-details">
            <p><strong>Booking ID:</strong> <?php echo $booking['booking_id']; ?></p>
            <p><strong>Customer Name:</strong> <?php echo $booking['guest_name']; ?></p>
            <p><strong>Check-in Date:</strong> <?php echo $booking['checkin_date']; ?></p>
            <p><strong>Check-out Date:</strong> <?php echo $booking['checkout_date']; ?></p>
        </div>

        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Room</td>
                    <td><?php echo 'Room ' . $booking['room_number']; ?></td>
                    <td>$<?php echo $booking['total_amount']; ?></td>
                </tr>
                <!-- Add additional items or details as needed -->
            </tbody>
        </table>

        <div class="invoice-total">
            <p><strong>Total Amount:</strong> $<?php echo $booking['total_amount']; ?></p>
            <p><strong>Paid Amount:</strong> $<?php echo $booking['paid_amount']; ?></p>
            <p><strong>Unpaid Amount:</strong> $<?php echo $booking['total_amount'] - $booking['paid_amount']; ?></p>
        </div>

        <div class="invoice-footer">
            <p>Thank you for choosing our hotel!</p>
        </div>
    </div>
</div>
<!-- /.content-wrapper -->

    
    <div class="text-center">
                <button class="btn btn-primary" onclick="printInvoice('print-invoice')">Print</button>
            </div>
    <?php
include('footer.php');
?>