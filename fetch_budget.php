<?php
include 'config.php';

// Fetch total budget spent by each club
$query = "SELECT 'EDC' AS club, SUM(amount_spent) AS total_budget FROM event_expenses
          UNION ALL
          SELECT 'Cultural' AS club, SUM(amount_spent) FROM event_expensess
          UNION ALL
          SELECT 'Green' AS club, SUM(amount_spent) FROM event_expensesss";

$result = mysqli_query($conn, $query);
$budgetData = [];

while ($row = mysqli_fetch_assoc($result)) {
    $budgetData[] = [
        'club' => $row['club'],
        'total_budget' => $row['total_budget'] ? $row['total_budget'] : 0 // Default to 0 if NULL
    ];
}

echo json_encode($budgetData);
?>
