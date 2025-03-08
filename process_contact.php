<?php
session_start();
require_once "config.php"; // Ensure this file contains your database connection

// Check if the user is logged in
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    $_SESSION['error'] = "Access denied! Please log in or sign up.";
    header("location: login.php");
    exit;
}

// Handle the contact form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $mobile = trim($_POST['mobile']);
    $location = trim($_POST['location']);
    $service = trim($_POST['service']);
    $message = trim($_POST['message']);

    // Validate input (you can add more validation as needed)
    if (empty($username) || empty($email) || empty($mobile) || empty($location) || empty($service) || empty($message)) {
        $_SESSION['error'] = "All fields are required.";
        header("location: contact.php");
        exit;
    }

    // Prepare an insert statement
    $sql = "INSERT INTO contacts (username, email, mobile, location, service, message) VALUES (?, ?, ?, ?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssss", $username, $email, $mobile, $location, $service, $message);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Message sent successfully!";
            header("location: contact.php");
            exit;
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("location: contact.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Could not prepare statement.";
        header("location: contact.php");
        exit;
    }
}

// Close connection
mysqli_close($link);
?>