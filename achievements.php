<?php
include 'config.php'; // Ensure this file contains the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $student_name = trim($_POST['student_name']);
    $competition_name = trim($_POST['competition_name']);
    $position = trim($_POST['position']);
    $date = $_POST['date'];
    $additional_info = trim($_POST['additional_info']);

    // Insert data into the database
    $query = "INSERT INTO achievements (student_name, competition_name, position, date, additional_info) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sssss", $student_name, $competition_name, $position, $date, $additional_info);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Fetch achievements from the database
$result = mysqli_query($conn, "SELECT * FROM achievements ORDER BY date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Achievements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="text-center mb-4">Student Achievements</h2>


    <!-- Achievements List -->
    <h4 class="mb-3">Club Achievements</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Student Name</th>
                <th>Competition</th>
                <th>Position</th>
                <th>Date</th>
                <th>Additional Info</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['student_name']; ?></td>
                    <td><?php echo $row['competition_name']; ?></td>
                    <td><?php echo $row['position']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['additional_info']; ?></td>
                 
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <form method="POST" class="mb-4 p-4 border rounded shadow-sm bg-light">
        <div class="mb-3">
            <label class="form-label">Student Name</label>
            <input type="text" name="student_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Competition Name</label>
            <input type="text" name="competition_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Position Achieved</label>
            <input type="text" name="position" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Additional Info (Optional)</label>
            <textarea name="additional_info" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Achievement</button>
    </form>

    <a href="cdashboard.php" class="btn btn-warning">Back to Dashboard</a>

</body>
</html>
