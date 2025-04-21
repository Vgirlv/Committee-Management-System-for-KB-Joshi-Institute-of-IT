<?php
// Include your database connection
include 'config.php';

// Check if an event ID is provided
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $base_url = "http://localhost/KBCMS/uploads/";

    // Fetch event details from `events` table
    $query1 = "SELECT event_name, event_date, description, membersroles, venue, funds_allocated, spent_amount FROM eventss WHERE id = ?";
    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $event_id);
    $stmt1->execute();
    $result1 = $stmt1->get_result();

    // Fetch additional details from `event_reports` table
    $query2 = "SELECT guests, sponsors, schedule, agenda_path, image_path FROM event_reportss WHERE event_id = ?";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $event_id);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    // Check if data exists in both tables
    if ($result1->num_rows > 0 && $result2->num_rows > 0) {
        $event = $result1->fetch_assoc();
        $event_reports = $result2->fetch_assoc();
    
            // Construct functional links
            $agenda_link = !empty($event_reports['agenda_path']) ? $base_url . $event_reports['agenda_path'] : "Not Available";
            $image_link = !empty($event_reports['image_path']) ? $base_url . $event_reports['image_path'] : "Not Available";
    
        // Create file content
        $report_content = "Event Title: " . $event['event_name'] . "\n";
        $report_content .= "Date: " . $event['event_date'] . "\n";
        $report_content .= "Description: " . $event['description'] . "\n";
        $report_content .= "Volunteers: " . $event['membersroles'] . "\n";
        $report_content .= "Event Venue: " . $event['venue'] . "\n";
        $report_content .= "Event Budget: " . $event['funds_allocated'] . "\n";
        $report_content .= "Spent Amount: " . $event['spent_amount'] . "\n\n";

        $report_content .= "Guests: " . $event_reports['guests'] . "\n";
        $report_content .= "Sponsorship: " . $event_reports['sponsors'] . "\n";
        $report_content .= "Schedule of Event: " . $event_reports['schedule'] . "\n";
        $report_content .= "Agenda File: [Click Here](" . $agenda_link . ")\n";
        $report_content .= "Event Image: [Click Here](" . $image_link . ")\n";
        

        // Set headers for file download
        header('Content-Type: text/plain');
        header('Content-Disposition: attachment; filename="Event_Report_' . $event_id . '.txt"');

        // Output the file content
        echo $report_content;
        exit;
    } else {
        echo "Report not found.";
    }
} else {
    echo "Invalid request.";
}
?>
