<?php
include 'config.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password_raw = $_POST['password'];

     // ✅ Email validation
     if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, "@maharshikarvebcapune.org")) {
        die("Error: Email address doesn't Maharshi Karve Domain. <a href='index.html'>Go back</a>");
    }

    // Password validation
    if (
        strlen($password_raw) < 8 ||
        !preg_match('/[A-Za-z]/', $password_raw) ||         // at least one letter
        !preg_match('/[0-9]/', $password_raw) ||            // at least one number
        !preg_match('/[\W_]/', $password_raw)               // at least one special char
    ) {
        echo "<script>alert('Password must be at least 8 characters long, alphanumeric, and include a special character.'); window.location.href='index.html';</script>";
        exit;
    }

    $password = password_hash($password_raw, PASSWORD_BCRYPT); // Hash password for security

    // Check if email already exists
    $checkQuery = "SELECT * FROM admins WHERE email='$email'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo "<script>alert('Email already registered!'); window.location.href='index.php';</script>";
    } else {
        // Insert new admin
        $query = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$password')";
        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration successful! You can now log in.'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Error: Could not register.'); window.location.href='index.php';</script>";
        }
    }
}
?>
