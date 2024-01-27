<?php
$to = "raskislam@gmail.com"; // Replace with the recipient's email address
$subject = "Test Email";
$message = "This is a test email sent from XAMPP.";

$headers = "From: asraful2001a@gmail.com"; // Replace with the sender's email address

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully.";
} else {
    echo "Email sending failed.";
}
?>