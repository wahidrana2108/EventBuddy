<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Create New User</h3>
        </div>
        <div class="card-body p-3">
            <form id="createUserForm" action="process_create_user.php" method="POST">
                <div class="mb-2">
                    <label for="userName" class="form-label text-muted">User Name</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Enter user name" required>
                </div>
                <div class="mb-2">
                    <label for="userEmail" class="form-label text-muted">Email Address</label>
                    <input type="email" class="form-control" id="userEmail" name="userEmail" placeholder="Enter user email" required>
                    <div id="userEmailError" class="text-danger mt-1" style="display: none;">Please enter a valid email (Google, Microsoft, Yahoo only).</div>
                </div>
                <div class="mb-2">
                    <label for="userPassword" class="form-label text-muted">Password</label>
                    <input type="password" class="form-control" id="userPassword" name="userPassword" placeholder="Enter user password" required>
                    <div id="userPasswordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm user password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                </div>
                <button type="submit" id="createUserButton" class="btn btn-dark w-100" disabled>Create User</button>
            </form>
        </div>
    </div>
</div>

<script>
    const userEmailField = document.getElementById('userEmail');
    const userPasswordField = document.getElementById('userPassword');
    const confirmPasswordField = document.getElementById('confirmPassword');
    const createUserButton = document.getElementById('createUserButton');
    const userEmailError = document.getElementById('userEmailError');
    const userPasswordError = document.getElementById('userPasswordError');
    const confirmPasswordError = document.getElementById('confirmPasswordError');

    function validateUserEmail() {
        const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
        if (emailPattern.test(userEmailField.value)) {
            userEmailError.style.display = 'none';
            return true;
        } else {
            userEmailError.style.display = 'block';
            return false;
        }
    }

    function validateUserPassword() {
        const passwordLength = userPasswordField.value.length;
        if (passwordLength >= 8 && passwordLength <= 12) {
            userPasswordError.style.display = 'none';
            return true;
        } else {
            userPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateConfirmPassword() {
        if (userPasswordField.value === confirmPasswordField.value) {
            confirmPasswordError.style.display = 'none';
            return true;
        } else {
            confirmPasswordError.style.display = 'block';
            return false;
        }
    }

    function validateUserForm() {
        if (userEmailField.value && userPasswordField.value && confirmPasswordField.value &&
            validateUserEmail() && validateUserPassword() && validateConfirmPassword()) {
            createUserButton.disabled = false;
        } else {
            createUserButton.disabled = true;
        }
    }

    userEmailField.addEventListener('input', validateUserForm);
    userPasswordField.addEventListener('input', validateUserForm);
    confirmPasswordField.addEventListener('input', validateUserForm);
    window.onload = validateUserForm;
</script>

<?php include("includes/footer.php") ?>
