<?php
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $spent_amount = $_POST['spent_amount'];

    // Update spent amount
    $query = "UPDATE events SET spent_amount = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("di", $spent_amount, $event_id);
    
    if ($stmt->execute()) {
        header("Location: funds.php?event_id=" . $event_id);
        exit();
    } else {
        echo "Failed to update funds.";
    }
}
?>
