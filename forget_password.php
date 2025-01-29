<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Forgot Password</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="forgotPasswordForm" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="email" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                    <div id="emailError" class="text-danger mt-1" style="display: none;">Please enter a valid email (Google, Microsoft, Yahoo only).</div>
                </div>
                <div class="mb-2">
                    <label for="phone" class="form-label text-muted">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required>
                    <div id="phoneError" class="text-danger mt-1" style="display: none;">Please enter a valid phone number.</div>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label text-muted">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                    <div id="passwordError" class="text-danger mt-1" style="display: none;">Password must be between 8
                        to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm your password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                </div>
                <button type="submit" id="submitButton" name="submitButton" class="btn btn-dark w-100" disabled>Submit</button>
            </form>
            <div class="text-center mt-2">
                <a href="login.php" class="text-decoration-none text-dark">Back to Login</a>
            </div>
            <div class="text-center mt-2">
                <a href="registration.php" class="text-decoration-none text-dark">Don't have an account? Sign up</a>
            </div>
        </div>
    </div>
</div>

<script>
    const emailField = document.getElementById('email');
    const phoneField = document.getElementById('phone');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const submitButton = document.getElementById('submitButton');
    const emailError = document.getElementById('emailError');

    function validateEmail() {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
        if (emailPattern.test(emailField.value)) {
            emailError.style.display = 'none';
            return true;
        } else {
            emailError.style.display = 'block';
            return false;
        }
    }

    function validatePhone() {
        const phonePattern = /^01\d{9}$/;
        if (phonePattern.test(phoneField.value)) {
            phoneError.style.display = 'none';
            return true;
        } else {
            phoneError.style.display = 'block';
            return false;
        }
    }

    function validatePassword() {
        const passwordLength = passwordField.value.length;
        if (passwordLength >= 8 && passwordLength <= 12) {
            passwordError.style.display = 'none';
            return true;
        } else {
            passwordError.style.display = 'block';
            return false;
        }
    }

    function validateConfirmPassword() {
        if (confirmPasswordField.value === passwordField.value) {
            confirmPasswordError.style.display = 'none';
            return true;
        } else {
            confirmPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateForm() {
        if ( emailField.value && phoneField.value && passwordField.value && confirmPasswordField.value && 
            validateEmail() && validatePhone() && validatePassword() && validateConfirmPassword()) {
                submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    emailField.addEventListener('input', validateForm);
    phoneField.addEventListener('input', validateForm);
    passwordField.addEventListener('input', validateForm);
    confirmPasswordField.addEventListener('input', validateForm);

    window.onload = validateForm;
</script>

<?php include("includes/footer.php") ?>


<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    if(isset($_POST['submitButton'])){   
        $email = $_POST['email'];  
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];

        function getToken($len=32){
            return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
        }
        $token = getToken(10);

        // Using prepared statements
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_email=? AND user_phn=?");
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();
        $check_user = $result->num_rows;
        $row_user = $result->fetch_assoc();
        $user_id = $row_user['user_id']; 

        $get_ip = getRealIpUser();

        if($password == $confirmPassword){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            if($check_user==0){
                echo "<script>alert('No User Found!')</script>";
                echo "<script>window.open('forget_password.php','_self')</script>";
            }
            else{
                $stmt = $conn->prepare("UPDATE users SET user_pass=?, token=? WHERE user_id=?");
                $stmt->bind_param("ssi", $password_hash,$token, $user_id);
                $stmt->execute();

                try {
                    $mail->isSMTP();                                            
                    $mail->Host       = 'smtp.gmail.com';                     
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = 'jacquelinechavezkh@gmail.com';                     
                    $mail->Password   = 'rcci oxmj horg jndv';                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
                    $mail->Port       = 465;                                    
                  
                    $mail->setFrom('jacquelinechavezkh@gmail.com', 'Password Reset');
                    $mail->addAddress($email);     
                  
                    $mail->isHTML(true);                                  
                    $mail->Subject = 'Request for password reset';
                    $mail->Body = 'click the link to recover your password. <a href="http://localhost:3000/update.php?email=' . $email . '&token=' . $token . '&hash=' . $password_hash . '"> Click here</a>';
                  
                    $mail->send();
                    $output =  'Message has been sent';
                } 
                catch (Exception $e) {
                    $output =  "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                if($stmt->affected_rows > 0){
                    echo "<script>alert('Link for update Password sent to your email!')</script>";
                    echo "<script>window.location.href='registration.php'</script>";
                }
            }
        }
        else{
            echo "<script>alert('Recheck Password!')</script>";
        }
    }
?>