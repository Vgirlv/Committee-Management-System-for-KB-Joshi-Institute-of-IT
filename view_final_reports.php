<?php
include 'config.php'; // Ensure database connection

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    
    // Fetch event details
    $query = "SELECT * FROM eventss WHERE id = $event_id";
    $result = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($result) > 0) {
        $event = mysqli_fetch_assoc($result);
    } else {
        die("Event not found!");
    }
    
    // Fetch report details
    $report_query = "SELECT * FROM event_reportss WHERE event_id = $event_id";
    $report_result = mysqli_query($conn, $report_query);
    $report = mysqli_fetch_assoc($report_result);

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Event Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4 bg-light">
    <h2><?php echo $event['event_name']; ?> - Final Report</h2>
    <p><strong>Date:</strong> <?php echo $event['event_date']; ?></p>
    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
    <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
    <p><strong>Allocated Budget:</strong> <?php echo $event['funds_allocated']; ?></p>
    <p><strong>Total Expenses:</strong> <?php echo $event['spent_amount']; ?></p>


    
  
    
    <?php if ($report): ?>
        <h3>Event Report Details</h3>
        <p><strong>Guest Details:</strong> <?php echo $report['guests']; ?></p>
        <p><strong>Sponsor Details:</strong> <?php echo $report['sponsors']; ?></p>
        <p><strong>Schedule:</strong> <?php echo $report['schedule']; ?></p>
        <p><strong>Conclusion:</strong> <?php echo $report['conclusion']; ?></p>

        
        <?php if (!empty($report['agenda_path'])): ?>
            <p><strong>Agenda:</strong> <a href="<?php echo $report['agenda_path']; ?>" target="_blank">View Agenda</a></p>
        <?php endif; ?>
        
        <?php if (!empty($report['image_path'])): ?>
            <p><strong>Event Image:</strong></p>
            <img src="<?php echo $report['image_path']; ?>" alt="Event Image" class="img-fluid" style="max-width: 500px;">
        <?php endif; ?>
    <?php else: ?>
        <p>No report details available yet.</p>
    <?php endif; ?>
    
</div>
    <div class="container mt-3 bg-light">
    <h2>   </h2>

<a href="cdashboard.php" class="btn btn-warning">Back to Dashboard</a>
<a href="download_reports.php?id=<?php echo $event['id']; ?>" class="btn btn-success">Download Report</a>

</div>


</body>
</html>
