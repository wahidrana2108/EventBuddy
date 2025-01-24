<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Search Results</h3>
        </div>
        <div class="card-body p-3">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Enrolled</th>
                        <th>Left</th>
                        <th>Host</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>John's Birthday Bash</td>
                        <td>35 / 50</td>
                        <td id="daysRemaining1"></td>
                        <td>John Doe</td>
                        <td><a href="event_details.php?id=1" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Office Annual Party</td>
                        <td>150 / 200</td>
                        <td id="daysRemaining2"></td>
                        <td>Jane Smith</td>
                        <td><a href="event_details.php?id=2" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Wedding Ceremony</td>
                        <td>90 / 100</td>
                        <td id="daysRemaining3"></td>
                        <td>Mark Lee</td>
                        <td><a href="event_details.php?id=3" class="btn btn-dark">Details</a></td>
                    </tr>
                    <tr>
                        <td>Friends Reunion</td>
                        <td>60 / 80</td>
                        <td id="daysRemaining4"></td>
                        <td>Alice Johnson</td>
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
</script>

<?php include("includes/footer.php") ?>
