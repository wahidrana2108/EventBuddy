<?php 
    include("includes/header.php"); 
    
    // Check if the user is logged in
    if (!isset($_SESSION['adminEmail'])) {
        header("Location: login.php");
        exit();
    }
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Users</h2>
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">User Name</th>
                <th scope="col">Email</th>
                <th scope="col">Active</th>
                <th scope="col">Registration Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS user_name, user_email, active, registration_date FROM users";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row["user_id"] . "</th>";
                    echo "<td>" . $row["user_name"] . "</td>";
                    echo "<td>" . $row["user_email"] . "</td>";
                    echo "<td>" . ($row["active"]==1 ? 'Yes':'No') . "</td>";
                    echo "<td>" . $row["registration_date"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_user.php?id=" . $row["user_id"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                    echo "<a href='delete_user.php?id=" . $row["user_id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No users found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="create_user.php" class="btn btn-primary">Create New User</a>
</div>

<?php include("includes/footer.php"); ?>
