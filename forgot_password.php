<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $checkEmailQuery);

    if ($result && mysqli_num_rows($result) > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(32));

        // Insert the token into the password_resets table
        $insertTokenQuery = "REPLACE INTO password_resets (email, token) VALUES ('$email', '$token')";
        $insertResult = mysqli_query($conn, $insertTokenQuery);

        if ($insertResult) {
            // Send an email to the user with a link to reset their password
            $resetLink = "http://localhost/hbs/reset_password_form.php?email=$email&token=$token";
            // Implement your email sending logic here
            $to = "$email"; // Replace with the recipient's email address
            $subject = "Email sending form HBS to reset password";
            $message = "Go to this Link for reset Hotel Booking System .$resetLink";
            
            $headers = "From: asraful2001a@gmail.com"; // Replace with the sender's email address
            
            if (mail($to, $subject, $message, $headers)) {
                echo "Email sent successfully.";
                echo "An email has been sent to your email address with instructions to reset your password.";
            } else {
                echo "Email sending failed.";
            }
           
        } else {
            echo "Error generating reset token: " . mysqli_error($conn);
        }
    } else {
        echo "Email not found in the database.";
    }
}
?>

<!-- Your Forgot Password form goes here -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>Forgot Password - Hotel Booking System</title>
    <!-- Add the AdminLTE stylesheets -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <a href="#"><b>Hotel</b> Booking</a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <h2>Forgot Password</h2>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>

            <button type="submit">Reset Password</button>
        </form>
        <p>Remember your password? <a href="index.php">Login here</a></p>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <!-- Add the AdminLTE scripts -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="dist/js/adminlte.min.js"></script>
</body>
</html>
