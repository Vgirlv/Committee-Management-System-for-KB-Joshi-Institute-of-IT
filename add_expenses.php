<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = $_POST['event_id'];
    $item_name = $_POST['item_name'];
    $amount_spent = $_POST['amount_spent'];

    $query = "INSERT INTO event_expensess (event_id, item_name, amount_spent) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isd", $event_id, $item_name, $amount_spent);

    if ($stmt->execute()) {
        header("Location: fundss.php?event_id=" . $event_id);
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
