<?php include("includes/header.php"); ?>

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
            <tr>
                <th scope="row">1</th>
                <td>Amazing Birthday Party</td>
                <td>2025-01-15</td>
                <td>Pabna</td>
                <td>Running</td>
                <td>
                    <a href="view_event.php?id=1" class="btn btn-info btn-sm">View</a>
                    <a href="edit_event.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_event.php?id=1" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Corporate Meeting</td>
                <td>2025-01-20</td>
                <td>Dhaka</td>
                <td>Upcoming</td>
                <td>
                    <a href="view_event.php?id=2" class="btn btn-info btn-sm">View</a>
                    <a href="edit_event.php?id=2" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_event.php?id=2" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
    <a href="create_event.php" class="btn btn-primary">Create New Event</a>
</div>

<?php include("includes/footer.php"); ?>
