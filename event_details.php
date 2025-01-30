<?php 
include("includes/header.php");

if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>window.open('error.php','_self')</script>";
    exit();
}

$event_id = intval($_GET['id']);
$user_email = $_SESSION['user_email'];

// Fetch user ID based on session email
$userQuery = "SELECT user_id FROM users WHERE user_email = ?";
$stmt = $conn->prepare($userQuery);
$stmt->bind_param("s", $user_email);
$stmt->execute();
$stmt->bind_result($user_id);
$stmt->fetch();
$stmt->close();

if (empty($user_id)) {
    echo "<script>window.open('error.php','_self')</script>";
    exit();
}

// Fetch event details
$eventQuery = "SELECT event_name, event_type, host_id, event_place, event_date, event_description, status, capacity FROM events WHERE event_id = ?";
$stmt = $conn->prepare($eventQuery);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$eventResult = $stmt->get_result();

if ($eventResult->num_rows === 0) {
    echo "<script>window.open('error.php','_self')</script>";
    exit();
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

// Check if the user is already enrolled
$checkEnrollmentQuery = "SELECT COUNT(*) as is_enrolled FROM event_enrollments WHERE event_id = ? AND user_id = ?";
$stmt = $conn->prepare($checkEnrollmentQuery);
$stmt->bind_param("ii", $event_id, $user_id);
$stmt->execute();
$checkEnrollmentResult = $stmt->get_result();
$checkEnrollmentData = $checkEnrollmentResult->fetch_assoc();
$is_enrolled = $checkEnrollmentData['is_enrolled'];

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
                <?php if ($is_enrolled): ?>
                    <button class="btn btn-success ms-2" disabled>Already Enrolled</button>
                <?php elseif ($remaining > 0 && $status === 'Running'): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="event_id" value="<?php echo $event_id; ?>">
                        <button type="submit" name="enroll" class="btn btn-success ms-2">Enroll</button>
                    </form>
                <?php else: ?>
                    <button class="btn btn-success ms-2" disabled>Enroll</button>
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

<?php 
if (isset($_POST['enroll'])) {
    $event_id = intval($_POST['event_id']);

    // Enroll user in the event
    $enrollQuery = "INSERT INTO event_enrollments (event_id, user_id, enrollment_date) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($enrollQuery);
    $stmt->bind_param("ii", $event_id, $user_id);
    $stmt->execute();
    
    if ($stmt->affected_rows > 0) {
        echo "<script>alert('You have successfully enrolled in the event.'); window.location.href='event_details.php?id=$event_id';</script>";
    } else {
        echo "<script>alert('Failed to enroll in the event. Please try again.'); window.location.href='event_details.php?id=$event_id';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include("includes/footer.php"); ?>
