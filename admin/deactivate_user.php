<?php
include("includes/db.php"); // Include your database connection file

// Check if the user ID is set
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Deactivate the user account
    $query = "UPDATE users SET active = 0 WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        // Redirect to the users management page with a success message
        header("Location: users.php");
    } else {
        // Redirect to the users management page with an error message
        header("Location: users.php");
    }

    $stmt->close();
} else {
    // Redirect to the users management page with an error message
    header("Location: users.php");
}

$conn->close();
?>
