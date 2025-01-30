<?php 
include("includes/header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['adminEmail'])) {
    header("Location: login.php");
    exit();
}

?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Events</h2>
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Event Name</th>
                <th scope="col">Date</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Fetch events data
            $query = "SELECT event_id, event_name, event_date, event_place, status FROM events ORDER BY event_date";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                        <th scope='row'>{$row['event_id']}</th>
                        <td>{$row['event_name']}</td>
                        <td>{$row['event_date']}</td>
                        <td>{$row['event_place']}</td>
                        <td>{$row['status']}</td>
                        <td>
                            <a href='view_event.php?id={$row['event_id']}' class='btn btn-info btn-sm'>View</a>
                            <a href='edit_event.php?id={$row['event_id']}' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='delete_event.php?id={$row['event_id']}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No events found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="create_event.php" class="btn btn-primary">Create New Event</a>
</div>

<?php 
$conn->close();
include("includes/footer.php"); 
?>
