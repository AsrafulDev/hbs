<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');
$pageTitle = "New Booking";
include('header.php');


// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $roomNumber = $_POST['room_number'];
    $checkinDate = $_POST['checkin_date'];
    $checkoutDate = $_POST['checkout_date'];
    $guestName = $_POST['guest_name'];
    $paidAmount = $_POST['paid_amount'];
    $packageId = $_POST['package_id'];

    // Get room details to calculate amounts
    $fetchRoomQuery = "SELECT * FROM rooms WHERE room_number = '$roomNumber'";
    $roomResult = mysqli_query($conn, $fetchRoomQuery);

    if ($roomResult && mysqli_num_rows($roomResult) > 0) {
        $room = mysqli_fetch_assoc($roomResult);

        // Calculate amounts
        $roomPrice = $room['room_price_per_day'];
      
        $date1 = strtotime($checkinDate);
        $date2 = strtotime($checkoutDate);
        $difference = $date2 - $date1;
        $days = floor($difference / (60 * 60 * 24));

        // If a package is selected, use the package price; otherwise, use the room price
        $totalAmount = ($packageId != 0) ? getPackagePrice($packageId) : $days * $roomPrice;

        $unpaidAmount = $totalAmount - $paidAmount;
 // Update room status to 'booked'
         $updateRoomQuery = "UPDATE rooms SET room_status = 'booked' WHERE room_number = '$roomNumber'";
         mysqli_query($conn, $updateRoomQuery);
        // Insert new booking into the database
        $insertBookingQuery = "INSERT INTO bookings (room_number, checkin_date, checkout_date, guest_name, paid_amount, unpaid_amount, total_amount, package_id)
                              VALUES ('$roomNumber', '$checkinDate', '$checkoutDate', '$guestName', '$paidAmount', '$unpaidAmount', '$totalAmount', '$packageId')";
        $result = mysqli_query($conn, $insertBookingQuery);

        
        if ($result) {
            // Redirect to the invoice page with the new booking ID
            $newBookingId = mysqli_insert_id($conn);
           echo'<a href="invoice.php?booking_id='.$newBookingId.'">Click hare to print Invoice.</a>'; 
            //header("Location: invoice.php?booking_id=$newBookingId");
            exit();
        } else {
            echo "Error adding new booking: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching room details: " . mysqli_error($conn);
    }
}

// Function to get the price of a booking package
function getPackagePrice($packageId) {
    global $conn;

    $fetchPackagePriceQuery = "SELECT price FROM booking_packages WHERE package_id = '$packageId'";
    $packagePriceResult = mysqli_query($conn, $fetchPackagePriceQuery);

    if ($packagePriceResult && mysqli_num_rows($packagePriceResult) > 0) {
        $package = mysqli_fetch_assoc($packagePriceResult);
        return $package['price'];
    } else {
        return 0; // Default to 0 if package price not found
    }
}

// Fetch available rooms for selection
$fetchRoomsQuery = "SELECT * FROM rooms WHERE room_status = 'unbooked'";
$roomsResult = mysqli_query($conn, $fetchRoomsQuery);

// Fetch available booking packages for selection
$fetchPackagesQuery = "SELECT * FROM booking_packages";
$packagesResult = mysqli_query($conn, $fetchPackagesQuery);
?>


    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6 card">
                <div class="box box-primary">
                    <div class="box-body card">
                    <form action="new_booking.php" method="post">
            <!-- Room number selection -->
            <div class="form-group">
                <label for="room_number">Select Room Number:</label>
                <select class="form-control" id="room_number" name="room_number" required>
                    <?php while ($room = mysqli_fetch_assoc($roomsResult)) : ?>
                        <option value="<?php echo $room['room_number']; ?>">
                            <?php echo $room['room_number']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Check-in date -->
            <div class="form-group">
                <label for="checkin_date">Check-in Date:</label>
                <input type="date" class="form-control" id="checkin_date" name="checkin_date" required>
            </div>

            <!-- Checkout date -->
            <div class="form-group">
                <label for="checkout_date">Checkout Date:</label>
                <input type="date" class="form-control" id="checkout_date" name="checkout_date" required>
            </div>

            <!-- Guest name -->
            <div class="form-group">
                <label for="guest_name">Guest Name:</label>
                <input type="text" class="form-control" id="guest_name" name="guest_name" required>
            </div>

            <!-- Paid amount -->
            <div class="form-group">
                <label for="paid_amount">Paid Amount:</label>
                <input type="number" class="form-control" id="paid_amount" name="paid_amount" required>
            </div>

            <!-- Package selection -->
            <div class="form-group">
                <label for="package_id">Select Booking Package:</label>
                <select class="form-control" id="package_id" name="package_id">
                    <option value="0">No Package</option>
                    <?php while ($package = mysqli_fetch_assoc($packagesResult)) : ?>
                        <option value="<?php echo $package['package_id']; ?>">
                            <?php echo $package['package_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Submit button -->
            <button type="submit" class="btn btn-primary">Add Booking</button>
        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
include('footer.php');
?>
