<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $image_name = $_FILES['image']['name'];
    $image_tmp = $_FILES['image']['tmp_name'];
    $upload_dir = 'uploads/';
    $target_file = $upload_dir . basename($image_name);
    
    if (move_uploaded_file($image_tmp, $target_file)) {
        $stmt = $conn->prepare("INSERT INTO gallery (image_path) VALUES (?)");
        $stmt->bind_param("s", $target_file);
        $stmt->execute();
        $stmt->close();
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $stmt = $conn->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($image_path);
    $stmt->fetch();
    $stmt->close();
    
    if ($image_path && unlink($image_path)) {
        $stmt = $conn->prepare("DELETE FROM gallery WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Gallery</h2>
        <form action="gallery.php" method="POST" enctype="multipart/form-data" class="mb-3">
            <div class="input-group">
                <input type="file" name="image" class="form-control" required>
                <button type="submit" class="btn btn-primary">Upload</button>
            </div>
        </form>
        
        <div class="row">
            <?php
            $result = $conn->query("SELECT * FROM gallery ORDER BY id DESC");
            while ($row = $result->fetch_assoc()) {
                echo '<div class="col-md-4 mb-3">
                        <div class="card">
                            <img src="' . $row['image_path'] . '" class="card-img-top" style="height: 200px; object-fit: cover;" data-bs-toggle="modal" data-bs-target="#imageModal' . $row['id'] . '">
                            <div class="card-body text-center">
                                <a href="gallery.php?delete=' . $row['id'] . '" class="btn btn-danger btn-sm">Delete</a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal fade" id="imageModal' . $row['id'] . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body text-center">
                                    <img src="' . $row['image_path'] . '" class="img-fluid">
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>
        </div>
        <a href="edashboard.php" class="btn btn-info">Back to Dashboard</a>

    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>