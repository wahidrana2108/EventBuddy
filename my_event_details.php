<?php 
include("includes/header.php");
// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}
// Check if the event ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Event ID is required.");
}

$event_id = intval($_GET['id']);

// Fetch event details
$eventQuery = "SELECT event_name, event_place, event_date, event_description, status, capacity FROM events WHERE event_id = ?";
$stmt = $conn->prepare($eventQuery);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$eventResult = $stmt->get_result();

if ($eventResult->num_rows === 0) {
    die("Error: Event not found.");
}

$event = $eventResult->fetch_assoc();

$event_name = $event['event_name'];
$location = $event['event_place'];
$max_capacity = $event['capacity'];
$status = $event['status'];
$event_description = $event['event_description'];
$date = new DateTime($event['event_date']);
$formattedDate = $date->format('Y-m-d');

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
            <form id="updateEventForm" method="POST" action="update_event.php?id=<?php echo $event_id; ?>">
                <p><strong>Event:</strong> <?php echo htmlspecialchars($event_name, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Date:</strong> <?php echo $formattedDate; ?></p>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($location, ENT_QUOTES, 'UTF-8'); ?></p>
                <p><strong>Enrolled:</strong> <?php echo $enrolled; ?> / <?php echo $max_capacity; ?></p>
                <p><strong>Remaining:</strong> <?php echo $remaining; ?></p>
                <p><strong>Details:</strong> <?php echo htmlspecialchars($event_description, ENT_QUOTES, 'UTF-8'); ?></p>
                
                <div class="d-flex align-items-center mb-2">
                    <div class="me-2">
                        <label for="newCapacity" class="form-label text-muted">Edit Capacity:</label>
                        <input type="number" class="form-control" id="newCapacity" name="newCapacity" placeholder="New capacity" min="5" max="500" style="width: 150px;">
                        <div id="capacityError" class="text-danger mt-1" style="display: none;"></div>
                    </div>

                    <div>
                        <label for="eventDate" class="form-label text-muted">Edit Event Date:</label>
                        <input type="date" class="form-control" id="eventDate" name="eventDate" placeholder="dd/mm/yyyy" style="width: 150px;">
                        <div id="eventDateError" class="text-danger mt-1" style="display: none;">Event date must be at least tomorrow.</div>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-2">
                    <label for="eventDetails" class="form-label text-muted me-2">Edit Event Details:</label>
                    <input type="text" class="form-control" id="eventDetails" name="eventDetails" placeholder="Event details" style="width: 300px;">
                    <button type="submit" id="updateButton" class="btn btn-dark ms-2" disabled>Update</button>
                </div>
            </form>

            <div class="d-flex align-items-center mb-3">
                <p><strong>Event Status:</strong> <span id="eventStatus"><?php echo htmlspecialchars($status, ENT_QUOTES, 'UTF-8'); ?></span></p>
                <button class="btn btn-warning ms-2" id="holdButton">Hold</button>
                <button class="btn btn-danger ms-2" id="cancelButton">Cancel</button>
            </div>

            <h5>Enrolled Users: <button class="btn btn-primary" id="downloadCSV">Download Info</button></h5>
            <ol>
                <?php foreach ($enrolled_users as $user): ?>
                    <li><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8') . " - " . $user['enrollment_date']; ?></li>
                <?php endforeach; ?>
            </ol>
        </div>
    </div>
</div>

<script>
    const newCapacityField = document.getElementById('newCapacity');
    const capacityError = document.getElementById('capacityError');
    const eventDateField = document.getElementById('eventDate');
    const eventDateError = document.getElementById('eventDateError');
    const eventDetailsField = document.getElementById('eventDetails');
    const updateButton = document.getElementById('updateButton');
    const updateEventForm = document.getElementById('updateEventForm');
    const holdButton = document.getElementById('holdButton');
    const cancelButton = document.getElementById('cancelButton');
    const eventStatus = document.getElementById('eventStatus');

    function validateCapacity() {
        const capacity = parseInt(newCapacityField.value, 10);

        if (capacity < 5) {
            capacityError.textContent = 'At least 5 participants are needed.';
            capacityError.style.display = 'block';
            return false;
        } else if (capacity > 500) {
            capacityError.textContent = 'Maximum capacity is 500. Please contact the organizer at +8801770888280.';
            capacityError.style.display = 'block';
            return false;
        } else {
            capacityError.style.display = 'none';
            return true;
        }
    }

    function validateDate() {
        const today = new Date();
        const selectedDate = new Date(eventDateField.value);

        // Set today to 00:00:00 for comparison
        today.setHours(0, 0, 0, 0);

        if (selectedDate <= today) {
            eventDateError.style.display = 'block';
            return false;
        } else {
            eventDateError.style.display = 'none';
            return true;
        }
    }

    function validateForm() {
        const isCapacityValid = newCapacityField.value === '' || validateCapacity();
        const isDateValid = eventDateField.value === '' || validateDate();
        const isAnyFieldFilled = newCapacityField.value.trim() !== '' || eventDateField.value.trim() !== '' || eventDetailsField.value.trim() !== '';
        
        updateButton.disabled = !isCapacityValid || !isDateValid || !isAnyFieldFilled;
    }

    newCapacityField.addEventListener('input', validateForm);
    eventDateField.addEventListener('input', validateForm);
    eventDetailsField.addEventListener('input', validateForm);

    holdButton.addEventListener('click', function() {
        let newStatus = '';
        if (eventStatus.textContent === 'Hold') {
            newStatus = 'Running';
        } else {
            newStatus = 'Hold';
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                eventStatus.textContent = newStatus;
                holdButton.textContent = newStatus === 'Hold' ? 'Run' : 'Hold';
            } else {
                alert('Failed to update status.');
            }
        };
        xhr.send('event_id=<?php echo $event_id; ?>&status=' + newStatus);
    });

    cancelButton.addEventListener('click', function() {
        let newStatus = '';
        if (eventStatus.textContent === 'Cancelled') {
            newStatus = 'Running';
        } else {
            newStatus = 'Cancelled';
        }

        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'update_status.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
            if (xhr.status === 200) {
                eventStatus.textContent = newStatus;
                cancelButton.textContent = newStatus === 'Cancelled' ? 'Reactivate' : 'Cancel';
            } else {
                alert('Failed to update status.');
            }
        };
        xhr.send('event_id=<?php echo $event_id; ?>&status=' + newStatus);
    });
</script>

<script>
    document.getElementById('downloadCSV').addEventListener('click', function () {
        let csvContent = "data:text/csv;charset=utf-8,";
        csvContent += "Event Name,Date,Location,Total Seats\n";
        csvContent += "<?php echo htmlspecialchars($event_name, ENT_QUOTES, 'UTF-8'); ?>,<?php echo $formattedDate; ?>,<?php echo htmlspecialchars($location, ENT_QUOTES, 'UTF-8'); ?>,<?php echo $max_capacity; ?>\n\n";
        
        csvContent += "Attendee Name,Enrollment Date\n";
        <?php foreach ($enrolled_users as $user): ?>
            csvContent += "<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name'], ENT_QUOTES, 'UTF-8'); ?>,<?php echo $user['enrollment_date']; ?>\n";
        <?php endforeach; ?>
        
        const encodedUri = encodeURI(csvContent);
        const link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "Event_Buddy.csv");
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
    });
</script>

<?php include("includes/footer.php"); ?>
