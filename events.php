<?php 
include("includes/header.php");
// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Pagination settings
$limit = 10; 
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Fetch total number of events
$sql_count = "SELECT COUNT(*) AS total FROM events WHERE status != 'Cancelled'";
$result_count = $conn->query($sql_count);
$total_events = $result_count->fetch_assoc()['total'];
$total_pages = ceil($total_events / $limit);

// Fetching event details with pagination
$sql = "
SELECT 
    events.event_id, 
    events.event_name, 
    users.first_name AS host_first_name, 
    users.last_name AS host_last_name, 
    events.capacity AS max_capacity, 
    COUNT(event_enrollments.enrollment_id) AS enrolled, 
    DATE_FORMAT(events.event_date, '%Y-%m-%d') AS event_date 
FROM events 
JOIN users ON events.host_id = users.user_id 
LEFT JOIN event_enrollments ON events.event_id = event_enrollments.event_id 
WHERE events.status != 'Cancelled'
GROUP BY events.event_id, events.event_name, users.first_name, users.last_name, events.capacity, events.event_date
LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);
$events = array();
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Events</h3>
        </div>
        <div class="card-body p-3">
            <div class="d-flex justify-content-end mb-3">
                <select id="filter" class="form-select w-auto">
                    <option value="">Random</option>
                    <option value="name">Sort by Name (A-Z)</option>
                    <option value="date">Sort by Name (Z-A)</option>
                </select>
            </div>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Host</th>
                        <th>Enrolled</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="eventsTable">
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $events[] = $row;
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["event_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row["host_first_name"] . ' ' . $row["host_last_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . $row["enrolled"] . " / " . $row["max_capacity"] . "</td>";
                            echo "<td><a href='event_details.php?id=" . $row["event_id"] . "' class='btn btn-dark'>Details</a></td>";
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
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a></li>
                    <?php endif; ?>
                    
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    const events = <?php echo json_encode($events); ?>;

    function shuffleArray(array) {
        for (let i = array.length - 1; i > 0; i--) {
            const j = Math.floor(Math.random() * (i + 1));
            [array[i], array[j]] = [array[j], array[i]];
        }
        return array;
    }

    document.getElementById('filter').addEventListener('change', function () {
        const filterValue = this.value;
        let sortedEvents;

        if (filterValue === 'name') {
            sortedEvents = events.sort((a, b) => a.event_name.localeCompare(b.event_name));
        } else if (filterValue === 'date') {
            sortedEvents = events.sort((a, b) => b.event_name.localeCompare(a.event_name));
        } else {
            sortedEvents = shuffleArray(events.slice());
        }

        const tableBody = document.getElementById('eventsTable');
        tableBody.innerHTML = '';

        sortedEvents.forEach(event => {
            const row = `<tr>
                <td>${event.event_name}</td>
                <td>${event.host_first_name} ${event.host_last_name}</td>
                <td>${event.enrolled} / ${event.max_capacity}</td>
                <td><a href="event_details.php?id=${event.event_id}" class="btn btn-dark">Details</a></td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    });
</script>

<?php include("includes/footer.php"); ?>
