<?php
include 'config.php'; // Ensure this file contains the database connection

if (isset($_GET["id"])) {
    $id = $_GET["id"];

    $sql = "DELETE FROM partners WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Partner deleted successfully!'); window.location.href='partner.php';</script>";
    } else {
        echo "<script>alert('Error deleting partner!');</script>";
    }
}
?>
