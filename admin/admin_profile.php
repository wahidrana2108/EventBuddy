<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">User Profile</h3>
        </div>
        <div class="card-body p-3">
            <h5 class="mb-3">Profile Details</h5>
            <p><strong></strong> <img src="profile.jpg" alt="Profile Picture" class="img-thumbnail" style="width: 100px;"></p>
            <p><strong>Full Name:</strong> John Doe</p>
            <p><strong>Email:</strong> john.doe@example.com</p>
            <p><strong>Phone Number:</strong> 0123456789</p>
            
            <h5 class="mt-4 mb-3">Update Password</h5>
            <form id="updatePasswordForm">
                <div class="mb-2">
                    <label for="currentPassword" class="form-label text-muted">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" placeholder="Enter current password" required>
                </div>
                <div class="mb-2">
                    <label for="newPassword" class="form-label text-muted">New Password</label>
                    <input type="password" class="form-control" id="newPassword" placeholder="Enter new password" required>
                    <div id="newPasswordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmNewPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmNewPassword" placeholder="Confirm new password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                </div>
                <button type="submit" id="updateButton" class="btn btn-dark w-100" disabled>Update Password</button>
            </form>
        </div>
    </div>
</div>

<script>
    const currentPasswordField = document.getElementById('currentPassword');
    const newPasswordField = document.getElementById('newPassword');
    const confirmNewPasswordField = document.getElementById('confirmNewPassword');
    const updateButton = document.getElementById('updateButton');
    const newPasswordError = document.getElementById('newPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    function validateNewPassword() {
        const passwordLength = newPasswordField.value.length;
        if (passwordLength >= 8 && passwordLength <= 12) {
            newPasswordError.style.display = 'none';
            return true;
        } else {
            newPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateConfirmPassword() {
        if (confirmNewPasswordField.value === newPasswordField.value) {
            confirmPasswordError.style.display = 'none';
            return true;
        } else {
            confirmPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateForm() {
        if (currentPasswordField.value && validateNewPassword() && validateConfirmPassword()) {
            updateButton.disabled = false;
        } else {
            updateButton.disabled = true;
        }
    }

    currentPasswordField.addEventListener('input', validateForm);
    newPasswordField.addEventListener('input', validateForm);
    confirmNewPasswordField.addEventListener('input', validateForm);

    window.onload = validateForm;
</script>

<?php include("includes/footer.php") ?>
