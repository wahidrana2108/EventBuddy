<?php include("includes/header.php"); ?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Users</h2>
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Registration Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th scope="row">1</th>
                <td>John Doe</td>
                <td>john@example.com</td>
                <td>2025-01-15</td>
                <td>
                    <a href="view_user.php?id=1" class="btn btn-info btn-sm">View</a>
                    <a href="edit_user.php?id=1" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_user.php?id=1" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
            <tr>
                <th scope="row">2</th>
                <td>Jane Smith</td>
                <td>jane@example.com</td>
                <td>2025-01-16</td>
                <td>
                    <a href="view_user.php?id=2" class="btn btn-info btn-sm">View</a>
                    <a href="edit_user.php?id=2" class="btn btn-warning btn-sm">Edit</a>
                    <a href="delete_user.php?id=2" class="btn btn-danger btn-sm">Delete</a>
                </td>
            </tr>
        </tbody>
    </table>
    <a href="create_user.php" class="btn btn-primary">Create New User</a>
</div>

<?php include("includes/footer.php"); ?>
