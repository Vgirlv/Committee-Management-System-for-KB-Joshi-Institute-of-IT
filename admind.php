<?php
include 'config.php';
session_start();
include 'config.php';

if (!isset($_SESSION["user_id"])) {
    header("Location: adminlogin.php"); // Redirect to login if not authenticated
    exit();
}

$admin_name = $_SESSION["admin_name"]; 
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
    <title>EDC Club Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
        }

        .navbar {
            z-index: 1050;
            background-color:rgb(167, 46, 148);

        }

        .content-wrapper {
            display: flex;
            margin-top: 56px;
        }

        .sidebar {
            width: 250px;
            height: calc(100vh - 56px);
            position: fixed;
            background-color:rgb(255, 203, 248);
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
.card {
    margin: 5px 0; /* Adds vertical spacing between cards */
    padding: 15px; /* More padding for a balanced look */
    width: 80%; /* Avoids full stretch */
    min-height: 80px; /* Prevents too tall cards */
    border-radius: 10px; /* Soft rounded corners */
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
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container-fluid">
            <strong class="navbar-brand text-white">Admin Panel</strong>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse ms-3" id="navbarNav">
                <ul class="navbar-nav ms-auto bg-white">
                <li class="nav-item"><a class="nav-link text-dark fw-bold" href="report.html">Annual Report</a></li>
                    <li class="nav-item"><a class="nav-link text-danger fw-bold" href="logoutad.php">Logout</a></li>

                   
                </ul>
                
            </div>
        </div>
    </nav>

    <div class="content-wrapper">
        <div class="sidebar">
            <div class="profile-pic">
                <img id="profileImage" src="1687949579phpTiCTiI.jpeg" alt=" ">
                <input type="file" id="fileInput" accept="image/*" />
            </div>

            <h4 class="text-center"> KBJIIT | CMS</h4>
            <strong class="text-center">Committe Admin Name:</strong>
            <p>🔹Manali Sapkal<br>🔹Anagha Vaidya</p>

            <strong>Objectives:</strong>
            <ul>
                <li> Organize Events for Skill Development</li>
                <li> Support Student-led Initiatives</li>
                <li> Maintain Transparency and Efficient Management</li>
            </ul>
        </div>
    </div>
    </div>


    <div class="main-content">
    <div class="container mt-3">
        <h2>Welcome,  <?php echo htmlspecialchars($admin_name); ?>!</h2>
        <h5>Manage and track all committee activities here.</h5>
        <div class="d-flex align-items-center">
  

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
        url: "search.php",
        method: "POST",
        data: { search: query },
        success: function (data) {
            $("#search-results").html(data); // Display results only when input is provided
        }
    });
}
</script>


    <h3 class="mt-3">KBJCommit-Con | Management</h3>
    <h3 class="mt-3"><br></h3>
    <div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-info p-3" style="min-height: 100px; border-radius: 10px; margin-left: 0px;">
            <h5 class="mb-1">EDC Events</h5>
            <p class="fs-5 mb-0"><?php echo $edcEvents; ?></p>
        </div>
    </div>
    <div class="col-md-4" style="margin-left: -90px;"> <!-- Shifted left -->
        <div class="card text-white bg-warning p-3" style="min-height: 100px; border-radius: 10px;">
            <h5 class="mb-1">Cultural Events</h5>
            <p class="fs-5 mb-0"><?php echo $culturalEvents; ?></p>
        </div>
    </div>
    <div class="col-md-4" style="margin-left: -90px;"> <!-- Shifted more left -->
        <div class="card text-white bg-success p-3" style="min-height: 100px; border-radius: 10px;">
            <h5 class="mb-1">Green Events</h5>
            <p class="fs-5 mb-0"><?php echo $greenEvents; ?></p>
        </div>
    </div>
</div>

<div class="container-fluid mt-4">
    <div class="card shadow-lg p-3">
        <h2 class="text-center mb-4">📊 Club Budget Tracker</h2>

        <table class="table table-bordered table-hover text-center">
            <thead class="table-dark">
                <tr>
                    <th>🏛 Club</th>
                    <th>💰 Total Budget Spent</th>
                </tr>
            </thead>
            <tbody id="budgetTable" class="table-light"></tbody>
        </table>
    </div>
</div>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: 'fetch_budget.php',
                method: 'GET',
                success: function (response) {
                    var data = JSON.parse(response);
                    var tableContent = '';

                    data.forEach(function (row) {
                        tableContent += `<tr>
                            <td>${row.club}</td>
                            <td>₹ ${parseFloat(row.total_budget).toFixed(2)}</td>
                        </tr>`;
                    });

                    $("#budgetTable").html(tableContent);
                },
                error: function () {
                    alert("Failed to load budget data.");
                }
            });
        });
    </script>


        
<div class="container-fluid mt-3">
    <h3 class="mt-4">All Events</h3>
    <div class="row">
        <div class="col-md-8"> <!-- Reduce width so it moves left -->
            <table class="table table-striped table-bordered mt-3">
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
    </div>
</div>

<div class="row">
    <div class="col-md-5 ms-0"> <!-- Aligned to the extreme left -->
        <div class="card shadow-sm p-2 mt-3 mb-5">
            <h4 class="text-center">🏆 Club Performance</h4>

            <h6 class="text-center text-primary mb-2">
                🔢 Total Events: <span id="totalEvents">0</span>
            </h6>

            <div style="width: 150%; height: 250px;">
                <canvas id="clubPerformanceChart"></canvas>
            </div>
        </div>
    </div>
</div>



<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        fetch('fetch_club_performance.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('totalEvents').textContent = data.total_events;

                let clubNames = data.clubs.map(item => item.club);
                let eventCounts = data.clubs.map(item => item.event_count);
                let percentages = data.clubs.map(item => item.percentage);
                
                let colors = ['#FF6384', '#36A2EB', '#4CAF50']; // Unique colors for each club

                let ctx = document.getElementById('clubPerformanceChart').getContext('2d');
                new Chart(ctx, {
                    type: 'pie',
                    data: {
                        labels: clubNames.map((name, index) => `${name} (${percentages[index]}%)`),
                        datasets: [{
                            label: 'Events Organized',
                            data: eventCounts,
                            backgroundColor: colors,
                            hoverOffset: 10
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom'
                            },
                            tooltip: {
                                callbacks: {
                                    label: function (tooltipItem) {
                                        let clubIndex = tooltipItem.dataIndex;
                                        return `${clubNames[clubIndex]}: ${eventCounts[clubIndex]} events (${percentages[clubIndex]}%)`;
                                    }
                                }
                            }
                        }
                    }
                });
            })
            .catch(error => console.error("Error loading data:", error));
    });
</script>

    <div class="footer">
        &copy; 2025 KBJCommit-Con. All rights reserved.
        <a href="ecell.html">EDC Committee</a>
        | <a href="cult.html">Cultural Committee</a> |
        <a href="grc.html">Green Committee</a>

    </div>






    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
