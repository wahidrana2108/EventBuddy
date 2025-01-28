<?php
    include("includes/db.php");

    if($_GET){
        if(isset($_GET['email'])){
            $email = $_GET['email'];
            if($email == ''){
                unset($email);
            }
        }
        if(isset($_GET['token'])){
            $token = $_GET['token'];
            if($token == ''){
                unset($token);
            }
        }
        if(isset($_GET['hash'])){
            $hash = $_GET['hash'];
            if($hash == ''){
                unset($hash);
            }
        }
        
        if(!empty($email) && !empty($token)){
            // Using prepared statements
            $stmt = $conn->prepare("SELECT * FROM users WHERE user_email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $count_users = $result->num_rows;

            if($count_users == 1){
                $stmt = $conn->prepare("UPDATE users SET token='', user_pass=? WHERE user_email=?");
                $stmt->bind_param("ss", $hash, $email);
                $run_update = $stmt->execute();

                if($run_update){
                    echo "<script>alert('Password updated successfully!')</script>";
                    echo "<script>window.location.href='login.php'</script>";
                }
            }
        }
    }
?>