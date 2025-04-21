<?php
include 'config.php';

// Get total number of events
$totalQuery = "SELECT 
                 (SELECT COUNT(*) FROM events) + 
                 (SELECT COUNT(*) FROM eventss) + 
                 (SELECT COUNT(*) FROM eventsss) AS total_events";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalEvents = $totalRow['total_events'];

// Query to count events per club
$query = "SELECT 'EDC' AS club, COUNT(*) AS event_count FROM events
          UNION ALL
          SELECT 'Cultural' AS club, COUNT(*) FROM eventss
          UNION ALL
          SELECT 'Green' AS club, COUNT(*) FROM eventsss";

$result = mysqli_query($conn, $query);
$clubPerformance = [];

while ($row = mysqli_fetch_assoc($result)) {
    $percentage = ($totalEvents > 0) ? round(($row['event_count'] / $totalEvents) * 100, 2) : 0;
    
    $clubPerformance[] = [
        'club' => $row['club'],
        'event_count' => $row['event_count'],
        'percentage' => $percentage
    ];
}

echo json_encode(['total_events' => $totalEvents, 'clubs' => $clubPerformance]);
?>
