<?php 
include("includes/header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['adminEmail'])) {
    header("Location: login.php");
    exit();
}
// Fetch total counts
$totalEventsQuery = "SELECT COUNT(*) as total_events FROM events";
$totalUsersQuery = "SELECT COUNT(*) as total_users FROM users";
$totalBlogsQuery = "SELECT COUNT(*) as total_blogs FROM blogs";

$totalEventsResult = $conn->query($totalEventsQuery);
$totalUsersResult = $conn->query($totalUsersQuery);
$totalBlogsResult = $conn->query($totalBlogsQuery);

$totalEvents = $totalEventsResult->fetch_assoc()['total_events'];
$totalUsers = $totalUsersResult->fetch_assoc()['total_users'];
$totalBlogs = $totalBlogsResult->fetch_assoc()['total_blogs'];
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-calendar-alt fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Events</h5>
                        <p class="card-text"><?php echo $totalEvents; ?></p>
                        <a href="events.php" class="btn btn-light">View Events</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-users fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text"><?php echo $totalUsers; ?></p>
                        <a href="users.php" class="btn btn-light">View Users</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-danger text-white mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-blog fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title">Total Blogs</h5>
                        <p class="card-text"><?php echo $totalBlogs; ?></p>
                        <a href="blogs.php" class="btn btn-light">View Blogs</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-user fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title">Profile</h5>
                        <p class="card-text">Manage Profile</p>
                        <a href="admin_profile.php" class="btn btn-light">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark mb-3">
                <div class="card-body d-flex align-items-center">
                    <i class="fas fa-cogs fa-2x me-3"></i>
                    <div>
                        <h5 class="card-title">Settings</h5>
                        <p class="card-text">Manage Settings</p>
                        <a href="error.php" class="btn btn-light">View Settings</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row for Charts -->
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    User Growth
                </div>
                <div class="card-body">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Event Participation
                </div>
                <div class="card-body">
                    <canvas id="eventParticipationChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$conn->close();
include("includes/footer.php"); 
?>

<!-- Add FontAwesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

<!-- Chart.js for charts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth Chart
    var ctx = document.getElementById('userGrowthChart').getContext('2d');
    var userGrowthChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June'],
            datasets: [{
                label: 'User Growth',
                data: [5, 10, 15, 20, 25, 30],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
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

    // Event Participation Chart
    var ctx2 = document.getElementById('eventParticipationChart').getContext('2d');
    var eventParticipationChart = new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: ['Event 1', 'Event 2', 'Event 3', 'Event 4'],
            datasets: [{
                label: 'Participants',
                data: [12, 19, 3, 5],
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
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
</script>
