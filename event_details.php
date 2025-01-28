<?php 
include("includes/header.php"); 
include("includes/db_connection.php");

// Fetch event details based on the event ID from the URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    
    $event_query = $conn->prepare("SELECT event_name, location, enrolled, max_capacity, status FROM events WHERE event_id = ?");
    $event_query->bind_param("i", $event_id);
    $event_query->execute();
    $event_query->bind_result($event_name, $location, $enrolled, $max_capacity, $status);
    $event_query->fetch();
    $event_query->close();
    
    $remaining = $max_capacity - $enrolled;
    
    // Fetch enrolled users
    $users_query = $conn->prepare("SELECT CONCAT(u.first_name, ' ', u.last_name) AS user_name, e.enrollment_date 
                                   FROM event_enrollments e 
                                   JOIN users u ON e.user_id = u.user_id 
                                   WHERE e.event_id = ?");
    $users_query->bind_param("i", $event_id);
    $users_query->execute();
    $users_query->bind_result($user_name, $enrollment_date);
    $enrolled_users = [];
    while ($users_query->fetch()) {
        $enrolled_users[] = ['user_name' => $user_name, 'enrollment_date' => $enrollment_date];
    }
    $users_query->close();
}
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
                    <li><?php echo htmlspecialchars($user['user_name'], ENT_QUOTES, 'UTF-8') . " - " . $user['enrollment_date']; ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>

<?php include("includes/footer.php"); ?>
