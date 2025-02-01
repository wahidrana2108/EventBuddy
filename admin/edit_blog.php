<?php
include("includes/header.php"); 

// Check if the user is logged in
if (!isset($_SESSION['adminEmail'])) {
    header("Location: login.php");
    exit();
}

// Check if the blog ID is set
if (isset($_GET['id'])) {
    $blog_id = $_GET['id'];

    // Fetch the current blog details
    $query = "SELECT blog_name, blog_desc, blog_bann, upload_date FROM blogs WHERE blog_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $blog_id);
    $stmt->execute();
    $stmt->bind_result($blog_name, $blog_desc, $blog_bann, $upload_date);
    $stmt->fetch();
    $stmt->close();
} else {
    // Redirect to the blogs management page with an error message
    header("Location: blogs.php");
    exit();
}
?>

<div class="container mt-4">
    <h2 class="mb-4">Edit Blog</h2>
    <form action="update_blog.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <input type="hidden" name="blog_id" value="<?php echo htmlspecialchars($blog_id); ?>">
        <div class="mb-3">
            <label for="blog_name" class="form-label">Blog Name</label>
            <input type="text" class="form-control" id="blog_name" name="blog_name" value="<?php echo htmlspecialchars($blog_name, ENT_QUOTES, 'UTF-8'); ?>" required>
        </div>
        <div class="mb-3">
            <label for="blog_desc" class="form-label">Blog Description</label>
            <textarea class="form-control" id="blog_desc" name="blog_desc" rows="5" required><?php echo htmlspecialchars($blog_desc, ENT_QUOTES, 'UTF-8'); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="blog_bann" class="form-label">Blog Banner</label>
            <input type="file" class="form-control" id="blog_bann" name="blog_bann" onchange="validateBannerPicture()">
            <small class="form-text text-muted">Current Banner: <?php echo htmlspecialchars($blog_bann, ENT_QUOTES, 'UTF-8'); ?></small>
            <div id="bannerPictureError" class="text-danger" style="display: none;"></div>
        </div>
        <button type="submit" class="btn btn-primary">Update Blog</button>
    </form>
</div>

<?php 
$conn->close();
include("includes/footer.php"); 
?>

<script>
    const blogNameField = document.getElementById('blog_name');
const blogDescriptionField = document.getElementById('blog_desc');
const bannerPictureField = document.getElementById('blog_bann');
const bannerPictureError = document.getElementById('bannerPictureError');
const submitButton = document.querySelector('button[type="submit"]');

function validateBannerPicture() {
    const file = bannerPictureField.files[0];
    if (file) {
        const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        if (!validTypes.includes(file.type)) {
            bannerPictureError.style.display = 'block';
            bannerPictureError.textContent = 'Only JPG, PNG, or GIF files are allowed.';
            return false;
        }

        if (file.size > maxSize) {
            bannerPictureError.style.display = 'block';
            bannerPictureError.textContent = 'File size must not exceed 2MB.';
            return false;
        }

        const img = new Image();
        img.onload = function() {
            if (img.width === 600 && img.height === 300) {
                bannerPictureError.style.display = 'none';
                validateForm();  // Call validateForm after successful image loading
            } else {
                bannerPictureError.style.display = 'block';
                bannerPictureError.textContent = 'Image dimensions must be 600x300 pixels.';
            }
        };
        img.onerror = function() {
            bannerPictureError.style.display = 'block';
            bannerPictureError.textContent = 'Invalid image file.';
        };
        img.src = URL.createObjectURL(file);
        return false;
    } else {
        bannerPictureError.style.display = 'block';
        bannerPictureError.textContent = 'Please upload a banner picture.';
        return false;
    }
}

function validateForm() {
    const isFormValid =
        blogNameField.value &&
        blogDescriptionField.value &&
        bannerPictureField.files.length > 0 &&
        bannerPictureError.style.display === 'none';

    submitButton.disabled = !isFormValid;
    return isFormValid;
}
</script>