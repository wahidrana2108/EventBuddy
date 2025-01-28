<?php include("includes/header.php"); ?>

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
                    <?php
                    $sql = "SELECT event_id, event_name, host, max_capacity, DATE_FORMAT(event_date, '%Y-%m-%d') AS event_date FROM events";
                    $result = $conn->query($sql);

                    $events = array();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $events[] = $row;
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row["event_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . htmlspecialchars($row["host"], ENT_QUOTES, 'UTF-8') . "</td>";
                            echo "<td>" . $row["max_capacity"] . " / " . $row["max_capacity"] . "</td>";
                            echo "<td><a href='event_details.php?id=" . $row["event_id"] . "' class='btn btn-dark'>Details</a></td>";
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
    const events = <?php echo json_encode($events); ?>;

    document.getElementById('filter').addEventListener('change', function () {
        const filterValue = this.value;
        let sortedEvents;

        if (filterValue === 'name') {
            sortedEvents = events.sort((a, b) => a.event_name.localeCompare(b.event_name));
        } else if (filterValue === 'date') {
            sortedEvents = events.sort((a, b) => new Date(a.event_date) - new Date(b.event_date));
        }

        const tableBody = document.getElementById('eventsTable');
        tableBody.innerHTML = '';

        sortedEvents.forEach(event => {
            const row = `<tr>
                <td>${event.event_name}</td>
                <td>${event.host}</td>
                <td>${event.enrolled} / ${event.max_capacity}</td>
                <td><a href="event_details.php?id=${event.event_id}" class="btn btn-dark">Details</a></td>
            </tr>`;
            tableBody.innerHTML += row;
        });
    });
</script>

<?php include("includes/footer.php"); ?>
