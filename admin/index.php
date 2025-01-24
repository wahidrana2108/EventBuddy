<?php include("includes/header.php"); ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-light text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Events</h5>
                    <p class="card-text">10</p>
                    <a href="admin_events.php" class="btn btn-primary">View Events</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <p class="card-text">50</p>
                    <a href="admin_users.php" class="btn btn-primary">View Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Manage Settings</p>
                    <a href="admin_settings.php" class="btn btn-primary">View Settings</a>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-light text-dark mb-3">
                <div class="card-body">
                    <h5 class="card-title">Profile</h5>
                    <p class="card-text">Manage Profile</p>
                    <a href="admin_profile.php" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h4>Recent Activities</h4>
            <table class="table table-striped table-hover">
                <thead class="table-light">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Activity</th>
                        <th scope="col">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>Event "Amazing Birthday Party" created</td>
                        <td>2025-01-15</td>
                    </tr>
                    <tr>
                        <th scope="row">2</th>
                        <td>User "John Doe" registered</td>
                        <td>2025-01-16</td>
                    </tr>
                    <tr>
                        <th scope="row">3</th>
                        <td>Event "Corporate Meeting" updated</td>
                        <td>2025-01-17</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-md-6">
            <h4>Event Participation</h4>
            <canvas id="eventChart"></canvas>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <h4>User Registrations</h4>
            <canvas id="userChart"></canvas>
        </div>
        <div class="col-md-6">
            <h4>Event Status</h4>
            <canvas id="statusChart"></canvas>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctxEvent = document.getElementById('eventChart').getContext('2d');
    const eventChart = new Chart(ctxEvent, {
        type: 'bar',
        data: {
            labels: ['Event 1', 'Event 2', 'Event 3', 'Event 4'],
            datasets: [{
                label: '# of Participants',
                data: [12, 19, 3, 5],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(153, 102, 255, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
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

    const ctxUser = document.getElementById('userChart').getContext('2d');
    const userChart = new Chart(ctxUser, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April'],
            datasets: [{
                label: '# of Registrations',
                data: [3, 2, 2, 5],
                backgroundColor: 'rgba(153, 102, 255, 0.2)',
                borderColor: 'rgba(153, 102, 255, 1)',
                borderWidth: 1
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

    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    const statusChart = new Chart(ctxStatus, {
        type: 'doughnut',
        data: {
            labels: ['Running', 'Completed', 'Cancelled'],
            datasets: [{
                label: '# of Events',
                data: [10, 5, 2],
                backgroundColor: [
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(75, 192, 192, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Event Status Distribution'
                }
            }
        }
    });
</script>
