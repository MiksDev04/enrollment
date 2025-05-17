<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestige University - Excellence in Education</title>
    <!-- Bootstrap CSS -->
    <link href="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <style>
        :root {
            --primary-blue: #0056b3;
            --secondary-blue: #003d82;
            --accent-blue: #007bff;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-blue) !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: #333 !important;
        }
        
        .nav-link:hover {
            color: var(--primary-blue) !important;
        }
        
        .hero-section {
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), 
                        url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            margin-bottom: 50px;
        }
        
        .btn-primary {
            background-color: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .btn-outline-primary {
            border-color: var(--primary-blue);
            color: var(--primary-blue);
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-blue);
            border-color: var(--secondary-blue);
        }

        .btn-outline-primary:hover {
            border-color: var(--secondary-blue);
            color: var(--secondary-blue);
        }

        .btn-white {
            border-color: white;
            color: white;
        }
        
        .btn-white:hover {
            background-color: white;
            color: black;
        }
        
        .feature-icon {
            width: 60px;
            height: 60px;
            margin-bottom: 20px;
            color: var(--primary-blue);
        }
        
        .card {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-10px);
        }
        
        .news-section {
            background-color: #f8f9fa;
            padding: 60px 0;
        }
        
        .cta-section {
            background-color: var(--primary-blue);
            color: white;
            padding: 80px 0;
            margin: 60px 0;
        }
        
        footer {
            background-color: #343a40;
            color: white;
            padding: 40px 0;
        }
        
        .social-icon {
            color: white;
            font-size: 24px;
            margin-right: 15px;
        }
        
        .social-icon:hover {
            color: #adb5bd;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <span class="fw-bold">Prestige University</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Programs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Admissions</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Research</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Contact</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-primary" href="#enroll-now">Enroll Now</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-primary" href="login.php">Login</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section text-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Shape Your Future With Excellence</h1>
            <p class="lead mb-5">Join a community of innovative thinkers and leaders at Prestige University</p>
            <div class="d-flex flex-wrap gap-2 justify-content-center">
                <a href="#enroll-now" class="btn btn-primary btn-lg px-5 py-3">Start Your Application</a>
                <a href="login.php" class="btn btn-white btn-lg px-5 py-3">Open Your Account</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mb-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <h3>120+ Programs</h3>
                <p>Choose from our wide range of undergraduate, graduate, and professional programs.</p>
            </div>
            <div class="col-md-4 mb-4">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                </svg>
                <h3>World-Class Faculty</h3>
                <p>Learn from distinguished professors and industry leaders.</p>
            </div>
            <div class="col-md-4 mb-4">
                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                </svg>
                <h3>Global Network</h3>
                <p>Join our alumni network of 50,000+ professionals worldwide.</p>
            </div>
        </div>
    </section>

    <!-- Programs Section -->
    <section class="container mb-5">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Featured Programs</h2>
            <p class="text-muted">Explore our most popular academic offerings</p>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1581094794329-c8112a89af12?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Engineering">
                    <div class="card-body">
                        <h5 class="card-title">Engineering</h5>
                        <p class="card-text">Cutting-edge programs in mechanical, electrical, and computer engineering.</p>
                        <a href="#" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Business">
                    <div class="card-body">
                        <h5 class="card-title">Business Administration</h5>
                        <p class="card-text">Top-ranked MBA and undergraduate business programs.</p>
                        <a href="#" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <img src="https://images.unsplash.com/photo-1575505586569-646b2ca898fc?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1466&q=80" class="card-img-top" alt="Health Sciences">
                    <div class="card-body">
                        <h5 class="card-title">Health Sciences</h5>
                        <p class="card-text">Leading programs in medicine, nursing, and public health.</p>
                        <a href="#" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="container mb-5 py-5 bg-light rounded-3">
        <div class="row text-center">
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">95%</h2>
                <p>Graduation Rate</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">#25</h2>
                <p>National Ranking</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">10:1</h2>
                <p>Student-Faculty Ratio</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold text-primary">$120M</h2>
                <p>Research Funding</p>
            </div>
        </div>
    </section>

    <!-- News Section -->
    <section class="news-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Campus News</h2>
                <p class="text-muted">Stay updated with the latest happenings</p>
            </div>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Research Grant">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Research</span>
                            <h5 class="card-title">University Receives $5M Research Grant</h5>
                            <p class="card-text">Funding will support innovative projects in renewable energy.</p>
                            <a href="#" class="btn btn-link ps-0">Read More →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1471&q=80" class="card-img-top" alt="Student Achievement">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Achievement</span>
                            <h5 class="card-title">Student Team Wins National Competition</h5>
                            <p class="card-text">Engineering students take first place in robotics challenge.</p>
                            <a href="#" class="btn btn-link ps-0">Read More →</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" class="card-img-top" alt="Campus Expansion">
                        <div class="card-body">
                            <span class="badge bg-primary mb-2">Campus</span>
                            <h5 class="card-title">New Science Building Groundbreaking</h5>
                            <p class="card-text">State-of-the-art facility to open next academic year.</p>
                            <a href="#" class="btn btn-link ps-0">Read More →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section" id="enroll-now">
        <div class="container text-center">
            <h2 class="display-5 fw-bold mb-4">Ready to Join Our Community?</h2>
            <p class="lead mb-5">Applications for the next academic year are now open. Don't miss your chance to be part of Prestige University.</p>
            <a href="student/enrollment_form.php" class="btn btn-light btn-lg px-5 py-3">Enroll Now</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <h5>Prestige University</h5>
                    <p>123 Education Avenue<br>University City, UC 12345<br>Phone: (123) 456-7890</p>
                    <div class="mt-3">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-2 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Home</a></li>
                        <li><a href="#" class="text-white">About</a></li>
                        <li><a href="#" class="text-white">Programs</a></li>
                        <li><a href="#" class="text-white">Admissions</a></li>
                        <li><a href="#" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Resources</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Library</a></li>
                        <li><a href="#" class="text-white">Career Services</a></li>
                        <li><a href="#" class="text-white">Student Portal</a></li>
                        <li><a href="#" class="text-white">Alumni</a></li>
                        <li><a href="#" class="text-white">Events Calendar</a></li>
                    </ul>
                </div>
                <div class="col-md-3 mb-4">
                    <h5>Newsletter</h5>
                    <p>Subscribe to our newsletter for the latest updates.</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your Email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center pt-3">
                <p class="mb-0">&copy; 2023 Prestige University. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="bootstrap-5.3.3-dist/bootstrap-5.3.3-dist/js/bootstrap.bundle.js"></script>
</body>
</html>