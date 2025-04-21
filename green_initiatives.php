<?php
include 'config.php'; // Ensure this file contains the database connection

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $initiative_name = trim($_POST['initiative_name']);
    $description = trim($_POST['description']);
    $date = $_POST['date'];
    $impact = trim($_POST['impact']);

    // Insert data into the database
    $query = "INSERT INTO green_initiatives (initiative_name, description, start_date, impact) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssss", $initiative_name, $description, $date, $impact);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Fetch initiatives from the database
$result = mysqli_query($conn, "SELECT * FROM green_initiatives ORDER BY start_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Club Initiatives</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="text-center mb-4">Green Club Initiatives</h2>

    <!-- Initiatives List -->
    <h4 class="mb-3">Initiatives Taken</h4>
    <table class="table table-bordered table-hover">
        <thead class="table-dark">
            <tr>
                <th>Initiative Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Impact</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['initiative_name']; ?></td>
                    <td><?php echo $row['description']; ?></td>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['impact']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Initiative Submission Form -->
    <form method="POST" class="mb-4 p-4 border rounded shadow-sm bg-light">
        <div class="mb-3">
            <label class="form-label">Initiative Name</label>
            <input type="text" name="initiative_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Impact (Optional)</label>
            <textarea name="impact" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add Initiative</button>
    </form>

    <a href="gdashboard.php" class="btn btn-warning">Back to Dashboard</a>

</body>
</html>
