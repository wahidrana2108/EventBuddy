<?php
// update_event.php
include("includes/header.php");
session_start();

// Check if the event ID is provided
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Error: Event ID is required.");
}

$event_id = intval($_GET['id']);

// Update event details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $newCapacity = $_POST['newCapacity'];
    $newDate = $_POST['eventDate'];

    $updateQuery = "UPDATE events SET ";
    $updateParams = [];
    $updateTypes = '';

    if (!empty($newCapacity)) {
        $updateQuery .= "capacity = ?, ";
        $updateParams[] = $newCapacity;
        $updateTypes .= 'i';
    }

    if (!empty($newDate)) {
        $updateQuery .= "event_date = ?, ";
        $updateParams[] = $newDate;
        $updateTypes .= 's';
    }

    $updateQuery = rtrim($updateQuery, ', ');
    $updateQuery .= " WHERE event_id = ?";

    $updateParams[] = $event_id;
    $updateTypes .= 'i';

    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param($updateTypes, ...$updateParams);

    if ($stmt->execute()) {
        echo "<script>window.location.href='my_event_details.php?id=" . $event_id . "'</script>";
        echo "Event updated successfully.";

    } else {
        echo "Error updating event: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
