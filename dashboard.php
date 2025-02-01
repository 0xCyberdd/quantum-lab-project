<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Role-based access control
$username = htmlspecialchars($_SESSION['username']);
$role = htmlspecialchars($_SESSION['role']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white text-center">
                    <h4>Welcome, <?= $username ?>!</h4>
                </div>
                <div class="card-body text-center">
                    <p>You are logged in as <strong><?= $role ?></strong>.</p>

                    <?php if ($role === 'user'): ?>
                        <p>👤 Regular user panel.</p>
                    <?php elseif ($role === 'business'): ?>
                        <p>🏢 Business dashboard.</p>
                    <?php elseif ($role === 'seller'): ?>
                        <p>🛒 Seller dashboard.</p>
                    <?php endif; ?>

                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
