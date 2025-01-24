<?php include("header.php") ?>

<div class="container mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">All Events</h3>
        </div>
        <div class="card-body p-3">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Enrolled</th>
                        <th>Left</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $eventsPerPage = 15;
                        $totalEvents = // Get the total number of events from your database
                        $totalPages = ceil($totalEvents / $eventsPerPage);

                        $currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
                        $offset = ($currentPage - 1) * $eventsPerPage;

                        $events = // Fetch the events for the current page from your database with limit $offset, $eventsPerPage

                        foreach ($events as $event) {
                            echo "<tr>
                                    <td>{$event['name']}</td>
                                    <td>{$event['enrolled']} / {$event['capacity']}</td>
                                    <td id='daysRemaining{$event['id']}'></td>
                                    <td><a href='event_details.php?id={$event['id']}' class='btn btn-dark'>Details</a></td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination justify-content-center">
                    <?php if ($currentPage > 1): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                        </li>
                    <?php endif; ?>

                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= $i == $currentPage ? 'active' : '' ?>">
                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <li class="page-item">
                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
    function calculateRemainingDays(eventDate) {
        const today = new Date();
        const event = new Date(eventDate);
        const diffTime = event - today;
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
        return diffDays > 0 ? diffDays : 0;
    }

    <?php
        foreach ($events as $event) {
            echo "document.getElementById('daysRemaining{$event['id']}').textContent = calculateRemainingDays('{$event['date']}');";
        }
    ?>
</script>

<?php include("footer.php") ?>
