<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Login</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="loginForm">
                <div class="mb-2">
                    <label for="email" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    <div id="emailError" class="text-danger mt-1" style="display: none;">Please enter a valid email (Google, Microsoft, Yahoo only).</div>
                </div>
                <div class="mb-2">
                    <label for="password" class="form-label text-muted">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                    <div id="passwordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="form-check mb-2">
                    <input type="checkbox" class="form-check-input" id="rememberMe">
                    <label class="form-check-label text-muted" for="rememberMe">Remember Me</label>
                </div>
                <button type="submit" id="loginButton" class="btn btn-dark w-100" disabled>Login</button>
            </form>
            <div class="text-center mt-2">
                <a href="forgot.php" class="text-decoration-none text-dark">Forgot Password?</a>
            </div>
        </div>
        <div class="card-footer text-center p-2">
            <p class="text-muted mb-0">Don't have an account? <a href="registration.php" class="text-decoration-none text-dark">Sign up</a></p>
        </div>
    </div>
</div>

<script>
    const emailField = document.getElementById('email');
    const passwordField = document.getElementById('password');
    const loginButton = document.getElementById('loginButton');
    const emailError = document.getElementById('emailError');
    const passwordError = document.getElementById('passwordError');
    
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

    function validateForm() {
        if (emailField.value && passwordField.value && validateEmail() && validatePassword()) {
            loginButton.disabled = false;
        } else {
            loginButton.disabled = true;
        }
    }

    emailField.addEventListener('input', validateForm);
    passwordField.addEventListener('input', validateForm);
    window.onload = validateForm;
</script>

<?php include("includes/footer.php") ?>
