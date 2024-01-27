<?php
session_start();
include('db_connection.php');
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
$pageTitle = "Invoice List";// Include header
include('header.php');
?>


<!-- Include your header/navigation section here -->
<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <table id="invoiceList" class="display">
        <thead>
            <tr>
                <th>Invoice Number</th>
                <th>Customer</th>
                <th>Invoice Date</th>
                <th>Total Amount</th>
                <!-- Include additional table headers as needed -->
            </tr>
        </thead>
        <tbody>
            <!-- Invoice data will be loaded dynamically via AJAX -->
        </tbody>
    </table>


<!-- Include your footer section here -->

<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Include DataTables JavaScript -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

<script>
   
        // DataTable initialization with AJAX
        var dataTable = $('#invoiceList').DataTable({
            "ajax": {
                "url": "fetch_invoice_list_ajax.php", // Path to your server-side script
                "dataSrc": "" // The data source should be an array
            },
            "columns": [
                { "data": "invoice_number" },
                { "data": "customer_name" },
                { "data": "invoice_date" },
                { "data": "total_amount" }
                // Add more column definitions as needed
            ]
        });

        // Search functionality
        $('#search').on('keyup', function () {
            dataTable.search(this.value).draw();
        });
   
</script>


<?php
// Include footer
include('footer.php');
?>

