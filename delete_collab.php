<?php
include 'config.php'; // Ensure DB connection

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "DELETE FROM collaborations WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Collaboration deleted successfully!'); window.location.href='collaboraters.php';</script>";
    } else {
        echo "<script>alert('Error deleting collaboration!');</script>";
    }

    $stmt->close();
}
?>
