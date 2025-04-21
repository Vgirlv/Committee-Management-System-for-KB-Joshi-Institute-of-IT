<?php
include 'config.php'; // Ensure this file contains the database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ecell_name = $_POST["ecell_name"];
    $college_name = $_POST["college_name"];
    $social_media_link = $_POST["social_media_link"];
    $website_link = $_POST["website_link"];

    $sql = "INSERT INTO partners (ecell_name, college_name, social_media_link, website_link) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $ecell_name, $college_name, $social_media_link, $website_link);

    if ($stmt->execute()) {
        echo "<script>alert('Partner added successfully!'); window.location.href='partner.php';</script>";
    } else {
        echo "<script>alert('Error adding partner!');</script>";
    }
}
?>
