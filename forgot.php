<?php include("header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Forgot Password</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="forgotPasswordForm">
                <div class="mb-2">
                    <label for="email" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                    <div id="emailError" class="text-danger mt-1" style="display: none;">Please enter a valid email (Google, Microsoft, Yahoo only).</div>
                </div>
                <button type="submit" id="submitButton" class="btn btn-dark w-100" disabled>Submit</button>
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

    function validateForm() {
        if (emailField.value && validateEmail()) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    emailField.addEventListener('input', validateForm);

    window.onload = validateForm;
</script>

<?php include("footer.php") ?>
