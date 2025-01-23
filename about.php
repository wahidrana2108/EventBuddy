<?php include("header.php"); ?>

<div class="container my-5">
    <!-- Hero Section -->
    <div class="text-center py-5 bg-light rounded-3">
        <h1 class="fw-bold text-secondary">About Us</h1>
        <p class="text-secondary mt-3">Discover more about who we are, what we do, and how we bring unforgettable experiences to life.</p>
    </div>

    <!-- Our Story Section -->
    <div class="my-5">
        <h2 class="fw-bold text-secondary mb-4">Our Story</h2>
        <p class="text-secondary fs-5">
            Established in 2024, <strong>Your Event Website</strong> began with a simple idea: to create events that inspire, connect, and bring joy to people’s lives. Over the years, we have grown into a leading event management platform, helping individuals and organizations plan and execute memorable experiences. 
        </p>
        <p class="text-secondary fs-5">
            From intimate gatherings to large-scale corporate events, we specialize in crafting personalized and seamless solutions tailored to your unique needs. Our passion lies in bringing people together and making every moment unforgettable.
        </p>
    </div>

    <!-- Mission and Vision Section -->
    <div class="row my-5">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-secondary">Our Mission</h3>
                <p class="text-secondary mt-3">
                    To simplify event management through innovative technology and dedicated support, ensuring every event is a success and every client feels valued.
                </p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-secondary">Our Vision</h3>
                <p class="text-secondary mt-3">
                    To be a global leader in event management, renowned for creating exceptional experiences that leave a lasting impact.
                </p>
            </div>
        </div>
    </div>

    <!-- Team Section -->
    <div class="my-5">
        <h2 class="fw-bold text-secondary mb-4 text-center">Meet Our Team</h2>
        <div class="row g-4">
            <!-- Team Member 1 -->
            <div class="col-md-4 text-center">
                <img src="img/dev.png" alt="Team Member 1" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="fw-bold">John Doe</h5>
                <p class="text-secondary">Founder & CEO</p>
            </div>
            <!-- Team Member 2 -->
            <div class="col-md-4 text-center">
                <img src="img/dev.png" alt="Team Member 2" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="fw-bold">Jane Smith</h5>
                <p class="text-secondary">Event Manager</p>
            </div>
            <!-- Team Member 3 -->
            <div class="col-md-4 text-center">
                <img src="img/dev.png" alt="Team Member 3" class="rounded-circle mb-3" style="width: 150px; height: 150px; object-fit: cover;">
                <h5 class="fw-bold">Mark Johnson</h5>
                <p class="text-secondary">Creative Director</p>
            </div>
        </div>
    </div>

    <!-- Why Choose Us Section -->
    <div class="my-5">
        <h2 class="fw-bold text-secondary mb-4">Why Choose Us</h2>
        <ul class="list-unstyled text-secondary fs-5">
            <li class="mb-3"><i class="bi bi-check-circle-fill text-secondary me-2"></i>Experienced team of event planners and coordinators</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill text-secondary me-2"></i>Personalized solutions tailored to your needs</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill text-secondary me-2"></i>Comprehensive end-to-end event management</li>
            <li class="mb-3"><i class="bi bi-check-circle-fill text-secondary me-2"></i>Cutting-edge technology for seamless experiences</li>
            <li><i class="bi bi-check-circle-fill text-secondary me-2"></i>Commitment to quality and excellence</li>
        </ul>
    </div>

    <!-- Testimonials Section -->
    <div class="my-5">
        <h2 class="fw-bold text-secondary mb-4 text-center">What Our Clients Say</h2>
        <div class="owl-carousel owl-theme">
            <div class="item text-center">
                <blockquote class="blockquote text-secondary">
                    "Absolutely amazing! They made my wedding day stress-free and unforgettable. Highly recommend!"
                </blockquote>
                <footer class="blockquote-footer">Emily Rose</footer>
            </div>
            <div class="item text-center">
                <blockquote class="blockquote text-secondary">
                    "Professional, creative, and dedicated. Our corporate event was a huge success thanks to their team."
                </blockquote>
                <footer class="blockquote-footer">Michael Brown</footer>
            </div>
            <div class="item text-center">
                <blockquote class="blockquote text-secondary">
                    "Their attention to detail is unmatched. They went above and beyond to make our event perfect."
                </blockquote>
                <footer class="blockquote-footer">Sophia Taylor</footer>
            </div>
        </div>
    </div>
</div>

<!-- Initialize OwlCarousel -->
<script>
    $(document).ready(function(){
        $(".owl-carousel").owlCarousel({
            loop: true,
            margin: 20,
            nav: true,
            dots: true,
            items: 1,
        });
    });
</script>

<?php include("footer.php"); ?>
