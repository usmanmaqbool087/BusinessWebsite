<?php
session_start(); // Session start karna zaroori hai

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo '<h2>Access Denied</h2>';
    echo '<p class="error">You must be logged in to access this page.</p>';
    echo '<p>Please <a href="index5.php">log in</a> or <a href="index5.php">sign up</a> to continue.</p>';
    exit(); // Stop execution if user is not logged in
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f4f4;
        }
        header {
            background: #ff9933;
            padding: 20px;
            text-align: center;
            color: white;
        }
        .contact {
            background: white;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .contact h2 {
            text-align: center;
            color: #ff9933;
        }
        .contact input, .contact select, .contact textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .contact button {
            width: 100%;
            background: #ff9933;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            font-size: 16px;
            cursor: pointer;
        }
        .contact button:hover {
            background: #ff6600;
        }
        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: white;
            margin-top: 30px;
        }
    </style>
</head>
<body>
<header>
    <h1>Contact Us</h1>
</header>

<section class="contact">
    <h2>Contact Form</h2>
    <?php if (isset($success)): ?>
        <div class="success"> <?php echo $success; ?> </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="error"> <?php echo $error; ?> </div>
    <?php endif; ?>

    <form action="process.php" method="POST">
        <label for="name">Your Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Your Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="phone">Your Phone Number:</label>
        <input type="text" id="phone" name="phone" required>

        <label for="service">Choose a Service:</label>
        <select id="service" name="service" required>
            <option value="">Select a Service</option>
            <option value="Wedding Planning">Wedding Planning</option>
            <option value="Birthday Events">Birthday Events</option>
            <option value="Corporate Events">Corporate Events</option>
            <option value="Private Parties">Private Parties</option>
            <option value="Festival Management">Festival Management</option>
        </select>

        <label for="message">Your Message:</label>
        <textarea id="message" name="message" required></textarea>

        <button type="submit" name="action" value="contact">Send Message</button>
    </form>
    <a href="logout.php">Logout</a>
</section>

<footer>
    <p>&copy; 2025 Your Business Name. All rights reserved.</p>
</footer>

</body>
</html>
