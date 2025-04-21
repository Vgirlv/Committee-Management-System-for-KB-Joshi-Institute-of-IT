<?php
include 'config.php'; // Ensure this file contains your DB connection code

if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);

    // First, delete related records from event_expenses to avoid foreign key issues
    $query1 = "DELETE FROM event_expensesss WHERE event_id = ?";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "i", $event_id);
    mysqli_stmt_execute($stmt1);
    mysqli_stmt_close($stmt1);

    // Now delete the event from eventss table
    $query2 = "DELETE FROM eventsss WHERE id = ?";
    $stmt2 = mysqli_prepare($conn, $query2);
    mysqli_stmt_bind_param($stmt2, "i", $event_id);
    $success = mysqli_stmt_execute($stmt2);
    mysqli_stmt_close($stmt2);

    mysqli_close($conn);

    if ($success) {
        echo "<script>alert('Event deleted successfully!'); window.location.href='gdashboard.php';</script>";
    } else {
        echo "<script>alert('Failed to delete event.'); window.location.href='gdashboard.php';</script>";
    }
} else {
    echo "<script>alert('Invalid request.'); window.location.href='gdashboard.php';</script>";
}
?>
