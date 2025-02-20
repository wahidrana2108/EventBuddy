<?php 
        include("includes/header.php"); 

       // Fetch blog data
       $blogs = [];
       $query = "SELECT blog_id, blog_name, blog_bann, upload_date FROM blogs";
       $result = mysqli_query($conn, $query);
       while ($row = mysqli_fetch_assoc($result)) {
           $blogs[] = $row;
       }
?>

<!-- Hero Section -->
<section class="hero-section text-center py-5">
    <div class="container">
        <h1>Welcome to Event Buddy</h1>
        <p>Your one-stop platform for managing and discovering exciting events.</p>
        <a href="events.php" class="btn btn-secondary">Get Started</a>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section py-5 bg-light">
    <div class="container text-center">
        <h2>Our Achievements</h2>
        <div class="row gy-4">
            <div class="col-md-3">
                <div class="stats-card py-4 px-3 hover-effect">
                    <div class="stat-icon mb-3">
                        <img src="img/images.png" alt="Users Icon">
                    </div>
                    <h3 class="fw-bold">50K+</h3>
                    <p>Registered Users</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card py-4 px-3 hover-effect">
                    <div class="stat-icon mb-3">
                        <img src="img/active.png" alt="Events Icon">
                    </div>
                    <h3 class="fw-bold">10K+</h3>
                    <p>Successful Events</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card py-4 px-3 hover-effect">
                    <div class="stat-icon mb-3">
                        <img src="img/calendar.png" alt="Active Events Icon">
                    </div>
                    <h3 class="fw-bold">1.5K+</h3>
                    <p>Active Events</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stats-card py-4 px-3 hover-effect">
                    <div class="stat-icon mb-3">
                        <img src="img/success.png" alt="Satisfaction Icon">
                    </div>
                    <h3 class="fw-bold">98%</h3>
                    <p>Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Blog Section -->
<section class="blogs-section py-5">
    <h2 class="text-center">Our Latest Blogs</h2>
    <div class="container mt-3">
        <div class="owl-carousel owl-theme">
            <?php foreach ($blogs as $blog): ?>
                <div class="item">
                    <div class="card bg-light shadow-sm p-3">
                        <img src="img/banner/<?php echo $blog['blog_bann']; ?>" class="card-img-top rounded" alt="<?php echo $blog['blog_name']; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $blog['blog_name']; ?></h5>
                            <p class="text-muted">Posted on: <?php echo date('Y-m-d', strtotime($blog['upload_date'])); ?></p>                            <a href="blog_details.php?id=<?php echo $blog['blog_id']; ?>" class="btn btn-secondary btn-sm">Read More</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- User Ratings Section -->
<section class="container mt-5">
    <h2 class="text-center">What Our Users Say</h2>
    <div class="owl-carousel owl-theme mt-3">
        <div class="item">
            <div class="card bg-light shadow-sm p-3 text-center">
                <div class="card-body">
                    <i class="fas fa-quote-left fa-2x mb-3"></i>
                    <p>"EventHub is amazing! I managed my wedding seamlessly."</p>
                    <h5>- Jane Doe</h5>
                    <i class="fas fa-quote-right fa-2x mt-3"></i>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card bg-light shadow-sm p-3 text-center">
                <div class="card-body">
                    <i class="fas fa-quote-left fa-2x mb-3"></i>
                    <p>"I found my perfect event venue here. Highly recommended!"</p>
                    <h5>- John Smith</h5>
                    <i class="fas fa-quote-right fa-2x mt-3"></i>
                </div>
            </div>
        </div>
        <div class="item">
            <div class="card bg-light shadow-sm p-3 text-center">
                <div class="card-body">
                    <i class="fas fa-quote-left fa-2x mb-3"></i>
                    <p>"Great platform for event management. Made everything so easy."</p>
                    <h5>- Emily Clark</h5>
                    <i class="fas fa-quote-right fa-2x mt-3"></i>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include("includes/footer.php"); ?>
