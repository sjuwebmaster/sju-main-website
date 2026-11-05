<?php
// Simple access check (replace with your secret key)
$secret_key = 'sju_admin_2026'; 
if (!isset($_GET['key']) || $_GET['key'] !== $secret_key) {
    die("Access Denied. Use ?key=YOUR_KEY");
}

$json_file = 'stats.json';
if (!file_exists($json_file)) die("Data file not found. Run the python script first.");

$stats = json_decode(file_get_contents($json_file), true);
ksort($stats);
?>
<!DOCTYPE html>
<html>
<head>
    <title>SJU Server Monitoring - T3.Medium</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Segoe UI', sans-serif; padding: 20px; background: #f0f2f5; color: #333; }
        .card { background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); margin-bottom: 25px; }
        .peak-badge { display: inline-block; background: #ff4757; color: white; padding: 5px 15px; border-radius: 20px; font-size: 0.9em; margin-left: 10px; }
        select { padding: 8px; border-radius: 5px; border: 1px solid #ddd; font-size: 1em; }
        h2 { margin-top: 0; display: flex; align-items: center; }
    </style>
</head>
<body>

<div class="card">
    <h2>Daily Volume <small style="font-size: 0.5em; color: gray; margin-left: 10px;">(Last 30 Days)</small></h2>
    <canvas id="dailyChart" height="80"></canvas>
</div>

<div class="card">
    <h2>
        Hourly Analysis for 
        <select id="dayPicker" onchange="updateHourlyChart()" style="margin-left: 10px;">
            <?php foreach(array_reverse(array_keys($stats)) as $date): ?>
                <option value="<?php echo $date; ?>"><?php echo $date; ?></option>
            <?php endforeach; ?>
        </select>
        <span id="peakBadge" class="peak-badge"></span>
    </h2>
    <canvas id="hourlyChart" height="100"></canvas>
</div>

<script>
const fullData = <?php echo json_encode($stats); ?>;

// 1. DAILY CHART
const dailyCtx = document.getElementById('dailyChart').getContext('2d');
new Chart(dailyCtx, {
    type: 'bar',
    data: {
        labels: Object.keys(fullData),
        datasets: [{
            label: 'Total Requests',
            data: Object.values(fullData).map(d => d.total),
            // Highlight days with over 500k hits in orange
            backgroundColor: Object.values(fullData).map(d => d.total > 500000 ? '#ffa502' : '#2ed573')
        }]
    }
});

// 2. HOURLY CHART WITH PEAK MARKING
let hourlyChart;
const hourlyCtx = document.getElementById('hourlyChart').getContext('2d');

function updateHourlyChart() {
    const date = document.getElementById('dayPicker').value;
    const hourObj = fullData[date].hours;
    const peakHits = fullData[date].peak_hits;
    const peakHour = fullData[date].peak_hour;

    document.getElementById('peakBadge').innerText = `Peak: ${peakHits.toLocaleString()} hits at ${peakHour}:00`;

    if (hourlyChart) hourlyChart.destroy();

    hourlyChart = new Chart(hourlyCtx, {
        type: 'line',
        data: {
            labels: Object.keys(hourObj).map(h => h + ":00"),
            datasets: [{
                label: 'Requests',
                data: Object.values(hourObj),
                borderColor: '#1e90ff',
                backgroundColor: 'rgba(30, 144, 255, 0.1)',
                fill: true,
                tension: 0.4,
                // Highlight the specific Peak Hour with a larger Black point
                pointRadius: Object.keys(hourObj).map(h => h === peakHour ? 10 : 4),
                pointBackgroundColor: Object.keys(hourObj).map(h => h === peakHour ? '#000' : '#1e90ff'),
                pointBorderColor: '#fff'
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}

updateHourlyChart();
</script>
</body>
</html>