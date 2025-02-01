<?php
include("includes/db.php"); // Include your database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blog_id = $_POST['blog_id'];
    $blog_name = $_POST['blog_name'];
    $blog_desc = $_POST['blog_desc'];
    // Handle file upload if a new banner is provided
    if (isset($_FILES['blog_bann']) && $_FILES['blog_bann']['error'] == 0) {
        $blog_bann = $_FILES['blog_bann']['name'];
        $target_dir = "../img/banner/";
        $target_file = $target_dir . basename($blog_bann);
        move_uploaded_file($_FILES['blog_bann']['tmp_name'], $target_file);        
    } else {
        // Use the existing banner if no new file is uploaded
        $query = "SELECT blog_bann FROM blogs WHERE blog_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();
        $stmt->bind_result($blog_bann);
        $stmt->fetch();
        $stmt->close();
    }

    // Update the blog details
    $query = "UPDATE blogs SET blog_name = ?, blog_desc = ?, blog_bann = ?  WHERE blog_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $blog_name, $blog_desc, $blog_bann, $blog_id);

    if ($stmt->execute()) {
        // Redirect to the blogs management page with a success message
        header("Location: blogs.php");
    } else {
        // Redirect to the blogs management page with an error message
        header("Location: blogs.php");
    }

    $stmt->close();
} else {
    // Redirect to the blogs management page with an error message
    header("Location: blogs.php");
}

$conn->close();
?>

