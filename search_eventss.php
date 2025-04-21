<?php
// Include the database connection file
include 'config.php';

if (isset($_POST['search'])) {
    $search = mysqli_real_escape_string($conn, $_POST['search']);

    $query = "SELECT * FROM eventss 
              WHERE event_name LIKE '%$search%' 
              OR description LIKE '%$search%' 
              OR venue LIKE '%$search%' 
              ORDER BY event_date DESC";

    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($event = mysqli_fetch_assoc($result)) {
            echo "
            <div class='list-group-item'>
                <h5 class='event-title'>" . htmlspecialchars($event['event_name']) . "</h5>
                <p><strong>Date:</strong> " . htmlspecialchars($event['event_date']) . "</p>
                <p><strong>Venue:</strong> " . htmlspecialchars($event['venue']) . "</p>
                <p><strong>Members:</strong> " . htmlspecialchars($event['membersroles']) . "</p>
                <p><strong>Funds Allocated:</strong> ₹" . htmlspecialchars($event['funds_allocated']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($event['description']) . "</p>

                <!-- Action Buttons -->
                <a href='fundss.php?event_id=" . $event['id'] . "' class='btn btn-info mt-2'>Fund Details</a>
                <a href='view_final_reports.php?id=" . $event['id'] . "' class='btn btn-success mt-2'>View Report</a>
                <button class='btn btn-danger delete-btn mt-2' data-id='" . $event['id'] . "'>Delete Event</button>
            </div>";
        }
    } else {
        echo "<div class='alert alert-warning'>No matching events found.</div>";
    }
}
?>
