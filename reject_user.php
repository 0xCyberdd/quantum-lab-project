<?php
include 'config.php';
session_start();

// Ensure only admins can reject users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Get the user ID from the request
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']);

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('User rejected and removed successfully!'); window.location.href='admin_dashboard.php';</script>";
    } else {
        echo "<script>alert('Error rejecting user.'); window.location.href='admin_dashboard.php';</script>";
    }

    $stmt->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='admin_dashboard.php';</script>";
}

$conn->close();
?>
