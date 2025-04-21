<?php
session_start();
include 'config.php'; // Ensure config.php has correct DB credentials

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["name"], $_POST["email"], $_POST["password"])) {
        die("Error: Missing form fields. Please ensure all fields have the correct name attributes.");
    }

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $password_raw = trim($_POST["password"]);

    // ✅ Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, "@maharshikarvebcapune.org")) {
        die("Error: Email address doesn't Maharshi Karve Domain. <a href='ecell.html'>Go back</a>");
    }

    // ✅ Password validations
    if (strlen($password_raw) < 8) {
        die("Error: Password must be at least 8 characters long. <a href='ecell.html'>Go back</a>");
    }

    if (!preg_match('/[A-Za-z]/', $password_raw) || !preg_match('/\d/', $password_raw)) {
        die("Error: Password must contain both letters and numbers. <a href='ecell.html'>Go back</a>");
    }

    if (!preg_match('/[^A-Za-z0-9]/', $password_raw)) {
        die("Error: Password must contain at least one special character. <a href='ecell.html'>Go back</a>");
    }

    $password = password_hash($password_raw, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_email);
    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("Error: Email already registered! <a href='ecell.html'>Go back</a>");
    } else {
        // Insert new user
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die("Prepare statement failed: " . $conn->error);
        }

        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            die("Registration successful! <a href='ecell.html'>Click here to login</a>");
        } else {
            die("Error inserting data: " . $stmt->error);
        }
    }
    $stmt->close();
}
$conn->close();
?>
