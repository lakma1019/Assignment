<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E_wings Pvt(Ltd) - Professional IT Equipment Management</title>
    <link rel="stylesheet" href="../frontend/index.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <!-- Hero Section with Background Slideshow -->
    <section class="hero">
        <div class="slideshow-container">
            <div class="slide active" style="background-image: url('../frontend/images/i1.jpeg')"></div>
            <div class="slide" style="background-image: url('../frontend/images/i2.jpeg')"></div>
            <div class="slide" style="background-image: url('../frontend/images/i3.jpg')"></div>
            <div class="slide-overlay"></div>
        </div>
        
        <div class="hero-content">
            <h1 class="hero-title">Welcome to E_wings Pvt(Ltd)</h1>
            <p class="hero-subtitle">Your Premier IT Equipment Management Solution</p>
            <p class="hero-description">
                Empowering businesses with cutting-edge technology solutions, comprehensive equipment management, 
                and unparalleled technical support services.
            </p>
            <div class="hero-buttons">
                <a href="#services" class="btn btn-primary">Our Services</a>
                <a href="#contact" class="btn btn-secondary">Get Quote</a>
            </div>
        </div>
        
        <!-- Slideshow Navigation -->
        <div class="slideshow-nav">
            <button class="nav-dot active" onclick="currentSlide(1)"></button>
            <button class="nav-dot" onclick="currentSlide(2)"></button>
            <button class="nav-dot" onclick="currentSlide(3)"></button>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="services">
        <div class="container">
            <h2 class="section-title">Our Comprehensive Services</h2>
            <div class="services-grid">
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-desktop"></i>
                    </div>
                    <h3>IT Equipment Supply</h3>
                    <p>Complete range of computers, laptops, servers, and networking equipment from leading brands.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-tools"></i>
                    </div>
                    <h3>Equipment Management</h3>
                    <p>Professional installation, configuration, and ongoing maintenance of your IT infrastructure.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Technical Support</h3>
                    <p>24/7 technical support and troubleshooting services to keep your business running smoothly.</p>
                </div>
                
                <div class="service-card">
                    <div class="service-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3>Security Solutions</h3>
                    <p>Advanced cybersecurity measures and data protection solutions for your peace of mind.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about">
        <div class="container">
            <div class="about-content">
                <div class="about-text">
                    <h2>About E_wings Pvt(Ltd)</h2>
                    <p>
                        With years of experience in the IT industry, E_wings Pvt(Ltd) has established itself as a trusted 
                        partner for businesses seeking reliable technology solutions. We specialize in providing comprehensive 
                        IT equipment management services that help organizations optimize their technology investments.
                    </p>
                    <p>
                        Our team of certified professionals is dedicated to delivering exceptional service quality, 
                        ensuring that your IT infrastructure operates at peak performance while minimizing downtime and costs.
                    </p>
                    <div class="about-stats">
                        <div class="stat">
                            <h3>500+</h3>
                            <p>Happy Clients</p>
                        </div>
                        <div class="stat">
                            <h3>10+</h3>
                            <p>Years Experience</p>
                        </div>
                        <div class="stat">
                            <h3>24/7</h3>
                            <p>Support Available</p>
                        </div>
                    </div>
                </div>
                <div class="about-image">
                    <div class="image-placeholder">
                        <i class="fas fa-laptop-code"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features">
        <div class="container">
            <h2 class="section-title">Why Choose E_wings?</h2>
            <div class="features-grid">
                <div class="feature-item">
                    <i class="fas fa-award"></i>
                    <h4>Certified Professionals</h4>
                    <p>Industry-certified technicians with extensive experience</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-shipping-fast"></i>
                    <h4>Fast Delivery</h4>
                    <p>Quick procurement and delivery of IT equipment</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-dollar-sign"></i>
                    <h4>Competitive Pricing</h4>
                    <p>Best market rates with flexible payment options</p>
                </div>
                <div class="feature-item">
                    <i class="fas fa-handshake"></i>
                    <h4>Trusted Partner</h4>
                    <p>Long-term partnerships with satisfied customers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="contact">
        <div class="container">
            <h2 class="section-title">Get In Touch</h2>
            <div class="contact-content">
                <div class="contact-info">
                    <h3>Ready to Transform Your IT Infrastructure?</h3>
                    <p>Contact us today for a free consultation and discover how E_wings can help your business thrive with the right technology solutions.</p>
                    
                    <div class="contact-details">
                        <div class="contact-item">
                            <i class="fas fa-phone"></i>
                            <span>+94 11 234 5678</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>info@ewings.lk</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Colombo, Sri Lanka</span>
                        </div>
                    </div>
                </div>
                
                <div class="contact-form">
                    <form method="POST" action="index.php">
                        <input type="text" name="name" placeholder="Your Name" required>
                        <input type="email" name="email" placeholder="Your Email" required>
                        <input type="tel" name="phone" placeholder="Your Phone">
                        <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
                        <button type="submit" name="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h4>E_wings Pvt(Ltd)</h4>
                    <p>Your trusted partner for professional IT equipment management and technology solutions.</p>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Follow Us</h4>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-linkedin"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2025 E_wings Pvt(Ltd). All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Slideshow functionality
        let slideIndex = 1;
        let slideInterval;

        function showSlide(n) {
            const slides = document.querySelectorAll('.slide');
            const dots = document.querySelectorAll('.nav-dot');
            
            if (n > slides.length) slideIndex = 1;
            if (n < 1) slideIndex = slides.length;
            
            slides.forEach(slide => slide.classList.remove('active'));
            dots.forEach(dot => dot.classList.remove('active'));
            
            slides[slideIndex - 1].classList.add('active');
            dots[slideIndex - 1].classList.add('active');
        }

        function currentSlide(n) {
            clearInterval(slideInterval);
            slideIndex = n;
            showSlide(slideIndex);
            startSlideshow();
        }

        function nextSlide() {
            slideIndex++;
            showSlide(slideIndex);
        }

        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 5000);
        }

        // Initialize slideshow
        document.addEventListener('DOMContentLoaded', function() {
            startSlideshow();
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    <?php
    // Handle contact form submission
    if (isset($_POST['submit'])) {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $phone = htmlspecialchars($_POST['phone']);
        $message = htmlspecialchars($_POST['message']);
        
        // Here you can add code to save to database or send email
        // For now, we'll just show a success message
        echo "<script>alert('Thank you for your message! We will get back to you soon.');</script>";
    }
    ?>
</body>
</html>