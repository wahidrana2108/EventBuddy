<footer class="bg-dark text-white py-4 mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>About Event Manager</h5>
                    <p>Event Manager is your go-to platform for creating, managing, and participating in exciting events. Whether it's a birthday, anniversary, or office party, we make it easy to bring your ideas to life.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="events.php" class="text-white text-decoration-none">My Events</a></li>
                        <li><a href="about.php" class="text-white text-decoration-none">About Us</a></li>
                        <li><a href="contact.php" class="text-white text-decoration-none">Contact Us</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-geo-alt-fill"></i> 123 Event Lane, Cityville</li>
                        <li><i class="bi bi-telephone-fill"></i> +8801770888280</li>
                        <li><i class="bi bi-envelope-fill"></i> info@eventmanager.com</li>
                    </ul>
                    <h6 class="mt-3">Follow Us</h6>
                    <div>
                        <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="text-white"><i class="bi bi-instagram"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="text-center">
                <p class="mb-0">&copy; 2025 Event Manager. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".owl-carousel").owlCarousel({
                loop: true,
                margin: 15,
                nav: true,
                dots: true,
                autoplay: true,
                autoplayTimeout: 3000,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1200: { items: 3 }
                }
            });
        });
    </script>

    <script>
            function searchFunction() {
                let input = document.getElementById("input").value;
                if (input.length > 0) {
                    let xhr = new XMLHttpRequest();
                    xhr.open("POST", "live_search.php", true);
                    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function() {
                        if (xhr.readyState == 4 && xhr.status == 200) {
                            document.getElementById("result").innerHTML = xhr.responseText;
                        }
                    }
                    xhr.send("input=" + input);
                } else {
                    document.getElementById("result").innerHTML = "";
                }
            }
        </script>
</body>
</html>
