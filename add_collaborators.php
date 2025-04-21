<?php
include 'config.php'; // Ensure DB connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $organization_name = $_POST['organization_name'];
    $contact_person = $_POST['contact_person'];
    $contact_email = $_POST['contact_email'];
    $collaboration_details = $_POST['collaboration_details'];
    $website_link = $_POST['website_link'];

    $query = "INSERT INTO collaborations (organization_name, contact_person, contact_email, collaboration_details, website_link) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $organization_name, $contact_person, $contact_email, $collaboration_details, $website_link);

    if ($stmt->execute()) {
        echo "<script>alert('Collaboration added successfully!'); window.location.href='collaboraters.php';</script>";
    } else {
        echo "<script>alert('Error adding collaboration!');</script>";
    }

    $stmt->close();
}
?>
