<?php 
    include("includes/header.php");

    // Check if the user is logged in
    if (!isset($_SESSION['user_email'])) {
        header("Location: login.php");
        exit();
}
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Create Event</h3>
        </div>
        <div class="card-body p-3">
            <form id="createEventForm"  method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="eventName" class="form-label text-muted">Event Name</label>
                    <input type="text" class="form-control" id="eventName" name="eventName" placeholder="Enter event name" required>
                </div>
                <div class="mb-2">
                    <label for="eventType" class="form-label text-muted">Event Type</label>
                    <select class="form-select" id="eventType" name="eventType" required>
                        <option value="">Select an event type</option>
                        <option value="conference">Conference</option>
                        <option value="meetup">Meetup</option>
                        <option value="workshop">Workshop</option>
                        <option value="seminar">Seminar</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="eventPlace" class="form-label text-muted">Event Place</label>
                    <input type="text" class="form-control" id="eventPlace" name="eventPlace" placeholder="Enter event place" required>
                </div>
                <div class="mb-2">
                    <label for="capacity" class="form-label text-muted">Capacity</label>
                    <input type="number" class="form-control" id="capacity" name="capacity" placeholder="Enter event capacity (5-500)" min="5" max="500" required>
                    <div id="capacityError" class="text-danger mt-1" style="display: none;"></div>
                </div>
                <div class="mb-2">
                    <label for="eventDate" class="form-label text-muted">Event Date</label>
                    <input type="date" class="form-control" id="eventDate" name="eventDate" placeholder="dd/mm/yyyy" required>
                    <div id="eventDateError" class="text-danger mt-1" style="display: none;">Event date must be at least tomorrow.</div>
                </div>
                <div class="mb-2">
                    <label for="eventDescription" class="form-label text-muted">Event Descriptions</label>
                    <textarea class="form-control" id="eventDescription" name="eventDescription" placeholder="Enter event description" required></textarea>
                </div>
                <button type="submit" id="submitButton" name="submitButton" class="btn btn-dark w-100" disabled>Create</button>
            </form>
        </div>
    </div>
</div>

<script>
    const eventNameField = document.getElementById('eventName');
    const eventPlaceField = document.getElementById('eventPlace');
    const capacityField = document.getElementById('capacity');
    const capacityError = document.getElementById('capacityError');
    const eventDateField = document.getElementById('eventDate');
    const eventDateError = document.getElementById('eventDateError');
    const eventDescriptionField = document.getElementById('eventDescription');
    const submitButton = document.getElementById('submitButton');

    function validateCapacity() {
        const capacity = parseInt(capacityField.value, 10);

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
        const isFormValid =
            eventNameField.value &&
            eventPlaceField.value &&
            capacityField.value &&
            validateCapacity() &&
            eventDateField.value &&
            validateDate() &&
            eventDescriptionField.value;

        submitButton.disabled = !isFormValid;
    }

    eventNameField.addEventListener('input', validateForm);
    eventPlaceField.addEventListener('input', validateForm);
    capacityField.addEventListener('input', validateForm);
    eventDateField.addEventListener('input', validateForm);
    eventDescriptionField.addEventListener('input', validateForm);

    // Initialize validation
    window.onload = validateForm;
</script>


<?php include("includes/footer.php");
if (isset($_POST['submitButton'])) {
    if (!isset($_POST['eventType']) || empty($_POST['eventType'])) {
        die("Error: Event type is required.");
    }

    $eventName = $_POST['eventName'];
    $eventType = $_POST['eventType'];
    $eventPlace = $_POST['eventPlace'];
    $capacity = $_POST['capacity'];
    $eventDate = $_POST['eventDate'];
    $eventDescription = $_POST['eventDescription'];
    $hostEmail = $_SESSION['user_email'];

    $sql = "select user_id from users where user_email='$hostEmail'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);
        $hostId = $row["user_id"];
    }

    $stmt = $conn->prepare("INSERT INTO events (event_name, event_type, event_place, capacity, event_date, event_description, host_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiss", $eventName, $eventType, $eventPlace, $capacity, $eventDate, $eventDescription, $hostId);

    if ($stmt->execute()) {
        echo "<script>alert('New event successfully uploaded!')</script>";
        echo "<script>window.location.href='my_events.php'</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

?>