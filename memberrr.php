<?php
include('config.php'); // Include the database connection
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginnn.php");
    exit();
}

// Handle new member addition
if (isset($_POST['add_memberrr'])) {
    $name = $_POST['name'];
    $role = $_POST['role'];
    
    $query = "INSERT INTO membersss (name, role) VALUES (?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $name, $role);
    $stmt->execute();
    $stmt->close();
    header("Location: memberrr.php");
    exit();
}

// Fetch existing members
$query = "SELECT * FROM membersss ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members Management</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5 bg-success">
        <h2 class="text-center text-white">Manage Your Committee Members</h2>



        <!-- Members List -->
        <div class="card p-4 shadow-sm mt-4">
            <h4>Existing Members</h4>
            <table class="table table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['role']; ?></td>
                            <td>
                            <button class="btn btn-danger delete-btn" data-id="<?php echo $row['id']; ?>">Delete</button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>

                <!-- Add Member Form -->
                <div class="card p-4 shadow-sm mt-4">
            <h4>Add a New Member</h4>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Role</label>
                    <input type="text" name="role" class="form-control" required>
                </div>
                <button type="submit" name="add_memberrr" class="btn btn-primary">Add Member</button>
            </form>
        </div>
        <h1>   </h1>
        <a href="gdashboard.php" class="btn btn-light">Back to Dashboard</a>
        </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(".delete-btn").click(function() {
            var member_id = $(this).data("id");

            if (confirm("Are you sure you want to delete this member?")) {
                $.ajax({
                    url: "delete_memberrr.php",
                    type: "POST",
                    data: { member_id: member_id },
                    success: function(response) {
                        alert(response); // Show message
                        $("#row-" + member_id).remove(); // Remove row from table
                    },
                    error: function(xhr, status, error) {
                        alert("Error: " + error);
                    }
                });
            }
        });
    });
</script>

</body>
</html>
