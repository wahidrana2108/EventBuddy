<?php 
include("includes/header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['adminEmail'])) {
    header("Location: login.php");
    exit();
}

// Determine the sort order
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'date_asc';
$sort_query = '';

switch ($sort) {
    case 'name_asc':
        $sort_query = 'ORDER BY blog_name ASC';
        break;
    case 'name_desc':
        $sort_query = 'ORDER BY blog_name DESC';
        break;
    case 'date_desc':
        $sort_query = 'ORDER BY upload_date DESC';
        break;
    case 'date_asc':
    default:
        $sort_query = 'ORDER BY upload_date ASC';
        break;
}

// Pagination variables
$blogs_per_page = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $blogs_per_page;

// Fetch total number of blogs
$total_query = "SELECT COUNT(*) AS total FROM blogs";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_blogs = $total_row['total'];
$total_pages = ceil($total_blogs / $blogs_per_page);

// Fetch blogs data with limit and offset
$query = "SELECT blog_id, blog_name, blog_desc, blog_bann, DATE_FORMAT(upload_date, '%Y-%m-%d') AS upload_date FROM blogs $sort_query LIMIT $blogs_per_page OFFSET $offset";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2 class="mb-4 d-flex justify-content-between align-items-center">
        Manage Blogs
        <div>
            <select class="form-select form-select-sm" onchange="location = this.value;">
                <option value="?sort=date_asc" <?php if ($sort == 'date_asc') echo 'selected'; ?>>Sort by Date (Oldest First)</option>
                <option value="?sort=date_desc" <?php if ($sort == 'date_desc') echo 'selected'; ?>>Sort by Date (Newest First)</option>
                <option value="?sort=name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>Sort by Name (A-Z)</option>
                <option value="?sort=name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>Sort by Name (Z-A)</option>
            </select>
        </div>
    </h2>
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
            ?>
        </tbody>
    </table>
    <div class="mb-3">
        <a href="create_blog.php" class="btn btn-dark">Create New Blog</a>
    </div>


    <?php if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination justify-content-center">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?sort=<?php echo $sort; ?>&page=<?php echo $page - 1; ?>">Previous</a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?sort=<?php echo $sort; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?sort=<?php echo $sort; ?>&page=<?php echo $page + 1; ?>">Next</a>
                    </li>
                <?php endif; ?>
            </ul>
            
        </nav>
    <?php endif; ?>
</div>

<?php 
$conn->close();
include("includes/footer.php"); 
?>
