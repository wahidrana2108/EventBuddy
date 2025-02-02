<?php 
    include("includes/header.php"); 
        // Check if the user is logged in
        if (isset($_SESSION['user_email'])) {
            header("Location: index.php");
            exit();
        }
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Register</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="registrationForm" method="POST" action="" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="firstName" class="form-label text-muted">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName"
                        placeholder="Enter your first name" required>
                </div>
                <div class="mb-2">
                    <label for="lastName" class="form-label text-muted">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="lastName"
                        placeholder="Enter your last name" required>
                </div>
                <div class="mb-2">
                    <label for="phone" class="form-label text-muted">Phone Number</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        placeholder="Enter your phone number" required>
                    <div id="phoneError" class="text-danger mt-1" style="display: none;">Please enter a valid phone
                        number.</div>
                </div>
                <div class="mb-2">
                    <label for="email" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email"
                        required>
                    <div id="emailError" class="text-danger mt-1" style="display: none;">Please enter a valid email
                        (Google, Microsoft, Yahoo only).</div>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label text-muted">Password</label>
                    <input type="password" class="form-control" id="password" name="password"
                        placeholder="Enter your password" required>
                    <div id="passwordError" class="text-danger mt-1" style="display: none;">Password must be between 8
                        to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword"
                        placeholder="Confirm your password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not
                        match.</div>
                </div>
                <div class="mb-2">
                    <label for="gender" class="form-label text-muted">Gender</label>
                    <select class="form-select" id="gender" name="gender" required>
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-2">
                    <label for="profilePicture" class="form-label text-muted">Profile Picture</label>
                    <input type="file" class="form-control" id="profilePicture" name="profilePicture" required>
                    <div id="profilePictureError" class="text-danger mt-1" style="display: none;">Please upload a
                        profile picture.</div>
                </div>
                <button type="submit" id="registerButton" name="registerButton" class="btn btn-dark w-100"
                    disabled>Register</button>
            </form>
            <div class="text-center mt-2">
                <a href="login.php" class="text-decoration-none text-dark">Already have an account? Login</a>
            </div>
        </div>
    </div>
</div>

<script>
    const firstNameField = document.getElementById('firstName');
    const lastNameField = document.getElementById('lastName');
    const phoneField = document.getElementById('phone');
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const genderField = document.getElementById('gender');
    const registerButton = document.getElementById('registerButton');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');
    const phoneError = document.getElementById('phoneError');
    const profilePictureField = document.getElementById('profilePicture');
    const profilePictureError = document.getElementById('profilePictureError');

    function validateProfilePicture() {
        const file = profilePictureField.files[0];
        if (file) {
            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            const maxSize = 2 * 1024 * 1024; // 2MB

            if (!validTypes.includes(file.type)) {
                profilePictureError.style.display = 'block';
                profilePictureError.textContent = 'Only JPG, PNG, or GIF files are allowed.';
                return false;
            }

            if (file.size > maxSize) {
                profilePictureError.style.display = 'block';
                profilePictureError.textContent = 'File size must not exceed 2MB.';
                return false;
            }

            profilePictureError.style.display = 'none';
            return true;
        }
        profilePictureError.style.display = 'block';
        profilePictureError.textContent = 'Please upload a profile picture.';
        return false;
    }

    profilePictureField.addEventListener('change', () => {
        validateProfilePicture();
        validateForm();
    });

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
        if (firstNameField.value && lastNameField.value && phoneField.value && emailField.value && passwordField.value &&
            confirmPasswordField.value && genderField.value && validateEmail() && validatePhone() && validatePassword() &&
            validateConfirmPassword() && validateProfilePicture()) {
            registerButton.disabled = false;
        } else {
            registerButton.disabled = true;
        }
    }

    firstNameField.addEventListener('input', validateForm);
    lastNameField.addEventListener('input', validateForm);
    phoneField.addEventListener('input', validateForm);
    emailField.addEventListener('input', validateForm);
    passwordField.addEventListener('input', validateForm);
    confirmPasswordField.addEventListener('input', validateForm);
    genderField.addEventListener('change', validateForm);

    window.onload = validateForm;
</script>

<?php 
    include("includes/footer.php");

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    if (isset($_POST["registerButton"])) {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $gender = $_POST['gender'];
        $profilePicture = $_FILES['profilePicture']['name'];
        $profilePictureTmp = $_FILES['profilePicture']['tmp_name'];

        // Check if email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $count_users = $result->num_rows;

        if ($count_users > 0) {
            echo "<script>alert('This Email already exists!')</script>";
            echo "<script>window.location.href='1.php'</script>";
        } else {
            if ($password == $confirmPassword) {
                $password_hash = password_hash($password, PASSWORD_DEFAULT);
                $user_ip = getRealIpUser();
                move_uploaded_file($profilePictureTmp, "img/users/$profilePicture");

                // Token generation function
                function getToken($len = 32) {
                    return substr(md5(openssl_random_pseudo_bytes(20)), -$len);
                }

                $token = getToken(10);

                // Insert user data into database using prepared statement
                $stmt = $conn->prepare("INSERT INTO users (
                    first_name,
                    last_name,
                    user_email,
                    user_phn,
                    user_pass,
                    user_gender,
                    user_dp,
                    token,
                    user_ip,
                    registration_date
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, now())");
                $stmt->bind_param(
                    "sssssssss", 
                    $firstName, 
                    $lastName, 
                    $email, 
                    $phone, 
                    $password_hash, 
                    $gender, 
                    $profilePicture, 
                    $token, 
                    $user_ip
                );
                $stmt->execute();

                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'jacquelinechavezkh@gmail.com';
                    $mail->Password = 'rcci oxmj horg jndv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port = 465;

                    $mail->setFrom('jacquelinechavezkh@gmail.com', 'Email Confirmation');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = 'Account Activation';
                    $mail->Body = 'Click the link to activate your account. <a href="http://localhost:3000/verification.php?email=' . $email . '&token=' . $token . '"> Click here</a>';

                    $mail->send();
                    $output = 'Message has been sent';
                } catch (Exception $e) {
                    $output = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                if ($stmt->affected_rows > 0) {
                    echo "<script>alert('Confirmation link sent to your email. Confirm email to login!')</script>";
                    echo "<script>window.location.href='login.php'</script>";
                }
            } else {
                echo "<script>alert('Recheck Password!')</script>";
                echo "<script>window.location.href='registration.php'</script>";
            }
        }
    }
?>
