<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sessions Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<div class="container mt-5">
    <!-- Filter Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Filter Login Sessions</h3>
        </div>
        <div class="card-body">
        <form method="get" action="<?= base_url('dashboard/index'); ?>" class="row">
            <div class="col-md-3 mb-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?= $start_date; ?>" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?= $end_date; ?>" class="form-control" required>
            </div>
            <div class="col-md-3 mb-3">
                <button type="submit" class="btn btn-primary mt-4">Filter</button>
            </div>
        </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h3>Login Sessions</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Username</th>
                        <th>Login Time</th>
                        <th>Session Duration (minutes)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($login_sessions as $session): ?>
                    <tr>
                        <td><?= $session['user_id']; ?></td>
                        <td><?= $session['username']; ?></td>
                        <td><?= $session['login_time']; ?></td>
                        <td><?= $session['session_duration']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination Links -->
            <div class="pagination justify-content-center">
                   <?= isset($pagination_links) ? $pagination_links : ''; ?>

            </div>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="card">
        <div class="card-header">
            <h3>Peak Hours</h3>
        </div>
        <div class="card-body">
            <canvas id="peakHoursChart" width="400" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Prepare the data for the chart
var peakHoursData =   <?= $chart_data ?>;
var labels = [];
var data = [];

peakHoursData.forEach(function (item) {
    labels.push(item.hour + ":00");
    data.push(item.login_count);
});

// Create the chart
var ctx = document.getElementById('peakHoursChart').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Logins',
            data: data,
            borderColor: 'rgba(75, 192, 192, 1)',
            tension: 0.1,
            fill: false
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>

</body>
</html>
