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

    // Fetch fund details
    $fund_query = "SELECT * FROM event_expensess WHERE event_id = $event_id";
    $fund_result = mysqli_query($conn, $fund_query);
    $fund = mysqli_fetch_assoc($fund_result);

    // Fetch existing report details (if any)
    $report_query = "SELECT * FROM event_reportss WHERE event_id = $event_id";
    $report_result = mysqli_query($conn, $report_query);
    $report = mysqli_fetch_assoc($report_result);
}

// Handle file uploads and form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conclusion = mysqli_real_escape_string($conn, $_POST['conclusion']);
    $guests = mysqli_real_escape_string($conn, $_POST['guests']);
    $sponsors = mysqli_real_escape_string($conn, $_POST['sponsors']);
    $schedule = mysqli_real_escape_string($conn, $_POST['schedule']);

    // File Upload Handling
    $upload_dir = "uploads/";
    if (!is_dir($upload_dir)) mkdir($upload_dir);

    $agenda_path = $report['agenda_path'] ?? ""; // Keep existing if not updated
    if (!empty($_FILES['agenda']['name'])) {
        $agenda_path = $upload_dir . basename($_FILES['agenda']['name']);
        move_uploaded_file($_FILES['agenda']['tmp_name'], $agenda_path);
    }

    $image_path = $report['image_path'] ?? ""; // Keep existing if not updated
    if (!empty($_FILES['event_image']['name'])) {
        $image_path = $upload_dir . basename($_FILES['event_image']['name']);
        move_uploaded_file($_FILES['event_image']['tmp_name'], $image_path);
    }

    if ($report) {
        // Update existing report
        $update_query = "UPDATE event_reportss SET 
            conclusion='$conclusion', 
            guests='$guests', 
            sponsors='$sponsors', 
            schedule='$schedule', 
            agenda_path='$agenda_path', 
            image_path='$image_path' 
            WHERE event_id = '$event_id'";
        mysqli_query($conn, $update_query);
    } else {
        // Insert new report
        $insert_query = "INSERT INTO event_reportss 
            (event_id, conclusion, guests, sponsors, schedule, agenda_path, image_path) 
            VALUES ('$event_id', '$conclusion', '$guests', '$sponsors', '$schedule', '$agenda_path', '$image_path')";
        mysqli_query($conn, $insert_query);
    }

    echo "<script>alert('Report Updated Successfully!'); window.location.href='view_reports.php?id=$event_id';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Event Report</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2><?php echo $event['event_name']; ?> - Report</h2>
    <p><strong>Date:</strong> <?php echo $event['event_date']; ?></p>
    <p><strong>Venue:</strong> <?php echo $event['venue']; ?></p>
    <p><strong>Description:</strong> <?php echo $event['description']; ?></p>
    
    <?php if ($fund): ?>
        <h3>Funding Details</h3>
        <p><strong>Amount:</strong> <?php echo $fund['amount']; ?></p>
        <p><strong>Source:</strong> <?php echo $fund['source']; ?></p>
    <?php endif; ?>

    <?php if ($report): ?>
        <h3 class="mt-4">Report Summary</h3>
        <p><strong>Conclusion:</strong> <?php echo nl2br($report['conclusion']); ?></p>
        <p><strong>Guest Details:</strong> <?php echo nl2br($report['guests']); ?></p>
        <p><strong>Sponsor Details:</strong> <?php echo nl2br($report['sponsors']); ?></p>
        <p><strong>Schedule:</strong> <?php echo nl2br($report['schedule']); ?></p>

        <?php if (!empty($report['agenda_path'])): ?>
            <p><strong>Agenda:</strong> <a href="<?php echo $report['agenda_path']; ?>" target="_blank">View File</a></p>
        <?php endif; ?>

        <?php if (!empty($report['image_path'])): ?>
            <p><strong>Event Image:</strong><br> <img src="<?php echo $report['image_path']; ?>" width="200"></p>
        <?php endif; ?>
    <?php endif; ?>

    <h3 class="mt-4">Update Report Details</h3>
    <form method="POST" enctype="multipart/form-data">
        <label class="form-label">Conclusion:</label>
        <textarea class="form-control" name="conclusion" required><?php echo $report['conclusion'] ?? ''; ?></textarea>

        <label class="form-label mt-2">Guest Details:</label>
        <textarea class="form-control" name="guests"><?php echo $report['guests'] ?? ''; ?></textarea>

        <label class="form-label mt-2">Sponsor Details:</label>
        <textarea class="form-control" name="sponsors"><?php echo $report['sponsors'] ?? ''; ?></textarea>

        <label class="form-label mt-2">Schedule:</label>
        <textarea class="form-control" name="schedule"><?php echo $report['schedule'] ?? ''; ?></textarea>
        
        <label class="form-label mt-2">Upload Agenda (PDF, DOCX):</label>
        <input type="file" class="form-control" name="agenda">
        <?php if (!empty($report['agenda_path'])): ?>
            <p>Current File: <a href="<?php echo $report['agenda_path']; ?>" target="_blank">View Agenda</a></p>
        <?php endif; ?>

        <label class="form-label mt-2">Upload Event Images:</label>
        <input type="file" class="form-control" name="event_image">
        <?php if (!empty($report['image_path'])): ?>
            <p>Current Image:<br> <img src="<?php echo $report['image_path']; ?>" width="100"></p>
        <?php endif; ?>

        <button type="submit" class="btn btn-primary mt-3">Submit Report</button>
        <a href="view_final_reports.php?id=<?php echo $event_id; ?>" class="btn btn-success mt-3">
    View Final Report
</a>

    </form>
</div>
</body>
</html>
