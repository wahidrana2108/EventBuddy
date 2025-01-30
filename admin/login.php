<?php
    include("includes/header.php");
    
    // Check if the user is logged in
    if (isset($_SESSION['adminEmail'])) {
        header("Location: index.php");
        exit();
    }
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Admin Login</h3>
        </div>
        <div class="card-body p-3">
            <form id="adminLoginForm"  method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="adminEmail" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="adminEmail" name="adminEmail" placeholder="Enter your email" required>
                    <div id="adminEmailError" class="text-danger mt-1" style="display: none;">Please enter a valid email (Google, Microsoft, Yahoo only).</div>
                </div>
                <div class="mb-2">
                    <label for="adminPassword" class="form-label text-muted">Password</label>
                    <input type="password" class="form-control" id="adminPassword" name="adminPassword" placeholder="Enter your password" required>
                    <div id="adminPasswordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="adminRememberMe">
                    <label class="form-check-label text-muted" for="adminRememberMe">Remember Me</label>
                </div>
                <button type="submit" id="adminLoginButton" name="adminLoginButton" class="btn btn-dark w-100" disabled>Login</button>
            </form>
            <div class="text-center mt-2">
                <a href="admin_forgot.php" class="text-decoration-none text-dark">Forgot Password?</a>
            </div>
        </div>
        <div class="card-footer text-center p-2">
            <p class="text-muted mb-0">Don't have an account? <a href="admin_registration.php" class="text-decoration-none text-dark">Sign up</a></p>
        </div>
    </div>
</div>

<script>
    const adminEmailField = document.getElementById('adminEmail');
    const adminPasswordField = document.getElementById('adminPassword');
    const adminLoginButton = document.getElementById('adminLoginButton');
    const adminEmailError = document.getElementById('adminEmailError');
    const adminPasswordError = document.getElementById('adminPasswordError');

    function validateAdminEmail() {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
        if (emailPattern.test(adminEmailField.value)) {
            adminEmailError.style.display = 'none';
            return true;
        } else {
            adminEmailError.style.display = 'block';
            return false;
        }
    }

    function validateAdminPassword() {
        const passwordLength = adminPasswordField.value.length;
        if (passwordLength >= 8 && passwordLength <= 12) {
            adminPasswordError.style.display = 'none';
            return true;
        } else {
            adminPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateAdminForm() {
        if (adminEmailField.value && adminPasswordField.value && validateAdminEmail() && validateAdminPassword()) {
            adminLoginButton.disabled = false;
        } else {
            adminLoginButton.disabled = true;
        }
    }

    adminEmailField.addEventListener('input', validateAdminForm);
    adminPasswordField.addEventListener('input', validateAdminForm);
    window.onload = validateAdminForm;
</script>

<?php
include("includes/footer.php");

if (isset($_POST['adminLoginButton'])) {   
    $adminEmail = $_POST['adminEmail'];  
    $adminPassword = $_POST['adminPassword'];   

    // Prepare a statement
    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_email = ?");
    $stmt->bind_param("s", $adminEmail); // "s" denotes the parameter is a string

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows == 1) {
        $row_user = $result->fetch_assoc();
        
        $adminEmail = $row_user['admin_email'];
        $adminPassword_hash = $row_user['admin_password'];
        $active = $row_user['active'];

        // Verify password
        if (password_verify($adminPassword, $adminPassword_hash)) {
            if ($active == 1) {
                session_regenerate_id(true); // Regenerate session ID to avoid session fixation
                $_SESSION['adminEmail'] = $adminEmail;        
                echo "<script>alert('You are Logged in Successfully!')</script>";          
                echo "<script>window.open('index.php','_self')</script>";
            } else {
                echo "<script>alert('Contact the authority to activate account!')</script>";          
                echo "<script>window.open('login.php','_self')</script>";
            }
        } else {
            echo "<script>alert('Your email or password is incorrect!')</script>";      
        }
    } else {
        echo "<script>alert('No account found with this email!')</script>";
    }

    // Close the statement
    $stmt->close();
}
?>
