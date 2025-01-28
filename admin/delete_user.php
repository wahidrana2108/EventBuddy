<?php
    include("includes/db.php");

    if (isset($_GET['id'])) {
        $user_id = $_GET['id'];

        // Prepare the delete statement
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting blog: " . $stmt->error . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Redirect to blogs.php
    echo "<script>window.location.href='users.php'</script>";
?>
