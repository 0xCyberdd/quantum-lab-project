<?php
include 'config.php';
session_start();

$error_message = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = trim($_POST['role']); // Get role from the form

    // Sanitize inputs for security
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $role = filter_var($role, FILTER_SANITIZE_STRING);

    $sql = "SELECT id, username, password FROM users WHERE email=? AND role=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $role);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $username, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;

        echo "<div class='alert alert-success text-center'>Login successful! Redirecting...</div>";

        // Redirect based on user role
        if ($role == 'admin') {
            header("refresh:2; url=admin_dashboard.php"); 
        } elseif ($role == 'seller') {
            header("refresh:2; url=seller_dashboard.php");
        } elseif ($role == 'user') {
            header("refresh:2; url=user_dashboard.php");
        } elseif ($role == 'business') {
            header("refresh:2; url=business_dashboard.php");
        }
        exit();
    } else {
        $error_message = "Invalid email, password, or role.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .login-container {
            display: flex;
            width: 800px;
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .image-part {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .image-part img {
            max-width: 90%;
            height: auto;
        }
        .form-part {
            flex: 1;
            padding-left: 40px;
        }
        .form-part h2 {
            text-align: left;
            color: #333;
            margin-bottom: 30px;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="image-part">
            <img src="img/quantum_logo2.png" alt="Image">
        </div>
        <div class="form-part">
            <h2>Member Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" id="email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="password" required>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin">Admin</option>
                        <option value="seller">Seller</option>
                        <option value="user">User</option>
                        <option value="business">Business</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary mt-3">LOGIN</button>
            </form>
            <div class="forgot-password mt-2">
                <a href="#">Forgot Username/Password?</a>
            </div>
            <div class="create-account mt-2">
                Create your Account →
            </div>

            <?php if (!empty($error_message)): ?>
                <div class='alert alert-danger mt-3 text-center'><?= htmlspecialchars($error_message) ?></div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
