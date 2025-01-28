<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Create Blog</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="createBlogForm" method="post" enctype="multipart/form-data">
                <div class="mb-2">
                    <label for="blogName" class="form-label text-muted">Blog Name</label>
                    <input type="text" class="form-control" id="blogName" name="blogName" placeholder="Enter blog name" required>
                </div>
                <div class="mb-2">
                    <label for="blogDescription" class="form-label text-muted">Description</label>
                    <textarea class="form-control" id="blogDescription" name="blogDescription" placeholder="Enter blog description" required></textarea>
                </div>
                <div class="mb-2">
                    <label for="bannerPicture" class="form-label text-muted">Banner Picture</label>
                    <input type="file" class="form-control" id="bannerPicture" name="bannerPicture" required>
                    <div id="bannerPictureError" class="text-danger mt-1" style="display: none;"></div>
                </div>
                <button type="submit" id="submitButton" name="submitButton" class="btn btn-dark w-100" disabled>Create</button>
            </form>
        </div>
    </div>
</div>

<script>
    const blogNameField = document.getElementById('blogName');
    const blogDescriptionField = document.getElementById('blogDescription');
    const bannerPictureField = document.getElementById('bannerPicture');
    const bannerPictureError = document.getElementById('bannerPictureError');
    const submitButton = document.getElementById('submitButton');

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
            bannerPictureField.files[0];

        submitButton.disabled = !isFormValid;
    }

    blogNameField.addEventListener('input', validateForm);
    blogDescriptionField.addEventListener('input', validateForm);
    bannerPictureField.addEventListener('change', () => {
        validateBannerPicture();
    });

    // Initialize validation
    window.onload = validateForm;
</script>


<?php include("includes/footer.php");

    if(isset($_POST["submitButton"])) {
        $blog_name = $_POST['blogName'];
        $blog_desc = $_POST['blogDescription'];
        $blog_image = $_FILES['bannerPicture']['name'];
        $blog_image_tmp = $_FILES['bannerPicture']['tmp_name'];

        // Move the uploaded file to the target directory
        move_uploaded_file($blog_image_tmp, "../img/banner/$blog_image");

        // Prepare the SQL statement
        $stmt = $conn->prepare('INSERT INTO blogs (blog_name, blog_desc, blog_bann) VALUES (?, ?, ?)');
        $stmt->bind_param('sss', $blog_name, $blog_desc, $blog_image);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>alert('Blog successfully uploaded!')</script>";
            echo "<script>window.location.href='create_blog.php'</script>";
        } else {
            echo "<script>alert('Error uploading blog: " . $stmt->error . "')</script>";
        }

        // Close the statement
        $stmt->close();
    }
?>
