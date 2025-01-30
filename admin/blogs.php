<?php 
    include("includes/header.php");

    // Check if the user is logged in
    if (!isset($_SESSION['adminEmail'])) {
        header("Location: login.php");
        exit();
    }
?>

<div class="container mt-4">
    <h2 class="mb-4">Manage Blogs</h2>
    <table class="table table-striped table-hover">
        <thead class="table-light">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Blog Name</th>
                <th scope="col">Upload Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT blog_id, blog_name, blog_desc, blog_bann, DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date FROM blogs";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row["blog_id"] . "</th>";
                    echo "<td>" . htmlspecialchars($row["blog_name"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . $row["upload_date"] . "</td>";
                    echo "<td>";
                    echo "<a href='edit_blog.php?id=" . $row["blog_id"] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                    echo "<a href='delete_blog.php?id=" . $row["blog_id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No blogs found.</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>
    <a href="create_blog.php" class="btn btn-primary">Create New Blog</a>
</div>

<?php include("includes/footer.php"); ?>
