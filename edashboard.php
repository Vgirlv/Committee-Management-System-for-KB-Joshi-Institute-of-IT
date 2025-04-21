<?php
session_start();
include 'config.php'; // Ensure this file has a correct DB connection

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"]; // Get the logged-in user ID

// Fetch user name from the database
$query = "SELECT name FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $user_name = $row['name'];
} else {
    $user_name = "User"; // Fallback if name isn't found
}

// Fetch events from the database
$events_query = "SELECT * FROM events ORDER BY event_date DESC";
$events_result = mysqli_query($conn, $events_query);


$past_query = "SELECT * FROM events WHERE event_date < NOW() ORDER BY event_date DESC";
$past_result = mysqli_query($conn, $past_query);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDC Club Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .navbar {
            z-index: 1050;
        }

        .content-wrapper {
            display: flex;
            margin-top: 56px;
        }

        .sidebar {
            width: 250px;
            height: calc(100vh - 56px);
            position: fixed;
            background-color: #c4edff;
            padding: 20px;
            overflow-y: auto;
            top: 56px;
        }

        .main-content {
            margin-left: 270px;
            padding: 20px;
            width: 100%;
        }

        .profile-pic {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid #4B0082;
            margin: 0 auto 10px;
            position: relative;
        }

        .profile-pic img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #fileInput {
            position: absolute;
            bottom: 0;
            width: 100%;
            opacity: 0;
            cursor: pointer;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #e9ecef;
            position: fixed;
            bottom: 0;
            width: 100vw;
            left: 0;
        }


   
.list-group-item {
    margin-bottom: 10px;
    background-color:rgb(255, 255, 255);
    box-shadow: 2px 2px 5px rgba(0, 0, 0, 0.1); /* Optional: Adds a soft shadow effect */

 /* Adds space between event cards */
}

.event-info {
    flex-grow: 1;
    max-width: 80%;
}

.delete-btn {
    flex-shrink: 0;
}



    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-info fixed-top">
        <div class="container-fluid">
            <strong class="navbar-brand">Entrepreneurship Development Cell</strong>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-3" id="navbarNav">
                <ul class="navbar-nav ms-auto bg-white">
                    <li class="nav-item"><a class="nav-link" href="edashboard.php">Events</a></li>
                    <li class="nav-item"><a class="nav-link" href="member.php">Members</a></li>
                    <li class="nav-item"><a class="nav-link" href="partner.php">Partners</a></li>
                    <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link text-danger" href="logout.php">Logout</a></li>

                   
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="sidebar">
            <div class="profile-pic">
                <img id="profileImage" src="ecell.png" alt=" ">
                <input type="file" id="fileInput" accept="image/*" />
            </div>

            <h4 class="text-center">E-Cell KBJIIT</h4>
            <strong class="text-center">Committee Head Name:</strong>
            <p>Deepashree Pokhalekar<br>Shilpa Yadav</p>

            <strong>Objectives:</strong>
            <ul>
                <li>Fostering Entrepreneurial Mindset</li>
                <li>Promoting Innovation & Social Entrepreneurship</li>
                <li>Organizing Entrepreneurship Competitions & Events</li>
            </ul>
        </div>
    </div>
    </div>


    <div class="main-content">
    <div class="container mt-3">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <h5>Manage and track all committee activities here.</h5>
        <div class="d-flex align-items-center">
    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#createEventModal">
        Create Event
    </button>

    <input
        type="text"
        id="search-bar"
        class="form-control w-50"
        placeholder="Search Events..."
        onkeyup="searchEvents(this.value)"
    >
</div>

<div id="search-results" class="list-group mt-3">
    <!-- Results will appear here dynamically -->
</div>

    </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function searchEvents(query) {
    if (query.trim() === "") {
        // If search bar is empty, hide the search results
        $("#search-results").html(""); 
        return;
    }

    $.ajax({
        url: "search_events.php",
        method: "POST",
        data: { search: query },
        success: function (data) {
            $("#search-results").html(data); // Display results only when input is provided
        }
    });
}
</script>


    <h3 class="mt-4">Upcoming Events</h3>
    <h3 class="mt-4"><br></h3>

<div class="container-fluid"> <!-- Changed to fluid to respect sidebar layout -->
    <div class="row">
        <div class="col-md-8"> <!-- Keeps the width limited -->
            <div class="list-group">
                <?php while ($event = mysqli_fetch_assoc($events_result)) : ?>
                    <div class="list-group-item">
                        <div>
                            <h5><?php echo htmlspecialchars($event['event_name']); ?></h5>
                            <p><strong>Date:</strong> <?php echo htmlspecialchars($event['event_date']); ?></p>
                            <p><strong>Venue:</strong> <?php echo htmlspecialchars($event['venue']); ?></p>
                            <p><strong>Members:</strong> <?php echo htmlspecialchars($event['membersroles']); ?></p>
                            <p><strong>Funds Allocated:</strong> ₹<?php echo htmlspecialchars($event['funds_allocated']); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($event['description']); ?></p>   

                        </div>
                        <div>
        <!-- Funds Button -->
        <a href="funds.php?event_id=<?php echo $event['id']; ?>" class="btn btn-warning mt-2">Fund Details</a>

        <!-- Delete Button -->
        <button class="btn btn-danger delete-btn mt-2" data-id="<?php echo $event['id']; ?>">Delete Event</button>
    </div>


                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<h2 class="mt-5">Past Events</h2>
    <div class="row">
        <?php 
        $past = mysqli_query($conn, "SELECT * FROM events WHERE event_date < NOW() ORDER BY event_date DESC");
        while ($event = mysqli_fetch_assoc($past)) { ?>
            <div class="col-md-4 col-sm-6 mb-4">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $event['event_name']; ?></h5>
                        <p class="card-text"><?php echo $event['event_date']; ?></p>
                        <a href="view_report.php?id=<?php echo $event['id']; ?>" class="btn btn-primary">Create Report</a>
                        <a href="view_final_report.php?id=<?php echo $event['id']; ?>" class="btn btn-success">View Report</a>

                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
        </div>



<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let eventId = this.getAttribute("data-id");
            let eventElement = document.getElementById("event-" + eventId);

            if (confirm("Are you sure you want to delete this event?")) {
                fetch("delete_event.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + eventId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        eventElement.remove(); // Remove event from UI
                    } else {
                        alert("Failed to delete event.");
                    }
                })
                .catch(error => console.error("Error:", error));
            }
        });
    });
});
</script>

<!-- Bootstrap Modal for Agenda -->





    <!-- Create Event Modal -->
    <div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create Event</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="create_event.php" method="POST">
                        <div class="mb-3">
                            <label for="event_name" class="form-label">Event Name</label>
                            <input type="text" class="form-control" id="event_name" name="event_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="event_date" class="form-label">Date</label>
                            <input type="date" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="venue" class="form-label">Venue</label>
                            <input type="text" class="form-control" id="venue" name="venue" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Member-Role Allocation</label>
                        <input type="text" class="form-control" name="members" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Funds Allocated</label>
                        <input type="number" class="form-control" name="funds_allocated" required>
                    </div>


                        <div class="mb-3">
                            <label for="description" class="form-label">Event Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Event</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        &copy; 2025 EDC Club. All rights reserved.
        <a href="https://www.linkedin.com/company/e-cell-kbjiit?trk=public_post_follow-view-profile">LinkedIn</a>
        | <a href="https://www.instagram.com/e_cell_kbjiit/">Instagram</a>
    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
