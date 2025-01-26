<?php include("includes/header.php") ?>

<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card glass-card border-0 shadow-lg" style="width: 500px;">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Create Blog</h3>
        </div>
        <div class="card-body p-3 ">
            <form id="createBlogForm">
                <div class="mb-2">
                    <label for="blogName" class="form-label text-muted">Blog Name</label>
                    <input type="text" class="form-control" id="blogName" placeholder="Enter blog name" required>
                </div>
                <div class="mb-2">
                    <label for="blogDescription" class="form-label text-muted">Description</label>
                    <textarea class="form-control" id="blogDescription" placeholder="Enter blog description" required></textarea>
                </div>
                <div class="mb-2">
                    <label for="bannerPicture" class="form-label text-muted">Banner Picture</label>
                    <input type="file" class="form-control" id="bannerPicture" required>
                    <div id="bannerPictureError" class="text-danger mt-1" style="display: none;"></div>
                </div>
                <button type="submit" id="submitButton" class="btn btn-dark w-100" disabled>Create</button>
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
                    return true;
                } else {
                    bannerPictureError.style.display = 'block';
                    bannerPictureError.textContent = 'Image dimensions must be 600x300 pixels.';
                    return false;
                }
            };
            img.onerror = function() {
                bannerPictureError.style.display = 'block';
                bannerPictureError.textContent = 'Invalid image file.';
                return false;
            };
            img.src = URL.createObjectURL(file);
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
            bannerPictureField.value &&
            validateBannerPicture();

        submitButton.disabled = !isFormValid;
    }

    blogNameField.addEventListener('input', validateForm);
    blogDescriptionField.addEventListener('input', validateForm);
    bannerPictureField.addEventListener('change', () => {
        validateBannerPicture();
        validateForm();
    });

    // Initialize validation
    window.onload = validateForm;
</script>

<?php include("includes/footer.php") ?>
