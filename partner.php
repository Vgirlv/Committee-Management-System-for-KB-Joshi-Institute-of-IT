<?php
include 'config.php'; // Make sure this file contains database connection code

// Handle form submission for adding a new partner
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["add_partner"])) {
    $ecell_name = $_POST["ecell_name"];
    $college_name = $_POST["college_name"];
    $social_media_link = $_POST["social_media_link"];
    $website_link = $_POST["website_link"];

    $sql = "INSERT INTO partners (ecell_name, college_name, social_media_link, website_link) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $ecell_name, $college_name, $social_media_link, $website_link);

    if ($stmt->execute()) {
        echo "<script>alert('Partner added successfully!'); window.location.href='partner.php';</script>";
    } else {
        echo "<script>alert('Error adding partner!');</script>";
    }
}

// Handle delete request
if (isset($_GET["delete"])) {
    $id = $_GET["delete"];

    $sql = "DELETE FROM partners WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Partner deleted successfully!'); window.location.href='partner.php';</script>";
    } else {
        echo "<script>alert('Error deleting partner!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Partners</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Manage Partners</h2>

    <!-- Form to Add Partner -->
    <div class="card shadow p-4">
        <h4>Add New Partner</h4>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">E-Cell Name</label>
                <input type="text" class="form-control" name="ecell_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">College Name</label>
                <input type="text" class="form-control" name="college_name" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Social Media Link</label>
                <input type="url" class="form-control" name="social_media_link">
            </div>
            <div class="mb-3">
                <label class="form-label">Website Link</label>
                <input type="url" class="form-control" name="website_link">
            </div>
            <button type="submit" class="btn btn-success" name="add_partner">Add Partner</button>
        </form>
    </div>

    <!-- Display Partners -->
    <div class="mt-5">
        <h4>Existing Partners</h4>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>E-Cell Name</th>
                    <th>College Name</th>
                    <th>Social Media</th>
                    <th>Website</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM partners");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['ecell_name']}</td>
                            <td>{$row['college_name']}</td>
                            <td><a href='{$row['social_media_link']}' target='_blank'>Social Link</a></td>
                            <td><a href='{$row['website_link']}' target='_blank'>Website</a></td>
                            <td><a href='partner.php?delete={$row['id']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a></td>
                          </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <h1>   </h1>
    <a href="edashboard.php" class="btn btn-primary">Back to Dashboard</a>
</div>

</body>
</html>
