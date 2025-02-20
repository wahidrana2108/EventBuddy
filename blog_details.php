<?php 
    include("includes/header.php");
    // Check if the blog ID is in the URL
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $blog_id = $_GET['id'];
        
        // Fetch blog data for the given blog ID
        $stmt = $conn->prepare("SELECT blog_id, blog_name, blog_desc, blog_bann, upload_date FROM blogs WHERE blog_id = ?");
        $stmt->bind_param("i", $blog_id);
        $stmt->execute();
        $stmt->bind_result($blog_id, $blog_name, $blog_desc, $blog_bann, $upload_date);
        
        if ($stmt->fetch()) {
            // Blog data fetched successfully
            // You can now use $blog_id, $blog_name, $blog_desc, $blog_bann, $upload_date in your HTML/PHP code below
            // ...
        } else {
            // Blog ID not found, redirect to the error page
            echo "<script>window.open('error.php','_self')</script>";
            exit();
        }
        $stmt->close();
    } else {
        // Redirect to the error page if the blog ID is not set or is empty
        echo "<script>window.open('error.php','_self')</script>";
        exit();
    }

    ?>

    <div class="container mt-4">
        <div class="card glass-card border-0 shadow-lg">
            <div class="card-header bg-dark text-white text-center">
                <h3 class="mb-0"><?php echo $blog_name; ?></h3>
            </div>
            <div class="card-body p-3">
                <img src="img/banner/<?php echo $blog_bann; ?>" alt="Blog Image" class="img-fluid mb-3" style="display: block; margin: 0 auto;">
                <p class="text-muted">Posted on: <?php echo date('Y-m-d', strtotime($upload_date)); ?></p>
                <p><?php echo $blog_desc; ?></p>
            </div>
        </div>

        <section class="blogs-section py-5">
            <h2 class="text-center">Other Blogs</h2>
            <div class="container mt-3">
                <div class="owl-carousel owl-theme">
                    <?php
                        // Fetch other blogs
                        $query = "SELECT blog_id, blog_name, blog_bann, upload_date FROM blogs WHERE blog_id != ?";
                        $stmt = $conn->prepare($query);
                        $stmt->bind_param("i", $blog_id);
                        $stmt->execute();
                        $stmt->bind_result($other_blog_id, $other_blog_name, $other_blog_bann, $other_upload_date);
                        while ($stmt->fetch()): ?>
                            <div class="item">
                                <div class="card bg-light shadow-sm p-3">
                                    <img src="img/banner/<?php echo $other_blog_bann; ?>" class="card-img-top rounded" alt="<?php echo $other_blog_name; ?>">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $other_blog_name; ?></h5>
                                        <p class="text-muted">Posted on: <?php echo date('Y-m-d', strtotime($other_upload_date)); ?></p>
                                        <a href="blog_details.php?id=<?php echo $other_blog_id; ?>" class="btn btn-secondary btn-sm">Read More</a>
                                    </div>
                                </div>
                            </div>
                    <?php endwhile; $stmt->close(); ?>
                </div>
            </div>
        </section>
    </div>

    <?php 
    $conn->close();
    include("includes/footer.php"); 
    ?>
