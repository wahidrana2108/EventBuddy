<?php
    include("includes/header.php");

        // Check if the user is logged in
        if (!isset($_SESSION['adminEmail'])) {
            header("Location: login.php");
            exit();
        }

    $adminEmail = $_SESSION['adminEmail']; // Assuming you store adminEmail in session after login

    $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_email = ?");
    $stmt->bind_param("s", $adminEmail);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $adminName = $row['admin_name'];
        $adminPhn = $row['admin_phn'];
        $adminEmail = $row['admin_email'];
        $adminDp = $row['admin_dp']; // Assuming this is the path to profile picture
    }

?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg w-100">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">User Profile</h3>
        </div>
        <div class="card-body p-3">
            <h5 class="mb-3">Profile Details</h5>
            <p><strong>Profile Picture:</strong> <img src="img/users/<?php echo $adminDp; ?>" alt="Profile Picture" class="img-thumbnail" style="width: 100px;"></p>
            <p><strong>Full Name:</strong> <?php echo $adminName; ?></p>
            <p><strong>Email:</strong> <?php echo $adminEmail; ?></p>
            <p><strong>Phone Number:</strong> <?php echo $adminPhn; ?></p>
            
            <h5 class="mt-4 mb-3">Update Password</h5>
            <form id="updatePasswordForm" method="POST">
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
                <button type="submit" name="updateButton" id="updateButton" class="btn btn-dark w-100" disabled>Update Password</button>
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

if (isset($_POST['updateButton'])) {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmNewPassword = $_POST['confirmNewPassword'];

    // Check if current password matches
    if (password_verify($currentPassword, $row['admin_password'])) {
        // Check if new passwords match
        if ($newPassword === $confirmNewPassword) {
            // Hash the new password
            $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update the password in the database
            $stmt = $conn->prepare("UPDATE admin SET admin_password = ? WHERE admin_email = ?");
            $stmt->bind_param("ss", $newPasswordHash, $adminEmail);
            if ($stmt->execute()) {
                echo "<script>alert('Password updated successfully!')</script>";
                echo "<script>window.location.href='profile.php'</script>";
            } else {
                echo "<script>alert('Error updating password.')</script>";
            }
            $stmt->close();
        } else {
            echo "<script>alert('New passwords do not match.')</script>";
        }
    } else {
        echo "<script>alert('Current password is incorrect.')</script>";
    }
}

include("includes/footer.php");
?>
