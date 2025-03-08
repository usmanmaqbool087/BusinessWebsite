<?php
session_start();
require_once "config.php"; 



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("location: register.php");
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
        
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("location: login.php");
            exit;
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
            header("location: register.php");
            exit;
        }
        mysqli_stmt_close($stmt);
    } else {
        $_SESSION['error'] = "Could not prepare statement.";
        header("location: register.php");
        exit;
    }
}

mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | EventHive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            width: 400px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .register-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 15px;
            color: #ff8800;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 10px;
            font-size: 16px;
            background: #fff;
            color: #333;
        }

        .btn-primary {
            background: #ff8800;
            border: none;
            width: 100%;
            padding: 10px;
            font-size: 18px;
            border-radius: 8px;
            transition: 0.3s;
            color: white;
        }

        .btn-primary:hover {
            background: #ff6600;
        }

        .text-danger {
            color: red;
        }

        .links {
            margin-top: 15px;
        }

        .links a {
            color: #ff8800;
            text-decoration: none;
            font-weight: bold;
        }

        .links a:hover {
            color: #ff6600;
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2 class="register-title">Create an Account</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <p class="text-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>

    <form action="register.php" method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Register</button>
    </form>

    <div class="links">
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</div>

</body>
</html>
