<?php
    require_once "../app/core/init.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="About Us page of our company. Learn more about our mission, vision, and team.">
    <title>About Us</title>
    <link rel="stylesheet" href="<?= ASSETS?>/css/about.css">
    <style>
    </style>
</head>
<body>
    <!-- Navbar -->
    <?php include_once "includes/header.php";?>
    <!-- About Us Section -->
    <section class="about-us">
        <div class="about-us-content">
            <h2>About Us</h2>
            <p>Welcome to Our MyAgent. We are committed to delivering the best services to our customers. Our team is made up of passionate professionals dedicated to excellence.</p>
            
            <div class="mission">
                <h3>Our Mission</h3>
                <p>Our mission is to provide innovative solutions that make life easier and better for our customers. We believe in quality, efficiency, and customer satisfaction.</p>
            </div>
            
            <div class="vision">
                <h3>Our Vision</h3>
                <p>Our vision is to be the leading provider of technology solutions, transforming industries and making a positive impact globally.</p>
            </div>

            <div class="team">
                <h3>Meet the Team</h3>
                <div class="team-members">
                    <div class="team-member">
                        <img src="profile-pictures/adminProfilePicture.png" alt="Team Member 1">
                        <h4>Emmanuel Michael</h4>
                        <p>CEO & Founder</p>
                    </div>
                    <div class="team-member">
                        <img src="profile-pictures/adminProfilePicture.png" alt="Team Member 2">
                        <h4>Easy Boy</h4>
                        <p>CTO</p>
                    </div>
                    <div class="team-member">
                        <img src="profile-pictures/adminProfilePicture.png" alt="Team Member 3">
                        <h4>Yusuf Mustapha</h4>
                        <p>Lead Designer</p>
                    </div>
                    <div class="team-member">
                        <img src="profile-pictures/adminProfilePicture.png" alt="Team Member 3">
                        <h4>Michael Brown</h4>
                        <p>Lead Designer</p>
                    </div>
                    <div class="team-member">
                        <img src="profile-pictures/adminProfilePicture.png" alt="Team Member 3">
                        <h4>Michael Brown</h4>
                        <p>Lead Designer</p>
                    </div>
                </div>
            </div>
        </div>
        <button id="contact-us-btn">Contact Us</button>
    </section>

    <!-- Contact Us Button -->

    <!-- Contact Info Card -->
    <div id="contact-card" class="contact-card">
        <div class="contact-card-content">
            <p><a href="mailto:emma08062602618@gmail.com" id="email-link">Email: emma08062602618@gmail.com</a></p>
            <hr>
            <p><a href="https://wa.me/08021102824" id="whatsapp-link">WhatsApp: +234 802 1102 824</a></p>
            <hr>
            <p><a href="tel:+2348021102824" id="phone-link">Phone: +234 802 1102 824</a></p>
            <button id="close-contact-card">Close</button>
        </div>
    </div>

    <!-- Email Form Card (hidden by default) -->
    <div id="email-form-card" class="contact-card">
        <div class="contact-card-content">
            <h3>Send Us a Message</h3>
            <form id="contact-form">
                <label for="name">Email:</label>
                <input type="email" id="email" required>
                <label for="message">Message:</label>
                <textarea id="message" rows="5" required></textarea>
                <button type="submit">Send</button>
            </form>
            <button id="close-email-form">Close</button>
        </div>
    </div>


    <!-- Footer Section -->
    <footer>
        <p>&copy; 2024 Hams. All rights reserved.</p>
    </footer>
    
    <!-- Optional JavaScript -->
    <script src="<?= ASSETS?>js/about.js"></script>
</body>
</html>