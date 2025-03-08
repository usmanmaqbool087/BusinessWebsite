<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once "config.php";
session_start();

$username = $password = "";
$username_err = $password_err = $login_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty(trim($_POST["username"]))) {
        $username_err = "Please enter username.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty(trim($_POST["password"]))) {
        $password_err = "Please enter your password.";
    } else {
        $password = trim($_POST["password"]);
    }

    if (empty($username_err) && empty($password_err)) {
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            $param_username = $username;
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_store_result($stmt);
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            session_start();
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;

                            $sql = "INSERT INTO user_sessions (user_id, session_id) VALUES (?, ?)";
                            if ($stmt = mysqli_prepare($link, $sql)) {
                                mysqli_stmt_bind_param($stmt, "is", $id, session_id());
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                            }

                            header("location: contact.php");
                            exit();
                        } else {
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else {
                    $login_err = "Invalid username or password.";
                }
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | EventHive</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            background: #fff; /* Simple white background */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            width: 400px;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-title {
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

<div class="login-container">
    <h2 class="login-title">Login to EventHive</h2>

    <?php if (!empty($login_err)): ?>
        <p class="text-danger"><?php echo $login_err; ?></p>
    <?php endif; ?>

    <form action="login.php" method="POST">
        <div class="form-group">
            <input type="text" name="username" class="form-control" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

    <div class="links">
        <p>Don't have an account? <a href="register.php">Sign up now</a></p>
    </div>
</div>

</body>
</html>
