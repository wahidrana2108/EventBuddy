<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Event Details</h3>
        </div>
        <div class="card-body p-3 ">
            <p><strong>Event:</strong> Amazing Birthday Party</p>
            <p><strong>Location:</strong> Pabna</p>
            <p><strong>Enrolled:</strong> 20 / 50</p>
            <p><strong>Remaining:</strong> 30</p>
            
            <div class="d-flex align-items-center mb-2">
                <div class="me-2">
                    <label for="newCapacity" class="form-label text-muted">Edit Capacity:</label>
                    <input type="number" class="form-control" id="newCapacity" placeholder="New capacity" min="5" max="500" style="width: 150px;">
                    <div id="capacityError" class="text-danger mt-1" style="display: none;"></div>
                </div>

                <div>
                    <label for="eventDate" class="form-label text-muted">Edit Event Date:</label>
                    <input type="date" class="form-control" id="eventDate" placeholder="dd/mm/yyyy" style="width: 150px;">
                    <div id="eventDateError" class="text-danger mt-1" style="display: none;">Event date must be at least tomorrow.</div>
                </div>

                <button class="btn btn-dark ms-2">Update</button>
            </div>
            
            <div class="d-flex align-items-center mb-3">
                <p><strong>Event Status:</strong> Running</p>
                <button class="btn btn-warning ms-2">Hold</button>
                <button class="btn btn-danger ms-2">Cancel</button>
            </div>

            <h5>Enrolled Users:</h5>
            <ol>
                <li>John Doe - 2025-01-15 14:30</li>
                <li>Jane Smith - 2025-01-16 10:45</li>
                <li>Mark Lee - 2025-01-17 12:20</li>
            </ol>
        </div>
    </div>
</div>

<script>
    const newCapacityField = document.getElementById('newCapacity');
    const capacityError = document.getElementById('capacityError');
    const eventDateField = document.getElementById('eventDate');
    const eventDateError = document.getElementById('eventDateError');

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

    newCapacityField.addEventListener('input', validateCapacity);
    eventDateField.addEventListener('input', validateDate);
</script>

<?php include("includes/footer.php") ?>
