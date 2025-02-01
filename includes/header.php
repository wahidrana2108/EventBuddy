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

if(isset($_SESSION['user_email'])) {
    $user_email = $_SESSION['user_email'];
    $stmt = $conn->prepare("SELECT user_dp FROM users WHERE user_email = ?");
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $stmt->bind_result($user_dp);
    $stmt->fetch();
    $stmt->close();
}

if(isset($_POST['search'])) {
    $input = $_POST['input'];
    header("Location: search_result.php?input=$input");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Buddy</title>
    <link rel="shortcut icon" href="img/logo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">Event Buddy</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                </ul>
                <form method="POST" role="search" class="search-form d-flex position-relative">
                    <input type="text" class="form-control search-input" name="input" id="input" placeholder="Search Events" onkeyup="searchFunction()">
                    <button class="btn search-button" name="search" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                    <div class="search-results-container position-absolute w-100 mt-4" id="result"></div>
                </form>

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <?php
                                if(!isset($_SESSION['user_email'])) {
                                    echo'<img src="img/user.png" alt="Profile Picture" class="profile-picture me-2" style="width: 45px; height: 45px; border-radius: 50%;">';
                                } else {
                                    echo'<img src="img/users/'.$user_dp.'" alt="Profile Picture" class="profile-picture me-2" style="width: 45px; height: 45px; border-radius: 50%;">';
                                }
                            ?>
                            <span></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                            <?php
                                if(isset($_SESSION['user_email'])) {
                                    echo"
                                        <li><a class='dropdown-item' href='my_profile.php'>My Profile</a></li>
                                        <li><a class='dropdown-item' href='my_events.php'>My Events</a></li>
                                        <li><hr class='dropdown-divider'></li>
                                        <li><a class='dropdown-item' href='logout.php'>Logout</a></li>
                                    ";
                                } else {
                                    echo"
                                        <li><a class='dropdown-item' href='login.php'>Login</a></li>
                                        <li><a class='dropdown-item' href='registration.php'>Register</a></li>
                                    ";
                                }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

</body>
</html>
