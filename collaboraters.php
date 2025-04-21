<?php
include 'config.php'; // Ensure DB connection

// Fetch existing collaborations
$result = $conn->query("SELECT * FROM collaborations ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Club Collaborations</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

    <h2 class="text-center">Green Club Collaborations</h2>

        <!-- Display Collaborations -->
        <h4>Existing Collaborations</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Organization</th>
                <th>Contact Person</th>
                <th>Email</th>
                <th>Details</th>
                <th>Website</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['organization_name'] ?></td>
                    <td><?= $row['contact_person'] ?></td>
                    <td><?= $row['contact_email'] ?></td>
                    <td><?= $row['collaboration_details'] ?></td>
                    <td><a href="<?= $row['website_link'] ?>" target="_blank">Visit</a></td>
                    <td>
                        <a href="delete_collab.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>


    <!-- Form to Add Collaboration -->
    <div class="card p-4 shadow-sm mb-4">
        <h4>Add New Collaboration</h4>
        <form action="add_collaborators.php" method="POST">
            <div class="mb-3">
                <label class="form-label">Organization Name</label>
                <input type="text" class="form-control" name="organization_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Person</label>
                <input type="text" class="form-control" name="contact_person" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contact Email</label>
                <input type="email" class="form-control" name="contact_email" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Collaboration Details</label>
                <textarea class="form-control" name="collaboration_details" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Website Link (Optional)</label>
                <input type="url" class="form-control" name="website_link">
            </div>
            <button type="submit" class="btn btn-success">Add Collaboration</button>
        </form>
    </div>


    <a href="gdashboard.php" class="btn btn-warning">Back to Dashboard</a>

</body>
</html>
