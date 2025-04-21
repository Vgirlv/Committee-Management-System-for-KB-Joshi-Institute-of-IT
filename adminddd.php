<?php
include 'config.php'; // Include database connection file


// Check if user is logged in
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php"); // Redirect to login if not set
    exit();
}

// Get the admin name
$user_name = $_SESSION['user_name'];


// Fetch total number of events from each committee table
$edcEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM events"))['count'];
$culturalEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM eventss"))['count'];
$greenEvents = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM eventsss"))['count'];

$totalEvents = $edcEvents + $culturalEvents + $greenEvents;

// Fetch total number of members from each committee table
$edcMembers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM members"))['count'];
$culturalMembers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM memberss"))['count'];
$greenMembers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM membersss"))['count'];

$totalMembers = $edcMembers + $culturalMembers + $greenMembers;

// Fetch all events from all committees
$allEvents = mysqli_query($conn, "SELECT 'EDC' AS committee, event_name, event_date FROM events 
                                  UNION 
                                  SELECT 'Cultural' AS committee, event_name, event_date FROM eventss
                                  UNION 
                                  SELECT 'Green' AS committee, event_name, event_date FROM eventsss
                                  ORDER BY event_date DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <style>
  body {
    background-color: rgb(245, 236, 248);
    margin: 0;
    padding: 0;
}

.sidebar {
    width: 250px; /* Sidebar width */
    height: 100vh; /* Full height */
    position: fixed; /* Stays fixed on the left */
    top: 0;
    left: 0;
    background-color: rgb(58, 39, 55);
    color: white;
    padding: 20px;
    overflow-y: auto;
}

.main-content {
    margin-left: 250px; /* SAME as sidebar width */
    padding: 20px;
    min-height: 100vh;
    overflow-x: hidden;
}

/* Fix card layout */
.card-container {
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    margin-top: 20px;
}


/* Ensure footer does not overlap */
footer {
    margin-left: 250px; /* Match sidebar */
    width: calc(100% - 250px);
    background-color: rgb(222, 225, 227);
    padding: 10px;
    text-align: center;
}
.container {
    max-width: 100%;
}
.card {
        width: 80%; /* Adjust width */
        max-width: 200px; /* Limit maximum width */
        padding: 10px; /* Reduce padding */
        margin: auto; /* Center align */
    }

    /* Reduce font size inside cards */
    .card h4 {
        font-size: 16px; /* Smaller heading */
    }

    .card p {
        font-size: 20px; /* Reduce display-6 text size */
        font-weight: bold;
    }



    </style>
</head>
<body>
    
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Dashboard</a>
            <button class="btn btn-outline-light" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar">Menu</button>
        </div>
    </nav>
    

    <div class="main-content">
    <div class="container mt-3">
        <h2>Welcome, Admin</h2>
        <h5>Manage and track all committee activities here.</h5>
    </div>
</div>

   <!-- Static Sidebar -->
<div class="sidebar d-flex flex-column flex-shrink-0 p-3 bg-dark text-white">
    <!-- Profile Picture -->
    <div class="text-center">
        <img src="clgbuilding.jpeg" alt="Admin Profile" class="rounded-circle mb-3" width="100" height="100">
    </div>

    <!-- Committee Admin Name -->
    <h5 class="text-center">Admin Name</h5>
    
    <!-- Committee Objectives -->
    <p class="text-center text-muted">"Our mission is to empower innovation and collaboration."</p>
    
    <hr>

    <!-- Sidebar Links -->
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="admind.php" class="nav-link text-white">Dashboard</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Events</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Members</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Partners</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Gallery</a>
        </li>
        <li>
            <a href="#" class="nav-link text-white">Achievements</a>
        </li>
    </ul>

    <hr>
</div>

    <!-- Logout Button -->
    <div class="text-center">
        <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</div>

    
    <div class="container mt-5">
        <div class="row text-center">
            <div class="col-md-4">
                <div class="card text-white bg-primary p-2">
                    <h4>EDC Events</h4>
                    <p class="display-6"> <?php echo $edcEvents; ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-danger p-2">
                    <h4>Cultural Events</h4>
                    <p class="display-6"> <?php echo $culturalEvents; ?> </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-success p-2">
                    <h4>Green Events</h4>
                    <p class="display-6"> <?php echo $greenEvents; ?> </p>
                </div>
            </div>
        </div>
        
        <h3 class="mt-4">All Events</h3>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>Committee</th>
                    <th>Event Name</th>
                    <th>Event Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($allEvents)) { ?>
                    <tr>
                        <td><?php echo $row['committee']; ?></td>
                        <td><?php echo $row['event_name']; ?></td>
                        <td><?php echo $row['event_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    
    <!-- Footer -->
    <footer>
        &copy; 2025 KBJCommit-Con | Admin Panel
    </footer>
</body>
</html>
