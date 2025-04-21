<?php
include 'config.php'; // Database connection

if (!isset($_GET['event_id'])) {
    die("Invalid request.");
}

$event_id = $_GET['event_id'];

// Fetch event funds data
$query = "SELECT event_name, funds_allocated FROM eventss WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    die("Event not found.");
}

// Fetch item-wise expenses
$expense_query = "SELECT * FROM event_expensess WHERE event_id = ?";
$expense_stmt = $conn->prepare($expense_query);
$expense_stmt->bind_param("i", $event_id);
$expense_stmt->execute();
$expenses_result = $expense_stmt->get_result();

// Calculate total spent amount
$total_spent = 0;
$expenses = [];
while ($row = $expenses_result->fetch_assoc()) {
    $expenses[] = $row;
    $total_spent += $row['amount_spent'];
}

$remaining_funds = $event['funds_allocated'] - $total_spent;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fund Details - <?php echo htmlspecialchars($event['event_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Funds Management for <?php echo htmlspecialchars($event['event_name']); ?></h2>

    <div class="card">
        <div class="card-body">
            <p><strong>Total Allocated Budget For The Event:</strong> ₹<?php echo number_format($event['funds_allocated'], 2); ?></p>
        </div>
    </div>

    <h3 class="mt-4">Expense Breakdown</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Amount Spent (₹)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($expenses as $expense): ?>
                <tr>
                    <td><?php echo htmlspecialchars($expense['item_name']); ?></td>
                    <td>₹<?php echo number_format($expense['amount_spent'], 2); ?></td>
                    <td>
                        <form action="delete_expenses.php" method="POST" style="display:inline;">
                            <input type="hidden" name="expense_id" value="<?php echo $expense['id']; ?>">
                            <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Add New Expense</h4>
    <form action="add_expenses.php" method="POST">
        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
        
        <div class="mb-3">
            <label for="item_name" class="form-label">Item Name</label>
            <input type="text" name="item_name" class="form-control" required>
        </div>
        
        <div class="mb-3">
            <label for="amount_spent" class="form-label">Amount Spent (₹)</label>
            <input type="number" step="0.01" name="amount_spent" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Add Expense</button>
        <h2>                                </h2>
    </form>

    
    <div class="card">
        <div class="card-body">
            <p><strong>Allocated Funds:</strong> ₹<?php echo number_format($event['funds_allocated'], 2); ?></p>
            <p><strong>Total Spent:</strong> ₹<?php echo number_format($total_spent, 2); ?></p>
            <p><strong>Remaining Funds:</strong> ₹<?php echo number_format($remaining_funds, 2); ?></p>
        </div>
    </div>

    <a href="cdashboard.php" class="btn btn-warning mt-3">Back to Dashboard</a>
</body>
</html>
