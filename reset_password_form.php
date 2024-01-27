<?php
session_start();
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = $_POST['token'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate the token in the password_resets table
    $verifyTokenQuery = "SELECT * FROM password_resets WHERE email = '$email' AND token = '$token'";
    $verifyResult = mysqli_query($conn, $verifyTokenQuery);

    if ($verifyResult && mysqli_num_rows($verifyResult) > 0) {
        // Token is valid
        if ($newPassword == $confirmPassword) {
            // Passwords match, update the user's password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updatePasswordQuery = "UPDATE users SET password = '$hashedPassword' WHERE email = '$email'";
            $updateResult = mysqli_query($conn, $updatePasswordQuery);

            if ($updateResult) {
                // Password updated successfully
                // Optionally, you can delete the used token from the password_resets table
                $deleteTokenQuery = "DELETE FROM password_resets WHERE email = '$email' AND token = '$token'";
                mysqli_query($conn, $deleteTokenQuery);

                echo "Password updated successfully. You can now <a href='index.php'>login</a> with your new password.";
            } else {
                echo "Error updating password: " . mysqli_error($conn);
            }
        } else {
            echo "Passwords do not match. Please try again.";
        }
    } else {
        echo "Invalid or expired token.";
    }
}
?>

<!-- Your Password Reset form goes here -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input {
            width: 100%;
            padding: 8px;
            margin-bottom: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

    <h2>Reset Password</h2>

    <!-- Password Reset Form -->
    <form method="post" action="">
        <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
        
        <label for="new_password">New Password:</label>
        <input type="password" name="new_password" required>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit">Reset Password</button>
    </form>

</body>
</html>
