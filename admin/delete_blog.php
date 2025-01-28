<?php
    include("includes/db.php");

    if (isset($_GET['id'])) {
        $blog_id = $_GET['id'];

        // Prepare the delete statement
        $stmt = $conn->prepare("DELETE FROM blogs WHERE blog_id = ?");
        $stmt->bind_param("i", $blog_id);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Blog deleted successfully!');</script>";
        } else {
            echo "<script>alert('Error deleting blog: " . $stmt->error . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }

    // Redirect to blogs.php
    echo "<script>window.location.href='blogs.php'</script>";
?>
