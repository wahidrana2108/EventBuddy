<?php 
include("includes/header.php");
// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Get the logged-in user's email
$user_email = $_SESSION['user_email'];

// Fetch the logged-in user's ID
$userQuery = "SELECT user_id FROM users WHERE user_email = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$userResult = $stmt->get_result();
$userData = $userResult->fetch_assoc();
$user_id = $userData['user_id'];

// Pagination settings
$limit = 10; // Number of events per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of events for the user
$sql_count = "SELECT COUNT(*) AS total FROM events WHERE host_id = ?";
$stmt = $conn->prepare($sql_count);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result_count = $stmt->get_result();
$total_events = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_events / $limit);

// Sorting filter
$sort = isset($_GET['sort']) ? $_GET['sort'] : '';
$orderBy = "event_name ASC";
if ($sort === 'date') {
    $orderBy = "event_date DESC";
} elseif ($sort === 'name') {
    $orderBy = "event_name ASC";
}

// Fetching event details with pagination and sorting
$sql = "
SELECT 
    events.event_id, 
    events.event_name, 
    events.capacity AS max_capacity, 
    COUNT(event_enrollments.enrollment_id) AS enrolled, 
    DATE_FORMAT(events.event_date, '%Y-%m-%d') AS event_date 
FROM events 
LEFT JOIN event_enrollments ON events.event_id = event_enrollments.event_id 
WHERE events.host_id = ?
GROUP BY events.event_id, events.event_name, events.capacity, events.event_date
ORDER BY $orderBy
LIMIT $limit OFFSET $offset";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$events = array();
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">My Events</h3>
        </div>
        <div class="card-body p-3">
            <div class="d-flex justify-content-end mb-3">
                <select id="filter" class="form-select w-auto">
                    <option value="">Random</option>
                    <option value="name" <?php echo ($sort === 'name') ? 'selected' : ''; ?>>Sort by Name (A-Z)</option>
                    <option value="date" <?php echo ($sort === 'date') ? 'selected' : ''; ?>>Sort by Date (Newest)</option>
                </select>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Enrolled</th>
                        <th>Left</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="eventsTable">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $events[] = $row;
                            $remaining = $row["max_capacity"] - $row["enrolled"];
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["event_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . $row["enrolled"] . " / " . $row["max_capacity"] . "</td>";
                            echo "<td>" . $remaining . "</td>";
                            echo "<td><a href='my_event_details.php?id=" . $row["event_id"] . "' class='btn btn-dark'>Details</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' class='text-center'>No events found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
            
            <!-- Pagination -->
            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>&sort=<?php echo $sort; ?>">Previous</a></li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&sort=<?php echo $sort; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>&sort=<?php echo $sort; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

<script>
    document.getElementById('filter').addEventListener('change', function () {
        const selectedSort = this.value;
        window.location.href = '?page=1&sort=' + selectedSort;
    });
</script>


<script>
    function calculateRemainingDays(eventDate) {
        const today = new Date();
        const event = new Date(eventDate);
        const diffTime = event - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays > 0 ? diffDays : 0;
    }

    const events = <?php echo json_encode($events); ?>;

    events.forEach(event => {
        document.getElementById('daysRemaining' + event.event_id).textContent = calculateRemainingDays(event.event_date);
    });
</script>

<?php include("includes/footer.php"); ?>
