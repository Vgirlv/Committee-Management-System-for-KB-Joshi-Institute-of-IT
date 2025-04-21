<?php
session_start();
include 'config.php'; // Ensure this file has the correct DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare SQL statement to prevent SQL injection
    $query = "SELECT id, password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {  
            $_SESSION['user_id'] = $row['id']; // Store user ID in session
            header("Location: edashboard.php");
            exit();
        }
    }

    // Generic error message to avoid revealing details
    echo "Invalid email or password!";
}
?>
