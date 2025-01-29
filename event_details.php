<?php 
include("includes/header.php");
session_start();

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Event ID is required.");
}

$event_id = intval($_GET['id']);

// Fetch event details
$eventQuery = "SELECT event_name, event_type, host_id, event_place, event_date, event_description, status, capacity FROM events WHERE event_id = ?";
$stmt = $conn->prepare($eventQuery);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$eventResult = $stmt->get_result();

if ($eventResult->num_rows === 0) {
    echo "<script>window.open('error.php','_self')</script>";
}

$event = $eventResult->fetch_assoc();

$event_name = $event['event_name'];
$location = $event['event_place'];
$max_capacity = $event['capacity'];
$status = $event['status'];

// Fetch enrollment count
$enrollmentQuery = "SELECT COUNT(*) as enrolled FROM event_enrollments WHERE event_id = ?";
$stmt = $conn->prepare($enrollmentQuery);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$enrollmentResult = $stmt->get_result();
$enrollmentData = $enrollmentResult->fetch_assoc();
$enrolled = $enrollmentData['enrolled'];
$remaining = $max_capacity - $enrolled;

// Fetch enrolled users
$usersQuery = "SELECT users.first_name, users.last_name, event_enrollments.enrollment_date 
               FROM event_enrollments 
               JOIN users ON event_enrollments.user_id = users.user_id 
               WHERE event_enrollments.event_id = ? ORDER BY event_enrollments.enrollment_date";
$stmt = $conn->prepare($usersQuery);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$usersResult = $stmt->get_result();
$enrolled_users = $usersResult->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Event Details</h3>
        </div>
        <div class="card-body p-3">
            <p><strong>Event:</strong> <?php echo htmlspecialchars($event_name, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Location:</strong> <?php echo htmlspecialchars($location, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Enrolled:</strong> <?php echo $enrolled; ?> / <?php echo $max_capacity; ?></p>
            <p><strong>Remaining:</strong> <?php echo $remaining; ?></p>
            <div class="d-flex align-items-center mb-3">
                <p><strong>Event Status:</strong> <?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></p>
                <?php if ($remaining == 0): ?>
                    <button class="btn btn-success ms-2" disabled>Enroll</button>
                <?php else: ?>
                    <button class="btn btn-success ms-2">Enroll</button>
                <?php endif; ?>
            </div>
            <h5>Enrolled Users:</h5>
            <ol>
                <?php foreach ($enrolled_users as $user): ?>
                    <li><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8') . " - " . $user['enrollment_date']; ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
