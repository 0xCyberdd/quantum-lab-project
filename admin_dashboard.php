<?php
include 'config.php';
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Fetch statistics for the dashboard
$total_users_sql = "SELECT COUNT(*) FROM users";
$total_posts_sql = "SELECT COUNT(*) FROM posts";
$total_applications_sql = "SELECT COUNT(*) FROM job_applications";
$pending_applications_sql = "SELECT COUNT(*) FROM job_applications WHERE status = 'pending'";

$total_users_result = $conn->query($total_users_sql);
$total_posts_result = $conn->query($total_posts_sql);
$total_applications_result = $conn->query($total_applications_sql);
$pending_applications_result = $conn->query($pending_applications_sql);

// Check if queries are successful
if ($total_users_result && $total_posts_result && $total_applications_result && $pending_applications_result) {
    $total_users = $total_users_result->fetch_row()[0];
    $total_posts = $total_posts_result->fetch_row()[0];
    $total_applications = $total_applications_result->fetch_row()[0];
    $pending_applications = $pending_applications_result->fetch_row()[0];
} else {
    // Handle error if query fails
    die("Error fetching data: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
        }
        .dashboard-container {
            margin-top: 20px;
            padding: 30px;
            border-radius: 10px;
            background-color: #fff;
            color: black;
        }
    </style>
</head>
<body>
    <div class="container dashboard-container">
        <h1 class="text-center">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">Total Users</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_users ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">Total Posts</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_posts ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">Total Applications</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $total_applications ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center">
                    <div class="card-header">Pending Applications</div>
                    <div class="card-body">
                        <h5 class="card-title"><?= $pending_applications ?></h5>
                    </div>
                </div>
            </div>
        </div>

        <h3 class="mt-5">User Management</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Fetch users from the database and display them
                $user_sql = "SELECT id, username, email, role FROM users";
                $user_result = $conn->query($user_sql);

                while ($row = $user_result->fetch_assoc()) {
                    echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['username']}</td>
                        <td>{$row['email']}</td>
                        <td>{$row['role']}</td>
                        <td>
                            <a href='approve_user.php?id={$row['id']}' class='btn btn-success btn-sm'>Approve</a>
                            <a href='reject_user.php?id={$row['id']}' class='btn btn-danger btn-sm'>Reject</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <a href="logout.php" class="btn btn-danger mt-5">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
