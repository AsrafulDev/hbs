<?php
// Include your database connection file
include('db_connection.php');

// Fetch booking summary data from the database (replace table and column names as per your database schema)
$query = "SELECT MONTH(checkin_date) as month, COUNT(*) as booking_count FROM bookings GROUP BY MONTH(checkin_date)";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['booking_count'];
    }
    
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Unable to fetch booking summary data'));
}

mysqli_close($conn);
?>
