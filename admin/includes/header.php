<?php
    include("includes/db.php");
    session_start();
    function getRealIpUser(){
        switch(true){    
                case(!empty($_SERVER['HTTP_X_REAL_IP'])) : return $_SERVER['HTTP_X_REAL_IP'];
                case(!empty($_SERVER['HTTP_CLIENT_IP'])) : return $_SERVER['HTTP_CLIENT_IP'];
                case(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) : return $_SERVER['HTTP_X_FORWARDED_FOR'];
                
                default : return $_SERVER['REMOTE_ADDR'];
        }
    }

    if(isset($_SESSION['adminEmail'])) {
        $admin_email = $_SESSION['adminEmail'];
        $stmt = $conn->prepare("SELECT admin_dp FROM admin WHERE admin_email = ?");
        $stmt->bind_param("s", $admin_email);
        $stmt->execute();
        $stmt->bind_result($admin_dp);
        $stmt->fetch();
        $stmt->close();
    }
?>


<style>
    .pagination .page-item .page-link {
        background-color: #343a40; /* Dark background */
        color: white; /* White text */
        border-color: #343a40; /* Dark border */
    }

    .pagination .page-item.active .page-link {
        background-color: #212529; /* Darker background for active page */
        border-color: #212529;
    }

    .pagination .page-item .page-link:hover {
        background-color: #495057; /* Dark gray on hover */
        color: white;
    }

</style>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Event Manager</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="users.php">Users</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="error.php">Settings</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                                if(!isset($_SESSION['adminEmail'])) {
                                    echo'<img src="img/user.png" alt="Profile Picture" class="profile-picture me-2" style="width: 45px; height: 45px; border-radius: 50%;">';
                                }
                                else {
                                    echo'<img src="img/users/'.$admin_dp.'" alt="Profile Picture" class="profile-picture me-2" style="width: 45px; height: 45px; border-radius: 50%;">';
                                }
                            ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <?php
                                    if(isset($_SESSION['adminEmail'])) {
                                        echo"
                                            <li><a class='dropdown-item' href='admin_profile.php'>My Profile</a></li>
                                            <li><hr class='dropdown-divider'></li>
                                            <li><a class='dropdown-item' href='logout.php'>Logout</a></li>
                                        ";
                                    }
                                    else {
                                        echo"
                                            <li><a class='dropdown-item' href='login.php'>Login</a></li>
                                        ";
                                    }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
