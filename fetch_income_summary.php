<?php
// Include your database connection file
include('db_connection.php');

// Fetch income summary data from the database (replace table and column names as per your database schema)
$query = "SELECT MONTH(checkin_date) as month, SUM(total_amount) as total_income FROM bookings GROUP BY MONTH(checkin_date)";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['total_income'];
    }
    
    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Unable to fetch income summary data'));
}

mysqli_close($conn);
?>
