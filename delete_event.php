<?php
include 'config.php'; // Ensure this file contains your DB connection code

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $event_id = intval($_POST['id']);
        $query = "DELETE FROM events WHERE id = ?";
        
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $event_id);
        $success = mysqli_stmt_execute($stmt);
        
        if ($success) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["success" => false]);
        }

        mysqli_stmt_close($stmt);
    }
}

mysqli_close($conn);
?>
