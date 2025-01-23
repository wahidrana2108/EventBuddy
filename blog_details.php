<?php include("header.php") ?>

<div class="container mt-4">
    <div class="card glass-card border-0 shadow-lg">
        <div class="card-header bg-dark text-white text-center">
            <h3 class="mb-0">Blog Title</h3>
        </div>
        <div class="card-body p-3">
            <img src="blog_image.jpg" alt="Blog Image" class="img-fluid mb-3">
            <p class="text-muted">Posted on: 2025-01-15</p>
            <p>Blog content goes here. This is where the details of the blog will be displayed, including any text, images, or other media related to the blog post.</p>
        </div>
    </div>

    <section class="blogs-section py-5">
    <h2 class="text-center">Other Blogs</h2>
    <div class="container mt-3">
        <div class="owl-carousel owl-theme">
            <div class="item">
                <div class="card bg-light shadow-sm p-3">
                    <img src="img/banner/blog1.png" class="card-img-top rounded" alt="Blog 1">
                    <div class="card-body">
                        <h5 class="card-title">How to Plan the Perfect Event</h5>
                        <p class="card-text">Discover tips and tricks to organize the most memorable events with ease.</p>
                        <a href="blog_details.php?id=2" class="btn btn-secondary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="card bg-light shadow-sm p-3">
                    <img src="img/banner/blog1.png" class="card-img-top rounded" alt="Blog 2">
                    <div class="card-body">
                        <h5 class="card-title">Top 5 Event Venues in 2025</h5>
                        <p class="card-text">Explore the best venues for hosting events in 2025.</p>
                        <a href="blog_details.php?id=2" class="btn btn-secondary btn-sm">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<?php include("footer.php") ?>
