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
        $sort_query = 'ORDER BY event_name ASC';
        break;
    case 'name_desc':
        $sort_query = 'ORDER BY event_name DESC';
        break;
    case 'date_desc':
        $sort_query = 'ORDER BY event_date DESC';
        break;
    case 'date_asc':
    default:
        $sort_query = 'ORDER BY event_date ASC';
        break;
}

// Pagination variables
$events_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $events_per_page;

// Fetch total number of events
$total_query = "SELECT COUNT(*) AS total FROM events";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_events = $total_row['total'];
$total_pages = ceil($total_events / $events_per_page);

// Fetch events data with limit and offset
$query = "SELECT event_id, event_name, event_date, event_place, status FROM events $sort_query LIMIT $events_per_page OFFSET $offset";
$result = $conn->query($query);
?>

<div class="container mt-4">
    <h2 class="mb-4 d-flex justify-content-between align-items-center">
        Manage Events
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
                <th scope="col">Event Name</th>
                <th scope="col">Date</th>
                <th scope="col">Location</th>
                <th scope="col">Status</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
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
