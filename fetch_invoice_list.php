<?php
// Include your database connection file
include('db_connection.php');

// Fetch the latest invoice data from the database
$query = "SELECT * FROM invoices ORDER BY invoice_date DESC LIMIT 10"; // Adjust the query as per your database schema
$result = mysqli_query($conn, $query);

if ($result) {
    $invoices = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($invoices as $invoice) {
        echo '<li class="list-group-item">';
        echo '<strong>Invoice Number:</strong> ' . $invoice['invoice_number'] . '<br>';
        echo '<strong>Customer:</strong> ' . $invoice['customer_name'] . '<br>';
        echo '<strong>Total Amount:</strong> ' . $invoice['total_amount'] . '<br>';
        // Include additional invoice details as needed
        echo '</li>';
    }
} else {
    echo '<li class="list-group-item">Error fetching invoice list</li>';
}

mysqli_close($conn);
?>
