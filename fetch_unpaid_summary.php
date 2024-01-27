<?php
// Include your database connection file
include('db_connection.php');

// Fetch unpaid summary data from the database (replace table and column names as per your database schema)
$query = "SELECT MONTH(checkin_date) as month, SUM(total_amount - paid_amount) as total_unpaid FROM bookings WHERE paid_amount < total_amount GROUP BY MONTH(checkin_date)";
$result = mysqli_query($conn, $query);

if ($result) {
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['total_unpaid'];
    }

    echo json_encode($data);
} else {
    echo json_encode(array('error' => 'Unable to fetch unpaid summary data'));
}

mysqli_close($conn);
?>
