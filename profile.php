<?php
// Include your authentication check and user data retrieval logic here
// For example, if you have a session-based authentication system:

   
    
    session_start();
    // Redirect to login page if not authenticated
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
    include('db_connection.php');
    include('header.php');

// Fetch user data based on the logged-in user's ID
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $user_data = mysqli_fetch_assoc($result);
} else {
    // Handle the case when user data is not found
    $user_data = array();
}

mysqli_close($conn);
?>

<!-- Include your header/navigation section here -->

<div class="container mt-5">
    <h2>User Profile</h2>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Profile Information</h5>
            <p class="card-text">Name: <?php echo $user_data['username']; ?></p>
            <p class="card-text">Email: <?php echo $user_data['email']; ?></p>
            <!-- Include additional user information as needed -->
        </div>
    </div>
</div>

<!-- Include your footer section here -->

<?php
include('footer.php');
?>