<?php 
include 'config.php'; // Include your DB connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $year = $_POST['year']; // Get year from form input
    $prev_year = $year - 1; // Previous year for comparison

    // SQL Query to get event stats per committee for the selected year
    $query = "SELECT 
                committee_name, 
                COUNT(*) AS total_events, 
                SUM(funds_allocated) AS total_funds_allocated, 
                COALESCE(SUM(amount_spent), 0) AS total_spent
              FROM (
                  SELECT 'EDC' AS committee_name, event_date, funds_allocated, ex.amount_spent 
                  FROM events e 
                  LEFT JOIN event_expenses ex ON e.id = ex.event_id 
                  UNION ALL
                  SELECT 'Cultural' AS committee_name, event_date, funds_allocated, ex.amount_spent 
                  FROM eventss e 
                  LEFT JOIN event_expensess ex ON e.id = ex.event_id 
                  UNION ALL
                  SELECT 'Green Club' AS committee_name, event_date, funds_allocated, ex.amount_spent 
                  FROM eventsss e 
                  LEFT JOIN event_expensesss ex ON e.id = ex.event_id 
              ) AS all_events
              WHERE YEAR(event_date) = ? 
              GROUP BY committee_name";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $year);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // Fetch previous year data for comparison
    $stmt_prev = $conn->prepare($query);
    $stmt_prev->bind_param("i", $prev_year);
    $stmt_prev->execute();
    $result_prev = $stmt_prev->get_result();
    $prev_data = $result_prev->fetch_all(MYSQLI_ASSOC);

    if ($data) {
        echo "<h2>Annual Report for $year</h2>";
        echo "<table border='1'>
                <tr>
                    <th>Committee</th>
                    <th>Total Events</th>
                    <th>Funds Allocated</th>
                    <th>Total Spent</th>
                    <th>Comparison with $prev_year</th>
                </tr>";
        
        $grand_total_events = 0;
        $grand_total_funds = 0;
        $grand_total_spent = 0;
        
        foreach ($data as $row) {
            $committee = $row['committee_name'];
            $prev_year_data = array_filter($prev_data, fn($p) => $p['committee_name'] === $committee);
            $prev_events = $prev_year_data ? reset($prev_year_data)['total_events'] : 0;
            $change = $row['total_events'] - $prev_events;
            
            echo "<tr>
                    <td>{$committee}</td>
                    <td>{$row['total_events']}</td>
                    <td>{$row['total_funds_allocated']}</td>
                    <td>{$row['total_spent']}</td>
                    <td>" . ($change >= 0 ? "+$change" : "$change") . " events</td>
                </tr>";
            
            $grand_total_events += $row['total_events'];
            $grand_total_funds += $row['total_funds_allocated'];
            $grand_total_spent += $row['total_spent'];
        }

        echo "<tr style='font-weight: bold;'>
                <td>Grand Total</td>
                <td>$grand_total_events</td>
                <td>$grand_total_funds</td>
                <td>$grand_total_spent</td>
                <td></td>
              </tr>";
        echo "</table>";
    } else {
        echo "No events found for the selected year!";
    }
    echo "<div style='margin-top: 20px;'>
    <a href='report.html' style='display: inline-block; padding: 10px 20px; background-color: rgb(202, 202, 202); color: black; text-decoration: none; border-radius: 5px; margin-right: 10px;'>Go Back</a>
    <a href='admind.php' style='display: inline-block; padding: 10px 20px; background-color: rgb(203, 203, 203); color: black; text-decoration: none; border-radius: 5px;'>Back to Dashboard</a>
  </div>";


}
?>
