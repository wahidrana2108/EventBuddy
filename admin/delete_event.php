<?php
    include("includes/db.php");

    if (isset($_GET['id'])) {
        $event_id = $_GET['id'];

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Delete related records in the event_enrollments table
            $stmt = $conn->prepare("DELETE FROM event_enrollments WHERE event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $stmt->close();

            // Delete the event
            $stmt = $conn->prepare("DELETE FROM events WHERE event_id = ?");
            $stmt->bind_param("i", $event_id);
            $stmt->execute();
            $stmt->close();

            // Commit the transaction
            $conn->commit();
            
            echo "<script>alert('Event deleted successfully!');</script>";
            echo "<script>window.location.href='events.php'</script>";
        } catch (mysqli_sql_exception $exception) {
            // Rollback the transaction in case of error
            $conn->rollback();

            echo "<script>alert('Error deleting event: " . $exception->getMessage() . "');</script>";
            echo "<script>window.location.href='events.php'</script>";
        }
    } else {
        // Redirect to events.php if no event ID is provided
        echo "<script>window.location.href='events.php'</script>";
    }
?>

