<?php
include 'config.php'; // Ensure this file connects properly to your database

if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);

    // Query for Events table
    $query = "SELECT * FROM events WHERE event_name LIKE '%$search%' OR description LIKE '%$search%' ORDER BY event_date DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='#' class='list-group-item list-group-item-action'>";
            echo "<div class='list-group-item'>
                <h5 class='event-title'>" . htmlspecialchars($row['event_name']) . "</h5>
                <p><strong>Date:</strong> " . htmlspecialchars($row['event_date']) . "</p>
                <p><strong>Venue:</strong> " . htmlspecialchars($row['venue']) . "</p>
                <p><strong>Members:</strong> " . htmlspecialchars($row['membersroles']) . "</p>
                <p><strong>Funds Allocated:</strong> ₹" . htmlspecialchars($row['funds_allocated']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                <a href='funds.php?event_id=" . $row['id'] . "' class='btn btn-info mt-2'>Fund Details</a>
                <a href='view_final_report.php?id=" . $row['id'] . "' class='btn btn-success mt-2'>View Report</a>
                <button class='btn btn-danger delete-btn mt-2' data-id='" . $row['id'] . "'>Delete Event</button>
            </div></a>";
        }
    } else {
        echo "<p class='list-group-item'>No events found.</p>";
    }
}
?>

<?php
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);

    // Query for Cultural Club events (eventss table)
    $query = "SELECT * FROM eventss WHERE event_name LIKE '%$search%' OR description LIKE '%$search%' ORDER BY event_date DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='#' class='list-group-item list-group-item-action'>";
            echo "<div class='list-group-item'>
                <h5 class='event-title'>" . htmlspecialchars($row['event_name']) . "</h5>
                <p><strong>Date:</strong> " . htmlspecialchars($row['event_date']) . "</p>
                <p><strong>Venue:</strong> " . htmlspecialchars($row['venue']) . "</p>
                <p><strong>Members:</strong> " . htmlspecialchars($row['membersroles']) . "</p>
                <p><strong>Funds Allocated:</strong> ₹" . htmlspecialchars($row['funds_allocated']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                <a href='fundss.php?event_id=" . $row['id'] . "' class='btn btn-info mt-2'>Fund Details</a>
                <a href='view_final_reports.php?id=" . $row['id'] . "' class='btn btn-success mt-2'>View Report</a>
                <button class='btn btn-danger delete-btn mt-2' data-id='" . $row['id'] . "'>Delete Event</button>
            </div></a>";
        }
    } else {
        echo "<p class='list-group-item'>No events found.</p>";
    }
}
?>

<?php
if (isset($_POST['search'])) {
    $search = $conn->real_escape_string($_POST['search']);

    // Query for Green Club events (eventsss table)
    $query = "SELECT * FROM eventsss WHERE event_name LIKE '%$search%' OR description LIKE '%$search%' ORDER BY event_date DESC";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<a href='#' class='list-group-item list-group-item-action'>";
            echo "<div class='list-group-item'>
                <h5 class='event-title'>" . htmlspecialchars($row['event_name']) . "</h5>
                <p><strong>Date:</strong> " . htmlspecialchars($row['event_date']) . "</p>
                <p><strong>Venue:</strong> " . htmlspecialchars($row['venue']) . "</p>
                <p><strong>Members:</strong> " . htmlspecialchars($row['membersroles']) . "</p>
                <p><strong>Funds Allocated:</strong> ₹" . htmlspecialchars($row['funds_allocated']) . "</p>
                <p><strong>Description:</strong> " . htmlspecialchars($row['description']) . "</p>
                <a href='fundsss.php?event_id=" . $row['id'] . "' class='btn btn-info mt-2'>Fund Details</a>
                <a href='view_final_reportss.php?id=" . $row['id'] . "' class='btn btn-success mt-2'>View Report</a>
                <button class='btn btn-danger delete-btn mt-2' data-id='" . $row['id'] . "'>Delete Event</button>
            </div></a>";
        }
    } else {
        echo "<p class='list-group-item'>No events found.</p>";
    }
}
?>
