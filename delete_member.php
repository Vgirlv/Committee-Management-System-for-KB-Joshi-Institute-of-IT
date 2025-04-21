<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['member_id'])) {
    $member_id = $_POST['member_id'];

    if (!empty($member_id) && is_numeric($member_id)) {
        $sql = "DELETE FROM members WHERE id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("i", $member_id);
            if ($stmt->execute()) {
                echo "Member deleted successfully!";
            } else {
                echo "Error executing query: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error preparing query: " . $conn->error;
        }
    } else {
        echo "Invalid member ID.";
    }
} else {
    echo "Invalid request.";
}

$conn->close();
?>
