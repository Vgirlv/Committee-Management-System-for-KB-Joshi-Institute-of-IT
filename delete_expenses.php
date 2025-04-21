<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $expense_id = $_POST['expense_id'];
    $event_id = $_POST['event_id'];

    $query = "DELETE FROM event_expensess WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $expense_id);

    if ($stmt->execute()) {
        header("Location: fundss.php?event_id=" . $event_id);
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
