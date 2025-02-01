<?php
include("includes/db.php");

if (isset($_POST['input'])) {
    $input = $_POST['input'];

    $get_result = "SELECT e.event_id, e.event_name, u.first_name, u.last_name
                   FROM events e
                   JOIN users u ON e.host_id = u.user_id
                   WHERE e.event_name LIKE '%$input%' OR u.first_name LIKE '%$input%' OR u.last_name LIKE '%$input%'";
    $run_result = mysqli_query($conn, $get_result);

    if(mysqli_num_rows($run_result) > 0) {
        echo "<div class='search-results card position-absolute w-100 mt-2 p-0 pt-6'>
                <div class='list-group list-group-flush'>";
        while($row_result = mysqli_fetch_array($run_result)) {
            $event_id = $row_result['event_id'];
            $event_name = $row_result['event_name'];
            $host_name = $row_result['first_name'] . ' ' . $row_result['last_name'];
            echo "<a href='event_details.php?id=$event_id' class='list-group-item list-group-item-action bg-dark text-light'>
                    <div class='d-flex justify-content-between'>
                        <div>
                            <strong>$event_name</strong> <br>
                            <small>Hosted by $host_name</small>
                        </div>
                        <i class='bi bi-arrow-right-circle-fill'></i>
                    </div>
                  </a>";
        }
        echo "     </div>
              </div>";
    } else {
        echo "<div class='text-light mt-2 pt-4 mb-4'>No event information found!</div>";
    }
}
?>
