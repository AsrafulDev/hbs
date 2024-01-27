<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}
include('db_connection.php');



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $username = $_POST['username'];
    $username = mysqli_real_escape_string($conn, $username);

    // Hash the password before storing it in the database
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $insertUserQuery = "INSERT INTO users (name,  username, password, role, email) VALUES ('$name', '$username', '$hashedPassword', 'user', '$email')";
    $token = bin2hex(random_bytes(32));

    // Insert the token into the password_resets table
    $insertTokenQuery = "REPLACE INTO password_resets (email, token) VALUES ('$email', '$token')";
    $insertResult = mysqli_query($conn, $insertTokenQuery);

    
    if (mysqli_query($conn, $insertUserQuery)) {
        // Registration successful, redirect to login page
        if ($insertResult) {
                // Send an email to the user with a link to reset their password
                $resetLink = "http://localhost/hbs/reset_password_form.php?email=$email&token=$token";
                $to = "$email"; // Replace with the recipient's email address
                $subject = "Email sending form HBS to Create new User";
                $message = "Go to this Link for reset password Hotel Booking System . $resetLink    User:$username ";
                
                $headers = "From: asraful2001a@gmail.com"; // Replace with the sender's email address
                
                if (mail($to, $subject, $message, $headers)) {
                    echo "Email sent successfully.";
                    echo "Registration successful. <br> An email has been sent to your email address with password.";
                } else {
                    echo "Email sending failed.";
                }
            }else{
                    echo "Email sending failed.";
                }

        // header('Location: index.php');
        // exit();
    } else {
        $error = 'Error creating user: ' . mysqli_error($conn);
    }
}

mysqli_close($conn);
$pageTitle = "New User";
include('header.php');
if( $_SESSION['user_role']==='admin'){
?>

<div class="col-md-6">
       
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
            <h3>User Register</h3>
        <?php if (isset($error)) : ?>
            <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="" method="post">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" required><br>
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br>

                    <div class="input-group mb-3">
                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                    <label for="password">Password:</label>
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
           
            
            <button type="submit"class="btn btn-primary btn-block">Register</button>
        </form>
        
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
    <!-- /.login-box -->

    <?php } else{echo"<h3>You are not parmited to add User</h3>";}
// Include footer
include('footer.php');
?>

