<?php
include 'config.php';
session_start();

// Ensure only admins can approve users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user ID from the request
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Update the user's role (modify as needed, e.g., 'pending' → 'user')
    $sql = "UPDATE users SET role = 'user' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User approved successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error approving user.'); window.location.href='admin_dashboard.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
