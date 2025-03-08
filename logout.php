<?php
session_start();
require_once "config.php"; // Ensure this file contains your database connection

// Check if the user is logged in
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    // Remove session from database
    $sql = "DELETE FROM user_sessions WHERE session_id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", session_id());
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

// Clear all session variables
$_SESSION = array(); 
session_destroy(); // Destroy the session
header("location: login.php"); // Redirect to login page
exit;
?>