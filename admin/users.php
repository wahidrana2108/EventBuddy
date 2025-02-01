<?php 
include("includes/header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['adminEmail'])) {
    header("Location: login.php");
    exit();
}

// Determine the sort order
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name_asc';
$sort_query = '';

switch ($sort) {
    case 'name_asc':
        $sort_query = 'ORDER BY user_name ASC';
        break;
    case 'name_desc':
        $sort_query = 'ORDER BY user_name DESC';
        break;
    case 'date_asc':
        $sort_query = 'ORDER BY registration_date ASC';
        break;
    case 'date_desc':
        $sort_query = 'ORDER BY registration_date DESC';
        break;
    default:
        $sort_query = 'ORDER BY user_name ASC';
        break;
}

// Pagination variables
$users_per_page = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $users_per_page;

// Fetch total number of users
$total_query = "SELECT COUNT(*) AS total FROM users";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_users = $total_row['total'];
$total_pages = ceil($total_users / $users_per_page);

// Fetch users data with limit and offset
$query = "SELECT user_id, CONCAT(first_name, ' ', last_name) AS user_name, user_email, active, registration_date FROM users $sort_query LIMIT $users_per_page OFFSET $offset";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2 class="mb-4 d-flex justify-content-between align-items-center">
        Manage Users
        <div>
            <select class="form-select form-select-sm" onchange="location = this.value;">
                <option value="?sort=name_asc" <?php if ($sort == 'name_asc') echo 'selected'; ?>>Sort by Name (A-Z)</option>
                <option value="?sort=name_desc" <?php if ($sort == 'name_desc') echo 'selected'; ?>>Sort by Name (Z-A)</option>
                <option value="?sort=date_asc" <?php if ($sort == 'date_asc') echo 'selected'; ?>>Sort by Date (Oldest First)</option>
                <option value="?sort=date_desc" <?php if ($sort == 'date_desc') echo 'selected'; ?>>Sort by Date (Newest First)</option>
            </select>
        </div>
    </h2>
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
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<th scope='row'>" . $row["user_id"] . "</th>";
                    echo "<td>" . $row["user_name"] . "</td>";
                    echo "<td>" . $row["user_email"] . "</td>";
                    echo "<td>" . ($row["active"]==1 ? 'Yes':'No') . "</td>";
                    echo "<td>" . $row["registration_date"] . "</td>";
                    echo "<td>";
                    if ($row["active"] == 1) {
                        echo "<a href='deactivate_user.php?id=" . $row["user_id"] . "' class='btn btn-warning btn-sm'>Deactivate</a> ";
                    } else {
                        echo "<a href='activate_user.php?id=" . $row["user_id"] . "' class='btn btn-success btn-sm'>Activate</a> ";
                    }
                    echo "<a href='delete_user.php?id=" . $row["user_id"] . "' class='btn btn-danger btn-sm'>Delete</a>";
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>No users found.</td></tr>";
            }
            ?>
        </tbody>
    </table>

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
