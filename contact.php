<?php include("includes/header.php"); ?>

<div class="container my-5">
    <!-- Contact Info -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-secondary">Contact Us</h2>
        <p class="text-secondary">We would love to hear from you! Please reach out using the contact form or any of the contact details below.</p>
        <div class="mt-4">
            <p class="mb-1"><strong>Phone:</strong> <a href="tel:+8801770888280" class="text-decoration-none text-secondary">+8801770888280</a></p>
            <p class="mb-1"><strong>Email:</strong> <a href="mailto:support@youreventwebsite.com" class="text-decoration-none text-secondary">support@youreventwebsite.com</a></p>
            <p><strong>Address:</strong> 123 Event Street, Dhaka, Bangladesh</p>
        </div>
    </div>

    <!-- Form and Map Section -->
    <div class="row g-5 align-items-start">
        <!-- Contact Form -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0 p-4">
                <h3 class="text-secondary mb-4">Send Us a Message</h3>
                <form id="contactForm" onsubmit="return validateForm()">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="name" placeholder="Your Name" required>
                        <label for="name">Your Name</label>
                        <div id="nameError" class="text-danger mt-1 d-none">Please enter your name.</div>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" placeholder="Your Email" required>
                        <label for="email">Your Email</label>
                        <div id="emailError" class="text-danger mt-1 d-none">Please enter a valid email address (e.g., @gmail.com, @outlook.com).</div>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="message" placeholder="Your Message" style="height: 150px;" required></textarea>
                        <label for="message">Your Message</label>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100">Send Message</button>
                </form>
            </div>
        </div>

        <!-- Google Map -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <h3 class="text-secondary p-3">Our Location</h3>
                <iframe class="google-map w-100" style="height: 300px; border-radius: 0 0 10px 10px;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.741436124197!2d90.36577321574159!3d23.81031518458458!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7987d634a4f%3A0x4c7c68c9c96455d!2sDhaka%20City!5e0!3m2!1sen!2sbd!4v1673640842850!5m2!1sen!2sbd" loading="lazy" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>

<script>
    function validateForm() {
        const nameField = document.getElementById('name');
        const emailField = document.getElementById('email');
        const messageField = document.getElementById('message');
        let valid = true;

        // Validate Name
        if (nameField.value.trim() === "") {
            document.getElementById('nameError').classList.remove('d-none');
            valid = false;
        } else {
            document.getElementById('nameError').classList.add('d-none');
        }

        // Validate Email
        const emailPattern = /^[a-zA-Z0-9._%+-]+@(gmail\.com|outlook\.com|yahoo\.com)$/;
        if (!emailPattern.test(emailField.value.trim())) {
            document.getElementById('emailError').classList.remove('d-none');
            valid = false;
        } else {
            document.getElementById('emailError').classList.add('d-none');
        }

        // Validate Message
        if (messageField.value.trim() === "") {
            alert("Please enter your message.");
            valid = false;
        }

        return valid;
    }
</script>

<?php include("includes/footer.php"); ?>
