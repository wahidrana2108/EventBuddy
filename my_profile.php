<?php 
include("includes/header.php");

// Check if the user is logged in
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit();
}

// Fetch user details based on the session user ID
$user_email = $_SESSION['user_email'];

$user_query = $conn->prepare("SELECT first_name, last_name, user_email, user_phn, user_gender, user_dp, user_pass FROM users WHERE user_email = ?");
$user_query->bind_param("s", $user_email);
$user_query->execute();
$user_query->bind_result($first_name, $last_name, $user_email, $user_phn, $user_gender, $user_dp, $current_hashed_pass);
$user_query->fetch();
$user_query->close();
?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">User Profile</h3>
        </div>
        <div class="card-body p-3">
            <h5 class="mb-3">Profile Details</h5>
            <p><img src="img/users/<?php echo htmlspecialchars($user_dp, ENT_QUOTES, 'UTF-8'); ?>" alt="Profile Picture" class="img-thumbnail" style="width: 100px;"></p>
            <p><strong>Full Name:</strong> <?php echo htmlspecialchars($first_name . ' ' . $last_name, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user_email, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user_phn, ENT_QUOTES, 'UTF-8'); ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($user_gender, ENT_QUOTES, 'UTF-8'); ?></p>
            
            <h5 class="mt-4 mb-3">Update Password</h5>
            <form method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="currentPassword" class="form-label text-muted">Current Password</label>
                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter current password" required>
                </div>
                <div class="mb-2">
                    <label for="newPassword" class="form-label text-muted">New Password</label>
                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                    <div id="newPasswordError" class="text-danger mt-1" style="display: none;">Password must be between 8 to 12 characters.</div>
                </div>
                <div class="mb-2">
                    <label for="confirmNewPassword" class="form-label text-muted">Confirm Password</label>
                    <input type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm new password" required>
                    <div id="confirmPasswordError" class="text-danger mt-1" style="display: none;">Passwords do not match.</div>
                </div>
                <button type="submit" name="updateButton" class="btn btn-dark w-100">Update Password</button>
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

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['updateButton'])) {
    $old_pass = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $newPasswordConfirm = $_POST['confirmNewPassword'];

    if (password_verify($old_pass, $current_hashed_pass)) {
        if ($newPassword === $newPasswordConfirm) {
            if (password_verify($newPassword, $current_hashed_pass)) {
                echo "<script>alert('Password already in use. Choose a different one!');</script>";
            } else {
                $hash = password_hash($newPassword, PASSWORD_DEFAULT);
                $update_stmt = $conn->prepare("UPDATE users SET user_pass = ? WHERE user_email = ?");
                $update_stmt->bind_param("ss", $hash, $user_email);
                if ($update_stmt->execute()) {
                    echo "<script>alert('Password Updated Successfully!');</script>";
                    echo "<script>window.open('my_account.php','_self');</script>";
                } else {
                    echo "<script>alert('Error updating password. Please try again later.');</script>";
                }
                $update_stmt->close();
            }
        } else {
            echo "<script>alert('New password and confirm password do not match!');</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect!');</script>";
    }
}
include("includes/footer.php");
?>
