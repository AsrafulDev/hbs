
<?php
// Include your database connection file
include('db_connection.php');

// Fetch the latest invoice data from the database based on search criteria
$search = isset($_GET['search']) ? $_GET['search'] : '';
$query = "SELECT * FROM invoices WHERE invoice_number LIKE '%$search%' ORDER BY invoice_date DESC LIMIT 10";

$result = mysqli_query($conn, $query);

$data = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);

// Return the data in JSON format
echo json_encode($data);
?>
