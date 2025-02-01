<?php 
include("includes/header.php");

if (isset($_GET['input'])) {
    $input = $_GET['input'];
    $query = "SELECT e.event_id, e.event_name, e.capacity, e.event_date, u.first_name, u.last_name, 
                     (SELECT COUNT(*) FROM event_enrollments WHERE event_id = e.event_id) AS enrolled_count
              FROM events e
              JOIN users u ON e.host_id = u.user_id
              WHERE e.event_name LIKE ?";

    $stmt = $conn->prepare($query);
    $searchTerm = "%" . $input . "%";
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

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
                    <?php if (!empty($result) && $result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                                <td><?php echo $row['enrolled_count'] . " / " . $row['capacity']; ?></td>
                                <td class="daysRemaining" data-date="<?php echo $row['event_date']; ?>"></td>
                                <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                                <td><a href="event_details.php?id=<?php echo $row['event_id']; ?>" class="btn btn-dark">Details</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No events found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.daysRemaining').forEach(cell => {
        let eventDate = new Date(cell.dataset.date);
        let today = new Date();
        let diffTime = eventDate - today;
        let diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        cell.textContent = diffDays > 0 ? diffDays + ' days' : 'Event Passed';
    });
</script>

<?php include("includes/footer.php"); ?>
