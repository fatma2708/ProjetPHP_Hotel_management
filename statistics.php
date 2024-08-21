<?php
require 'controllers/BookingController.php';

$controller = new BookingController();
$data = $controller->getStatistics(); // Get statistics data

// Prepare the data for the pie chart
$chartData = [
    'totalBookings' => $data['totalBookings'],
    'totalRevenue' => $data['totalRevenue'],
    'averageDuration' => $data['averageDuration']
];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Statistics</title>
    <style>
        body {
            font-family: "Lato", sans-serif;
            color: #333;
            background-image: url(assets/img/hero_2.jpg);
            background-size: cover;
            margin: 0;
            padding: 20px;
        }
        .statistics {
            width: 100%;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            font-family: "Lato", sans-serif;
        }
        .statistics h2 {
            color: rgb(57, 5, 57);
            font-size: 1.5em;
            margin-top: 0;
        }
        .statistics p {
            margin: 10px 0;
        }
        canvas {
            max-width: 600px;
            margin: auto;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <h1>Statistiques</h1>
    <div class="statistics">
        <h2>Statistiques de réservations</h2>
        <p><strong>Total réservations:</strong> <?php echo htmlspecialchars($data['totalBookings']); ?></p>
        <p><strong>Total Revenus:</strong> <?php echo htmlspecialchars($data['totalRevenue']); ?> EUR</p>
        <p><strong>Moyenne durée du séjour:</strong> <?php echo htmlspecialchars(number_format($data['averageDuration'], 2)); ?> nuitées</p>

        <!-- Pie Chart -->
        <canvas id="statisticsChart"></canvas>
    </div>

    <script>
        // Data from PHP
        const chartData = <?php echo json_encode($chartData); ?>;
        
        // Create the pie chart
        const ctx = document.getElementById('statisticsChart').getContext('2d');
        const statisticsChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Total Bookings', 'Total Revenue', 'Average Booking Duration'],
                datasets: [{
                    label: 'Booking Statistics',
                    data: [chartData.totalBookings, chartData.totalRevenue, chartData.averageDuration],
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffce56'],
                    borderColor: ['#fff', '#fff', '#fff'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
