<?php
include("includes/db.php");

if ($_GET) {
    if (isset($_GET['email'])) {
        $email = $_GET['email'];
        if ($email == '') {
            unset($email);
        }
    }
    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if ($token == '') {
            unset($token);
        }
    }

    if (!empty($email) && !empty($token)) {
        // Use a prepared statement to fetch the user
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ? AND token = ?");
        $stmt->bind_param("ss", $email, $token);
        $stmt->execute();
        $result = $stmt->get_result();
        $count_users = $result->num_rows;

        if ($count_users == 1) {
            // Use a prepared statement to update the user
            $update_stmt = $conn->prepare("UPDATE users SET active = 1, token = '' WHERE user_email = ?");
            $update_stmt->bind_param("s", $email);
            $run_update = $update_stmt->execute();

            if ($run_update) {
                echo "<script>alert('Email address successfully verified!')</script>";
                echo "<script>window.location.href='login.php'</script>";
            }
        } else {
            echo "<script>alert('Invalid verification details!')</script>";
            echo "<script>window.location.href='registration.php'</script>";
        }
    }
}
?>
