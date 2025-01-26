<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">My Events</h3>
        </div>
        <div class="card-body p-3">
            <div class="d-flex justify-content-end mb-3">
                <select id="filter" class="form-select w-auto">
                    <option value="name">Sort by Name (A-Z)</option>
                    <option value="date">Sort by Date</option>
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
                    <tr>
                        <td>John's Birthday Bash</td>
                        <td>John Doe</td>
                        <td>35 / 50</td>
                        <td><a href="event_details.php?id=1" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Office Annual Party</td>
                        <td>Jane Smith</td>
                        <td>150 / 200</td>
                        <td><a href="event_details.php?id=2" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Wedding Ceremony</td>
                        <td>Mark Lee</td>
                        <td>90 / 100</td>
                        <td><a href="event_details.php?id=3" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Friends Reunion</td>
                        <td>Emily Davis</td>
                        <td>60 / 80</td>
                        <td><a href="event_details.php?id=4" class="btn btn-dark">Details</a></td>
                    </tr>
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

    document.getElementById('daysRemaining1').textContent = calculateRemainingDays('2025-01-15');
    document.getElementById('daysRemaining2').textContent = calculateRemainingDays('2025-01-16');
    document.getElementById('daysRemaining3').textContent = calculateRemainingDays('2025-01-17');
    document.getElementById('daysRemaining4').textContent = calculateRemainingDays('2025-01-18');

    const events = [
        { name: "John's Birthday Bash", host: "John Doe", enrolled: "35 / 50", date: "2025-01-15" },
        { name: "Office Annual Party", host: "Jane Smith", enrolled: "150 / 200", date: "2025-01-16" },
        { name: "Wedding Ceremony", host: "Mark Lee", enrolled: "90 / 100", date: "2025-01-17" },
        { name: "Friends Reunion", host: "Emily Davis", enrolled: "60 / 80", date: "2025-01-18" }
    ];

    document.getElementById('filter').addEventListener('change', function () {
        const filterValue = this.value;
        let sortedEvents;

        if (filterValue === 'name') {
            sortedEvents = events.sort((a, b) => a.name.localeCompare(b.name));
        } else if (filterValue === 'date') {
            sortedEvents = events.sort((a, b) => new Date(a.date) - new Date(b.date));
        }

        const tableBody = document.getElementById('eventsTable');
        tableBody.innerHTML = '';

        sortedEvents.forEach(event => {
            const row = `<tr>
                <td>${event.name}</td>
                <td>${event.host}</td>
                <td>${event.enrolled}</td>
                <td><a href="event_details.php?id=1" class="btn btn-dark">Details</a></td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    });
</script>

<?php include("includes/footer.php") ?>
