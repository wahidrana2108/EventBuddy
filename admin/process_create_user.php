<?php
    // Include database connection
    include("includes/db.php");

    // Check if the user is logged in
    if (!isset($_SESSION['adminEmail'])) {
        header("Location: login.php");
        exit();
    }

    // Capture form data
    $userName = $_POST['userName'];
    $userEmail = $_POST['userEmail'];
    $userPassword = password_hash($_POST['userPassword'], PASSWORD_BCRYPT);

    // Insert new user into the database
    $query = "INSERT INTO users (name, email, password) VALUES ('$userName', '$userEmail', '$userPassword')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Redirect to users list page with success message
        header("Location: admin_users.php?message=success");
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
?>
