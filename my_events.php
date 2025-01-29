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

?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">My Events</h3>
        </div>
        <div class="card-body p-3">
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
                    // Fetching event details including host and enrollment count for the logged-in user
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
                    GROUP BY events.event_id, events.event_name, events.capacity, events.event_date";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    $events = array();

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
        </div>
    </div>
</div>

<style>
    .table-hover tbody tr:hover {
        background-color: #f5f5f5;
    }
</style>

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
