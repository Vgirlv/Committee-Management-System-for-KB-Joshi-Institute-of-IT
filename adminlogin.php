<?php
session_start();
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch admin details from the database
    $query = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $admin = mysqli_fetch_assoc($result);

        if (password_verify($password, $admin['password'])) { // Assuming passwords are hashed
            $_SESSION["user_id"] = $admin['id'];
            $_SESSION["admin_name"] = $admin['name']; // Store admin's name in session
            header("Location: admind.php"); // Redirect to dashboard
            exit();
        } else {
            echo "Invalid password or Email!";
        }
    } else {
        echo "Admin not found!";
    }
}
?>
