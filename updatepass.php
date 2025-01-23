<?php include("header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Update Password</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="updatePasswordForm">
                <div class="mb-2">
                    <label for="newPassword" class="form-label text-muted">New Password</label>
                    <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
                    <div id="passwordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your new password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                </div>
                <button type="submit" id="submitButton" class="btn btn-dark w-100" disabled>Update</button>
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
    const newPasswordField = document.getElementById('newPassword');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const submitButton = document.getElementById('submitButton');
    const passwordError = document.getElementById('passwordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    function validatePassword() {
        const passwordLength = newPasswordField.value.length;
        if (passwordLength >= 8 && passwordLength <= 12) {
            passwordError.style.display = 'none';
            return true;
        } else {
            passwordError.style.display = 'block';
            return false;
        }
    }

    function validateConfirmPassword() {
        if (confirmPasswordField.value === newPasswordField.value) {
            confirmPasswordError.style.display = 'none';
            return true;
        } else {
            confirmPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateForm() {
        if (newPasswordField.value && confirmPasswordField.value && validatePassword() && validateConfirmPassword()) {
            submitButton.disabled = false;
        } else {
            submitButton.disabled = true;
        }
    }

    newPasswordField.addEventListener('input', validateForm);
    confirmPasswordField.addEventListener('input', validateForm);

    window.onload = validateForm;
</script>

<?php include("footer.php") ?>
