<?php
session_start();
include 'config.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $membersroles = mysqli_real_escape_string($conn, $_POST['members']);
    $venue = mysqli_real_escape_string($conn, $_POST['venue']);
    $event_date = mysqli_real_escape_string($conn, $_POST['event_date']);
    $funds_allocated = mysqli_real_escape_string($conn, $_POST['funds_allocated']);



    // Insert into database
    $query = "INSERT INTO eventsss (event_name, description, membersroles, venue, event_date, funds_allocated)
              VALUES ('$event_name', '$description', '$membersroles', '$venue', '$event_date', '$funds_allocated')";

    if (mysqli_query($conn, $query)) {
        echo "Event Created: <a href='gdashboard.php'>Success</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
    
}

mysqli_close($conn);
?>
