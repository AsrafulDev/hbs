<!-- auth.php -->

<?php
session_start();

function is_authenticated() {
    return isset($_SESSION['user']);
}

function authenticate($username, $password) {
    $conn = mysqli_connect('localhost', 'root', '', 'hotel_booking_system');

    if (!$conn) {
        die('Connection failed: ' . mysqli_connect_error());
    }

    $username = mysqli_real_escape_string($conn, $username);
    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user'] = $username;
           $_SESSION['user_id'] =  $row['id'];
           $_SESSION['user_role'] =  $row['role'];
            mysqli_close($conn);
            return true;
        }
    }

    mysqli_close($conn);
    return false;
}

function logout() {
    unset($_SESSION['user']);
    session_destroy();
}
?>
