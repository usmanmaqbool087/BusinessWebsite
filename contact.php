<?php
session_start();

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    $_SESSION['error'] = "Access denied! Please log in or sign up.";
    header("location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - EventHive</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contact-container {
            width: 500px;
            padding: 30px;
            background: white;
            margin-top: 300px;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
        }

        .contact-title {
            font-size: 24px;
            color:  #ff8800;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            background: #f8f9fa;
            color: #222;
            border: 1px solid #ccc;
            border-radius: 8px;
        }

        textarea {
            height: 100px;
        }

        .btn {
            display: block;
            width: 100%;
            padding: 12px;
            font-size: 16px;

            background:   #ff8800;;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background: #ffaa00;
        }

        .error-message {
            color: red;
            margin-bottom: 10px;
        }
         header {
            position: absolute;
            width: 100%;
            height: 20%;
            top: 0;
            left: 0;
            padding: 15px 0;
            z-index: 1000;
             background-image: url('homebackground.jpg');/* Background color */
            text-align: center;
        }
        nav ul {
            list-style: none;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 1.2rem;
            transition: color 0.3s ease;
        }
        nav ul li a:hover {
            color: #f39c12;
        }
        .logo {
    margin-top: 20px;
            font-size: 30px;
            font-weight: bold;
            color: #ffaa00;
            text-align: left;
            margin-left: 20px;

        }
    </style>
</head>
<body>
<header>
     <div class="logo">EventHive</div>
        <nav>
            <ul>
                <li><a href="home.html">Home</a></li>
                <li><a href="about.html">About</a></li>
                <li><a href="services.html">Services</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
<div class="contact-container">
    <h2 class="contact-title">Contact Us</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="error-message"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form action="process_contact.php" method="POST">
        <div class="form-group">
            <input type="text" name="username" placeholder="Your Name" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" placeholder="Your Email" required>
        </div>
        <div class="form-group">
            <input type="text" name="mobile" placeholder="Mobile Number" required>
        </div>
        <div class="form-group">
            <input type="text" name="location" placeholder="Location" required>
        </div>
        <div class="form-group">
            <select name="service" required>
                <option value="" disabled selected>Select Service</option>
                <option value="Wedding Events">Wedding Events</option>
                <option value="Corporate Events">Corporate Events</option>
                <option value="Private And Social Events">Private And Social Events</option>
                <option value="Birthday Celebrations">Birthday Celebrations</option>
                <option value="Festival Events">Festival Events</option>
                <option value="Entertainment Events">Entertainment Events</option>
            </select>
        </div>
        <div class="form-group">
            <textarea name="message" placeholder="Your Message" required></textarea>
        </div>
        <button type="submit" class="btn">Send Message</button>
    </form>

    <a href="logout.php" class="btn" style="margin-top: 10px;">Logout</a>
</div>

</body>
</html>
