<?php
// Start session for admin panel (will be used later)
session_start();

// Database Configuration (Replace with your actual credentials)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'doitnp_db');

// Create connection
$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if (!$conn) {
    // If database connection fails, use static data (for demo)
    $useStaticData = true;
} else {
    $useStaticData = false;
    mysqli_set_charset($conn, "utf8");
}

// Function to fetch data from database or use static data
function getServices($conn) {
    if (!$conn) {
        // Static services data
        return [
            ['id' => 1, 'title' => 'Web Development', 'description' => 'Custom websites and web applications built with latest technologies.', 'icon' => 'fas fa-code', 'is_active' => 1],
            ['id' => 2, 'title' => 'Mobile App Development', 'description' => 'Native and cross-platform mobile applications for iOS and Android.', 'icon' => 'fas fa-mobile-alt', 'is_active' => 1],
            ['id' => 3, 'title' => 'UI/UX Design', 'description' => 'User-centered design that creates exceptional digital experiences.', 'icon' => 'fas fa-paint-brush', 'is_active' => 1],
            ['id' => 4, 'title' => 'E-commerce Solutions', 'description' => 'Complete online store setup with secure payment integration.', 'icon' => 'fas fa-shopping-cart', 'is_active' => 1],
            ['id' => 5, 'title' => 'Cloud Solutions', 'description' => 'Scalable cloud infrastructure and migration services.', 'icon' => 'fas fa-cloud', 'is_active' => 1],
            ['id' => 6, 'title' => 'Digital Marketing', 'description' => 'Data-driven marketing strategies to grow your online presence.', 'icon' => 'fas fa-chart-line', 'is_active' => 1],
            ['id' => 7, 'title' => 'AI & ML Solutions', 'description' => 'Intelligent systems and machine learning algorithms.', 'icon' => 'fas fa-robot', 'is_active' => 1],
            ['id' => 8, 'title' => 'Cybersecurity', 'description' => 'Protect your digital assets with advanced security solutions.', 'icon' => 'fas fa-shield-alt', 'is_active' => 1]
        ];
    }
    
    $sql = "SELECT * FROM services WHERE is_active = 1 ORDER BY display_order ASC";
    $result = mysqli_query($conn, $sql);
    $services = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $services[] = $row;
        }
    } else {
        // Return static data if no data in database
        return getServices(false);
    }
    
    return $services;
}

function getPortfolio($conn) {
    if (!$conn) {
        // Static portfolio data
        return [
            ['id' => 1, 'title' => 'E-commerce Platform', 'category' => 'ecommerce', 'client' => 'Fashion Store', 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&auto=format&fit=crop&q=60', 'technologies' => 'PHP, MySQL, JavaScript, React'],
            ['id' => 2, 'title' => 'Mobile Banking App', 'category' => 'mobile', 'client' => 'Finance Bank', 'image' => 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w-800&auto=format&fit=crop&q=60', 'technologies' => 'React Native, Node.js, MongoDB'],
            ['id' => 3, 'title' => 'Corporate Portal', 'category' => 'web', 'client' => 'Tech Corporation', 'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=60', 'technologies' => 'Laravel, Vue.js, MySQL'],
            ['id' => 4, 'title' => 'Food Delivery App', 'category' => 'mobile', 'client' => 'QuickEats', 'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&auto=format&fit=crop&q=60', 'technologies' => 'Flutter, Firebase, Node.js'],
            ['id' => 5, 'title' => 'Learning Management System', 'category' => 'web', 'client' => 'EduTech Inc.', 'image' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60', 'technologies' => 'Python, Django, PostgreSQL'],
            ['id' => 6, 'title' => 'Healthcare Platform', 'category' => 'web', 'client' => 'MediCare', 'image' => 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&auto=format&fit=crop&q=60', 'technologies' => 'React, Node.js, AWS']
        ];
    }
    
    $sql = "SELECT * FROM portfolio WHERE is_featured = 1 ORDER BY created_at DESC LIMIT 6";
    $result = mysqli_query($conn, $sql);
    $portfolio = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $portfolio[] = $row;
        }
    } else {
        return getPortfolio(false);
    }
    
    return $portfolio;
}

function getTechnologies($conn) {
    if (!$conn) {
        // Static technologies data
        return [
            ['name' => 'PHP', 'icon' => 'fab fa-php', 'color' => '#777BB4', 'category' => 'backend'],
            ['name' => 'Laravel', 'icon' => 'fab fa-laravel', 'color' => '#FF2D20', 'category' => 'backend'],
            ['name' => 'JavaScript', 'icon' => 'fab fa-js', 'color' => '#F7DF1E', 'category' => 'frontend'],
            ['name' => 'React', 'icon' => 'fab fa-react', 'color' => '#61DAFB', 'category' => 'frontend'],
            ['name' => 'Vue.js', 'icon' => 'fab fa-vuejs', 'color' => '#4FC08D', 'category' => 'frontend'],
            ['name' => 'Node.js', 'icon' => 'fab fa-node-js', 'color' => '#339933', 'category' => 'backend'],
            ['name' => 'Python', 'icon' => 'fab fa-python', 'color' => '#3776AB', 'category' => 'backend'],
            ['name' => 'Java', 'icon' => 'fab fa-java', 'color' => '#007396', 'category' => 'backend'],
            ['name' => 'AWS', 'icon' => 'fab fa-aws', 'color' => '#FF9900', 'category' => 'cloud'],
            ['name' => 'Docker', 'icon' => 'fab fa-docker', 'color' => '#2496ED', 'category' => 'devops'],
            ['name' => 'MySQL', 'icon' => 'fas fa-database', 'color' => '#4479A1', 'category' => 'database'],
            ['name' => 'MongoDB', 'icon' => 'fas fa-server', 'color' => '#47A248', 'category' => 'database'],
            ['name' => 'React Native', 'icon' => 'fab fa-react', 'color' => '#61DAFB', 'category' => 'mobile'],
            ['name' => 'Flutter', 'icon' => 'fas fa-mobile', 'color' => '#02569B', 'category' => 'mobile'],
            ['name' => 'Git', 'icon' => 'fab fa-git-alt', 'color' => '#F05032', 'category' => 'tools'],
            ['name' => 'WordPress', 'icon' => 'fab fa-wordpress', 'color' => '#21759B', 'category' => 'cms']
        ];
    }
    
    $sql = "SELECT * FROM technologies WHERE is_active = 1 ORDER BY category, display_order";
    $result = mysqli_query($conn, $sql);
    $technologies = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $technologies[] = $row;
        }
    } else {
        return getTechnologies(false);
    }
    
    return $technologies;
}

function getClients($conn) {
    if (!$conn) {
        // Static clients data
        return [
            ['name' => 'Microsoft', 'logo' => 'microsoft'],
            ['name' => 'Google', 'logo' => 'google'],
            ['name' => 'Amazon', 'logo' => 'amazon'],
            ['name' => 'Apple', 'logo' => 'apple'],
            ['name' => 'Facebook', 'logo' => 'facebook'],
            ['name' => 'Netflix', 'logo' => 'netflix'],
            ['name' => 'Uber', 'logo' => 'uber'],
            ['name' => 'Airbnb', 'logo' => 'airbnb']
        ];
    }
    
    $sql = "SELECT * FROM clients WHERE is_active = 1 ORDER BY name";
    $result = mysqli_query($conn, $sql);
    $clients = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $clients[] = $row;
        }
    } else {
        return getClients(false);
    }
    
    return $clients;
}

function getHeroSlides($conn) {
    if (!$conn) {
        return [
            ['id' => 1, 'title' => 'Digital Transformation Experts', 'subtitle' => 'We deliver cutting-edge IT solutions that transform businesses', 'type' => 'video', 'media' => 'hero-bg-1.mp4', 'button_text' => 'Get Started', 'button_link' => '#contact'],
            ['id' => 2, 'title' => 'Innovate. Implement. Excel.', 'subtitle' => 'Your vision, our expertise - creating digital solutions that exceed expectations', 'type' => 'video', 'media' => 'hero-bg-2.mp4', 'button_text' => 'View Portfolio', 'button_link' => '#portfolio'],
            ['id' => 3, 'title' => 'Future Ready Solutions', 'subtitle' => 'Building tomorrow\'s technology today with AI, Cloud & IoT', 'type' => 'image', 'media' => 'hero-bg-3.jpg', 'button_text' => 'Our Services', 'button_link' => '#services']
        ];
    }
    
    $sql = "SELECT * FROM hero_slides WHERE is_active = 1 ORDER BY display_order";
    $result = mysqli_query($conn, $sql);
    $slides = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $slides[] = $row;
        }
    } else {
        return getHeroSlides(false);
    }
    
    return $slides;
}

function getGallery($conn) {
    if (!$conn) {
        // Static gallery data
        return [
            ['id' => 1, 'title' => 'Office Workspace', 'category' => 'office', 'description' => 'Our creative workspace environment', 'image' => 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=800&auto=format&fit=crop&q=60'],
            ['id' => 2, 'title' => 'Team Collaboration', 'category' => 'team', 'description' => 'Our team brainstorming session', 'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60'],
            ['id' => 3, 'title' => 'Project Launch', 'category' => 'event', 'description' => 'Successful project launch celebration', 'image' => 'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?w=800&auto=format&fit=crop&q=60'],
            ['id' => 4, 'title' => 'Development Setup', 'category' => 'work', 'description' => 'Advanced development workstation', 'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=60'],
            ['id' => 5, 'title' => 'Client Meeting', 'category' => 'meeting', 'description' => 'Strategic client discussion', 'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&auto=format&fit=crop&q=60'],
            ['id' => 6, 'title' => 'Tech Conference', 'category' => 'event', 'description' => 'Speaking at international tech conference', 'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60'],
            ['id' => 7, 'title' => 'Award Ceremony', 'category' => 'award', 'description' => 'Receiving industry recognition award', 'image' => 'https://images.unsplash.com/photo-1559131397-f94da358a3d9?w=800&auto=format&fit=crop&q=60'],
            ['id' => 8, 'title' => 'Training Session', 'category' => 'team', 'description' => 'Internal team training workshop', 'image' => 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=60'],
            ['id' => 9, 'title' => 'Product Demo', 'category' => 'work', 'description' => 'Demonstrating new product features', 'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&auto=format&fit=crop&q=60'],
            ['id' => 10, 'title' => 'Company Retreat', 'category' => 'team', 'description' => 'Annual company team building retreat', 'image' => 'https://images.unsplash.com/photo-1541745537411-b8046dc6d66c?w=800&auto=format&fit=crop&q=60'],
            ['id' => 11, 'title' => 'Office Infrastructure', 'category' => 'office', 'description' => 'State-of-the-art server room', 'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=60'],
            ['id' => 12, 'title' => 'Achievement Celebration', 'category' => 'award', 'description' => 'Celebrating project milestones', 'image' => 'https://images.unsplash.com/photo-1559131397-f94da358a3d9?w=800&auto=format&fit=crop&q=60']
        ];
    }
    
    $sql = "SELECT * FROM gallery WHERE is_active = 1 ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $gallery = [];
    
    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $gallery[] = $row;
        }
    } else {
        return getGallery(false);
    }
    
    return $gallery;
}

// Get data
$services = getServices($conn);
$portfolio = getPortfolio($conn);
$technologies = getTechnologies($conn);
$clients = getClients($conn);
$heroSlides = getHeroSlides($conn);
$gallery = getGallery($conn);

// Company info
$companyName = "mantratech";
$companySlogan = "We deliver what you need";
$companyEmail = "info@doit.np";
$companyPhone = "+977 9800000000";
$companyAddress = "Kathmandu, Nepal";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($companyName); ?> | Premium IT Solutions</title>
    <meta name="description" content="doit.np delivers premium IT solutions - web development, mobile apps, AI solutions, and digital transformation services.">
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    
    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    <style>
        :root {
            --primary-black: #000000;
            --secondary-black: #0A0A0A;
            --dark-gray: #1A1A1A;
            --primary-white: #FFFFFF;
            --light-gray: #F5F5F5;
            --accent-gold: #D4AF37;
            --accent-silver: #C0C0C0;
            --gradient-dark: linear-gradient(135deg, #000000 0%, #1A1A1A 100%);
            --gradient-gold: linear-gradient(45deg, #D4AF37, #FFD700);
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--primary-black);
            color: var(--primary-white);
            overflow-x: hidden;
        }
        
        h1, h2, h3, h4, h5 {
            font-family: 'Playfair Display', serif;
            font-weight: 600;
        }
        
        /* Premium Header */
        .premium-header {
            background: rgba(10, 10, 10, 0.95);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            padding: 15px 0;
            border-bottom: 1px solid rgba(212, 175, 55, 0.2);
            transition: all 0.3s ease;
        }
        
        .header-scrolled {
            padding: 10px 0;
            background: rgba(0, 0, 0, 0.98);
        }
        
        /* Dynamic Logo Container */
        .logo-container {
            position: relative;
            width: 200px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .logo-video-wrapper {
            width: 100%;
            height: 100%;
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }
        
        .logo-video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: brightness(1.2) contrast(1.1);
        }
        
        .logo-text-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.6);
    font-family: 'Playfair Display', serif;
    font-size: 28px;
    font-weight: 700;
    color: var(--accent-gold);
    letter-spacing: 1px;
    text-transform: none; /* Changed from uppercase to none */
}

.logo-text-overlay span.do {
    color: var(--accent-gold);
    font-weight: 700;
}

.logo-text-overlay span.it {
    color: var(--accent-gold);
    font-weight: 800;
    text-transform: uppercase; /* Only IT in uppercase */
}

.logo-text-overlay span.np {
    color: var(--accent-silver);
    font-weight: 300;
    font-size: 0.9em;
}

        
        
        /* Navigation */
        .nav-link {
            color: var(--accent-silver) !important;
            font-weight: 500;
            margin: 0 8px;
            padding: 8px 16px !important;
            position: relative;
            transition: all 0.3s ease;
        }
        
        .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 0;
            height: 2px;
            background: var(--gradient-gold);
            transition: width 0.3s ease;
        }
        
        .nav-link:hover {
            color: var(--primary-white) !important;
        }
        
        .nav-link:hover::before {
            width: 70%;
        }
        
        .nav-link.active {
            color: var(--accent-gold) !important;
        }
        
        .nav-link.active::before {
            width: 70%;
        }
        
        /* Hero Section */
        .hero-section {
            height: 100vh;
            position: relative;
            margin-top: 90px;
        }
        
        .hero-swiper {
            width: 100%;
            height: 100%;
        }
        
        .hero-slide {
            position: relative;
            height: 100%;
        }
        
        .slide-media {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.4;
        }
        
        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 90%;
            max-width: 1200px;
            z-index: 2;
        }
        
        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            margin-bottom: 20px;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            animation: fadeInDown 1s ease;
        }
        
        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--light-gray);
            margin-bottom: 40px;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
            animation: fadeInUp 1s ease 0.3s both;
        }
        
        .slogan-container {
            margin: 30px 0;
            animation: fadeIn 1s ease 0.6s both;
        }
        
        .slogan {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--accent-gold);
            font-style: italic;
            text-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
            position: relative;
            display: inline-block;
            padding: 0 20px;
        }
        
        .slogan::before,
        .slogan::after {
            content: "✦";
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-gold);
            font-size: 1.2rem;
        }
        
        .slogan::before {
            left: 0;
        }
        
        .slogan::after {
            right: 0;
        }
        
        .btn-premium {
            background: var(--gradient-gold);
            color: var(--primary-black);
            border: none;
            padding: 15px 40px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        
        .btn-premium::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.7s ease;
            z-index: -1;
        }
        
        .btn-premium:hover::before {
            left: 100%;
        }
        
        .btn-premium:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(212, 175, 55, 0.3);
        }
        
        /* Sections Common Styles */
        .section-padding {
            padding: 100px 0;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 70px;
        }
        
        .section-title h2 {
            font-size: 3.2rem;
            color: var(--primary-white);
            margin-bottom: 15px;
            position: relative;
            display: inline-block;
        }
        
        .section-title h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: var(--gradient-gold);
            border-radius: 2px;
        }
        
        .section-subtitle {
            color: var(--accent-silver);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 20px auto 0;
        }
        
        /* About Section */
        .about-section {
            background: var(--secondary-black);
            position: relative;
            overflow: hidden;
        }
        
        .about-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 200%;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
        }
        
        .about-content {
            padding-right: 30px;
        }
        
        .about-text {
            font-size: 1.1rem;
            line-height: 1.8;
            color: var(--light-gray);
            margin-bottom: 25px;
        }
        
        .read-more-btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
            padding: 10px 25px;
            border: 2px solid var(--accent-gold);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .read-more-btn:hover {
            background: var(--accent-gold);
            color: var(--primary-black);
            transform: translateX(10px);
        }
        
        .stats-container {
            display: flex;
            gap: 30px;
            margin-top: 40px;
        }
        
        .stat-item {
            text-align: center;
        }
        
        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 5px;
        }
        
        .stat-label {
            color: var(--accent-silver);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        /* Services Section */
        .services-section {
            background: var(--primary-black);
        }
        
        .service-card {
            background: var(--dark-gray);
            border-radius: 15px;
            padding: 40px 30px;
            height: 100%;
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }
        
        .service-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 0;
            background: var(--gradient-gold);
            transition: height 0.4s ease;
        }
        
        .service-card:hover::before {
            height: 100%;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            border-color: var(--accent-gold);
            box-shadow: 0 20px 40px rgba(212, 175, 55, 0.1);
        }
        
        .service-icon {
            font-size: 3.5rem;
            margin-bottom: 25px;
            display: inline-block;
            background: var(--gradient-gold);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        
        .service-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--primary-white);
        }
        
        .service-description {
            color: var(--accent-silver);
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .service-link {
            color: var(--accent-gold);
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }
        
        .service-link:hover {
            gap: 12px;
            color: var(--primary-white);
        }
        
        /* Clients Section */
        .clients-section {
            background: var(--gradient-dark);
            padding: 80px 0;
        }
        
        .clients-title {
            text-align: center;
            margin-bottom: 50px;
        }
        
        .clients-title h3 {
            font-size: 2.5rem;
            color: var(--primary-white);
            margin-bottom: 15px;
        }
        
        .clients-subtitle {
            color: var(--accent-silver);
            font-size: 1.1rem;
        }
        
        .client-logo-wrapper {
            padding: 30px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            height: 120px;
            transition: all 0.3s ease;
        }
        
        .client-logo-wrapper:hover {
            transform: translateY(-5px);
            border-color: var(--accent-gold);
            background: rgba(212, 175, 55, 0.05);
        }
        
        .client-logo {
            max-width: 150px;
            max-height: 50px;
            filter: grayscale(100%) brightness(2);
            transition: all 0.3s ease;
        }
        
        .client-logo-wrapper:hover .client-logo {
            filter: grayscale(0%) brightness(1);
        }
        
        /* Tech Stack Section */
        .tech-section {
            background: var(--secondary-black);
        }
        
        .tech-filter {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 50px;
            flex-wrap: wrap;
        }
        
        .tech-filter-btn {
            background: transparent;
            border: 1px solid var(--accent-gold);
            color: var(--accent-gold);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .tech-filter-btn:hover,
        .tech-filter-btn.active {
            background: var(--accent-gold);
            color: var(--primary-black);
        }
        
        .tech-item {
            background: var(--dark-gray);
            border-radius: 12px;
            padding: 30px 20px;
            text-align: center;
            border: 1px solid rgba(212, 175, 55, 0.1);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .tech-item::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gradient-gold);
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .tech-item:hover::after {
            transform: scaleX(1);
        }
        
        .tech-item:hover {
            transform: translateY(-8px);
            border-color: var(--accent-gold);
        }
        
        .tech-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }
        
        .tech-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary-white);
        }
        
        /* Portfolio Section */
        .portfolio-section {
            background: var(--primary-black);
        }
        
        .portfolio-filter {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }
        
        .portfolio-filter-btn {
            background: transparent;
            border: 1px solid var(--accent-gold);
            color: var(--accent-gold);
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .portfolio-filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-gold);
            transition: left 0.3s ease;
            z-index: -1;
        }
        
        .portfolio-filter-btn:hover::before,
        .portfolio-filter-btn.active::before {
            left: 0;
        }
        
        .portfolio-filter-btn:hover,
        .portfolio-filter-btn.active {
            color: var(--primary-black);
            border-color: var(--accent-gold);
        }
        
        .portfolio-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            height: 350px;
        }
        
        .portfolio-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .portfolio-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 30px;
        }
        
        .portfolio-item:hover .portfolio-overlay {
            opacity: 1;
        }
        
        .portfolio-item:hover .portfolio-image {
            transform: scale(1.1);
        }
        
        .portfolio-content {
            text-align: center;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        
        .portfolio-item:hover .portfolio-content {
            transform: translateY(0);
        }
        
        .portfolio-category {
            color: var(--accent-gold);
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }
        
        .portfolio-title {
            font-size: 1.4rem;
            margin-bottom: 15px;
            color: var(--primary-white);
        }
        
        /* Gallery Section */
        .gallery-section {
            background: var(--secondary-black);
        }
        
        .gallery-filter {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }
        
        .gallery-filter-btn {
            background: transparent;
            border: 1px solid var(--accent-gold);
            color: var(--accent-gold);
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .gallery-filter-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: var(--gradient-gold);
            transition: left 0.3s ease;
            z-index: -1;
        }
        
        .gallery-filter-btn:hover::before,
        .gallery-filter-btn.active::before {
            left: 0;
        }
        
        .gallery-filter-btn:hover,
        .gallery-filter-btn.active {
            color: var(--primary-black);
            border-color: var(--accent-gold);
        }
        
        .gallery-item {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 30px;
            height: 300px;
        }
        
        .gallery-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        
        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.85);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 20px;
        }
        
        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
        
        .gallery-item:hover .gallery-image {
            transform: scale(1.1);
        }
        
        .gallery-content {
            text-align: center;
            transform: translateY(20px);
            transition: transform 0.3s ease;
        }
        
        .gallery-item:hover .gallery-content {
            transform: translateY(0);
        }
        
        .gallery-category {
            color: var(--accent-gold);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 8px;
        }
        
        .gallery-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
            color: var(--primary-white);
        }
        
        .gallery-description {
            color: var(--accent-silver);
            font-size: 0.9rem;
            line-height: 1.4;
            margin-bottom: 15px;
        }
        
        /* Contact Section */
        .contact-section {
            background: var(--gradient-dark);
            position: relative;
            overflow: hidden;
        }
        
        .contact-section::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        }
        
        .contact-section::after {
            content: '';
            position: absolute;
            bottom: -100px;
            right: -100px;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, transparent 70%);
        }
        
        .contact-card {
            background: rgba(26, 26, 26, 0.8);
            backdrop-filter: blur(10px);
            border-radius: 20px;
            padding: 60px;
            border: 1px solid rgba(212, 175, 55, 0.2);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
        }
        
        .contact-info {
            margin-top: 40px;
        }
        
        .contact-info-item {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            font-size: 1.2rem;
        }
        
        .contact-details h5 {
            color: var(--primary-white);
            margin-bottom: 5px;
        }
        
        .contact-details p {
            color: var(--accent-silver);
            margin: 0;
        }
        
        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(212, 175, 55, 0.3);
            color: var(--primary-white);
            padding: 15px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--accent-gold);
            color: var(--primary-white);
            box-shadow: 0 0 20px rgba(212, 175, 55, 0.2);
        }
        
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.4);
        }
        
        textarea.form-control {
            min-height: 150px;
            resize: none;
        }
        
        /* Footer */
        .premium-footer {
            background: var(--primary-black);
            padding: 80px 0 30px;
            border-top: 1px solid rgba(212, 175, 55, 0.2);
        }
        
        .footer-logo {
            font-family: 'Playfair Display', serif;
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--accent-gold);
            text-decoration: none;
            margin-bottom: 25px;
            display: inline-block;
        }
        
        .footer-tagline {
            color: var(--accent-silver);
            margin-bottom: 25px;
            font-size: 1.1rem;
        }
        
        .social-links {
            display: flex;
            gap: 15px;
        }
        
        .social-link {
            width: 45px;
            height: 45px;
            background: rgba(212, 175, 55, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-gold);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .social-link:hover {
            background: var(--accent-gold);
            color: var(--primary-black);
            transform: translateY(-5px);
        }
        
        .footer-heading {
            color: var(--accent-gold);
            font-size: 1.2rem;
            margin-bottom: 25px;
            font-weight: 600;
        }
        
        .footer-links {
            list-style: none;
            padding: 0;
        }
        
        .footer-links li {
            margin-bottom: 12px;
        }
        
        .footer-links a {
            color: var(--accent-silver);
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        
        .footer-links a:hover {
            color: var(--accent-gold);
            transform: translateX(5px);
        }
        
        .footer-links a::before {
            content: '›';
            color: var(--accent-gold);
            font-weight: bold;
        }
        
        .copyright {
            text-align: center;
            padding-top: 30px;
            margin-top: 50px;
            border-top: 1px solid rgba(212, 175, 55, 0.1);
            color: var(--accent-silver);
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        
        /* Responsive Design */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 3.5rem;
            }
            
            .section-title h2 {
                font-size: 2.8rem;
            }
            
            .contact-card {
                padding: 40px;
            }
            
            .about-content {
                padding-right: 0;
                margin-bottom: 40px;
            }
            
            .gallery-item {
                height: 250px;
            }
        }
        
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .section-title h2 {
                font-size: 2.3rem;
            }
            
            .slogan {
                font-size: 1.5rem;
            }
            
            .logo-container {
                width: 160px;
                height: 50px;
            }
            
            .nav-link {
                margin: 5px 0;
                text-align: center;
                width: 100%;
            }
            
            .stats-container {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .portfolio-item {
                height: 300px;
            }
            
            .gallery-item {
                height: 200px;
            }
        }
        
        @media (max-width: 576px) {
            .hero-title {
                font-size: 2.2rem;
            }
            
            .hero-subtitle {
                font-size: 1.1rem;
            }
            
            .section-padding {
                padding: 70px 0;
            }
            
            .btn-premium {
                padding: 12px 30px;
                font-size: 0.9rem;
            }
            
            .contact-card {
                padding: 30px 20px;
            }
            
            .gallery-item {
                height: 180px;
            }
        }
        
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
        }
        
        ::-webkit-scrollbar-track {
            background: var(--secondary-black);
        }
        
        ::-webkit-scrollbar-thumb {
            background: var(--gradient-gold);
            border-radius: 5px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(45deg, #B8860B, #FFD700);
        }
        
        /* Animation on Scroll */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }
        
        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <!-- Premium Header with Dynamic Logo -->
    <nav class="navbar navbar-expand-lg navbar-dark premium-header" id="mainHeader">
        <div class="container">
            <!-- Dynamic Logo Video -->
            <a class="navbar-brand" href="#">
                <div class="logo-container">
                    <div class="logo-video-wrapper">
                        <!-- Video Logo -->
                        <video autoplay muted loop playsinline class="logo-video">
                            <source src="assets/videos/logo-animation.mp4" type="video/mp4">
                            <!-- Fallback to animated GIF -->
                            <source src="assets/videos/logo-animation.gif" type="image/gif">
                            <!-- Final fallback to text -->
                            Your browser does not support the video tag.
                        </video>
                        <div class="logo-text-overlay">
                            <span class="Mantratech">do</span><span class="np">IT.np</span>
                        </div>
                        
                    </div>
                </div>
            </a>
            
            <!-- Mobile Toggle Button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#services">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#clients">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#tech">Tech Stack</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#portfolio">Portfolio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item ms-2">
                        <a href="#contact" class="btn btn-premium">Get Quote</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Video/Banner Slider -->
    <section id="home" class="hero-section">
        <div class="swiper hero-swiper">
            <div class="swiper-wrapper">
                <?php foreach($heroSlides as $index => $slide): ?>
                <div class="swiper-slide hero-slide">
                    <?php if($slide['type'] == 'video'): ?>
                    <video autoplay muted loop playsinline class="slide-media">
                        <source src="assets/videos/<?php echo htmlspecialchars($slide['media']); ?>" type="video/mp4">
                    </video>
                    <?php else: ?>
                    <img src="assets/images/<?php echo htmlspecialchars($slide['media']); ?>" alt="<?php echo htmlspecialchars($slide['title']); ?>" class="slide-media">
                    <?php endif; ?>
                    
                    <div class="hero-content">
                        <h1 class="hero-title"><?php echo htmlspecialchars($slide['title']); ?></h1>
                        <p class="hero-subtitle"><?php echo htmlspecialchars($slide['subtitle']); ?></p>
                        
                        <div class="slogan-container">
                            <div class="slogan"><?php echo htmlspecialchars($companySlogan); ?></div>
                        </div>
                        
                        <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="btn btn-premium">
                            <?php echo htmlspecialchars($slide['button_text']); ?>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <!-- Navigation Buttons -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section-padding about-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="section-title text-start">
                        <h2>About Us</h2>
                        <p class="section-subtitle text-start">Pioneering digital excellence since 2015</p>
                    </div>
                    
                    <div class="about-content">
                        <p class="about-text">
                            At <strong>doit.np</strong>, we transcend conventional IT services to become your strategic innovation partner. 
                            Our philosophy is built on delivering not just solutions, but transformative digital experiences that propel 
                            businesses into the future.
                        </p>
                        <p class="about-text">
                            We combine cutting-edge technology with deep industry insights to architect solutions that are not only 
                            technologically superior but also drive measurable business impact. Our commitment is to excellence, 
                            innovation, and lasting partnerships.
                        </p>
                        
                        <div class="stats-container">
                            <div class="stat-item">
                                <div class="stat-number">150+</div>
                                <div class="stat-label">Projects</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50+</div>
                                <div class="stat-label">Clients</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">98%</div>
                                <div class="stat-label">Satisfaction</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">8+</div>
                                <div class="stat-label">Years</div>
                            </div>
                        </div>
                        
                        <a href="about.php" class="read-more-btn mt-4">
                            Learn More <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-6">
                    <div class="row g-3">
                        <?php 
                        $aboutImages = [
                            'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&auto=format&fit=crop&q=60',
                            'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800&auto=format&fit=crop&q=60',
                            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60',
                            'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?w=800&auto=format&fit=crop&q=60'
                        ];
                        
                        foreach($aboutImages as $index => $image): 
                        ?>
                        <div class="col-6 animate-on-scroll" style="transition-delay: <?php echo ($index * 0.1); ?>s;">
                            <div class="portfolio-item">
                                <img src="<?php echo $image; ?>" alt="About doit.np" class="portfolio-image">
                                <div class="portfolio-overlay">
                                    <div class="portfolio-content">
                                        <div class="portfolio-category">Our Culture</div>
                                        <h4 class="portfolio-title">Team <?php echo $index + 1; ?></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section-padding services-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Services</h2>
                <p class="section-subtitle">Comprehensive IT solutions engineered for your success</p>
            </div>
            
            <div class="row g-4">
                <?php foreach($services as $index => $service): ?>
                <div class="col-lg-3 col-md-6 animate-on-scroll" style="transition-delay: <?php echo ($index * 0.1); ?>s;">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="<?php echo htmlspecialchars($service['icon']); ?>"></i>
                        </div>
                        <h4 class="service-title"><?php echo htmlspecialchars($service['title']); ?></h4>
                        <p class="service-description"><?php echo htmlspecialchars($service['description']); ?></p>
                        <a href="#" class="service-link">
                            Explore <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Trusted by Leading Companies -->
    <section id="clients" class="clients-section">
        <div class="container">
            <div class="clients-title animate-on-scroll">
                <h3>Trusted by Industry Leaders</h3>
                <p class="clients-subtitle">We partner with visionary companies to drive digital transformation</p>
            </div>
            
            <div class="row g-4">
                <?php foreach($clients as $index => $client): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 animate-on-scroll" style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                    <div class="client-logo-wrapper">
                        <?php if(isset($client['logo']) && $client['logo']): ?>
                        <img src="assets/images/clients/<?php echo htmlspecialchars($client['logo']); ?>.png" 
                             alt="<?php echo htmlspecialchars($client['name']); ?>" 
                             class="client-logo"
                             onerror="this.src='https://via.placeholder.com/150x60/222222/ffffff?text=<?php echo urlencode($client['name']); ?>'">
                        <?php else: ?>
                        <div class="client-name"><?php echo htmlspecialchars($client['name']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Tech Stack Section -->
    <section id="tech" class="section-padding tech-section">
        <div class="container">
            <div class="section-title">
                <h2>Technology Stack</h2>
                <p class="section-subtitle">Powering innovation with cutting-edge technologies</p>
            </div>
            
            <div class="tech-filter">
                <button class="tech-filter-btn active" data-filter="all">All</button>
                <button class="tech-filter-btn" data-filter="frontend">Frontend</button>
                <button class="tech-filter-btn" data-filter="backend">Backend</button>
                <button class="tech-filter-btn" data-filter="mobile">Mobile</button>
                <button class="tech-filter-btn" data-filter="database">Database</button>
                <button class="tech-filter-btn" data-filter="cloud">Cloud</button>
            </div>
            
            <div class="row g-4 tech-grid">
                <?php foreach($technologies as $index => $tech): ?>
                <div class="col-lg-2 col-md-3 col-sm-4 col-6 tech-item animate-on-scroll" 
                     data-category="<?php echo htmlspecialchars($tech['category']); ?>"
                     style="transition-delay: <?php echo ($index * 0.05); ?>s;
                            <?php if(isset($tech['color'])) echo 'border-color: ' . $tech['color'] . '40;'; ?>">
                    <div class="tech-icon" style="<?php if(isset($tech['color'])) echo 'color: ' . $tech['color'] . ';'; ?>">
                        <i class="<?php echo htmlspecialchars($tech['icon']); ?>"></i>
                    </div>
                    <h5 class="tech-name"><?php echo htmlspecialchars($tech['name']); ?></h5>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Portfolio Section -->
    <section id="portfolio" class="section-padding portfolio-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Portfolio</h2>
                <p class="section-subtitle">Showcasing excellence in digital craftsmanship</p>
            </div>
            
            <div class="portfolio-filter">
                <button class="portfolio-filter-btn active" data-filter="all">All Projects</button>
                <button class="portfolio-filter-btn" data-filter="web">Web Development</button>
                <button class="portfolio-filter-btn" data-filter="mobile">Mobile Apps</button>
                <button class="portfolio-filter-btn" data-filter="ecommerce">E-commerce</button>
                <button class="portfolio-filter-btn" data-filter="design">UI/UX Design</button>
            </div>
            
            <div class="row g-4 portfolio-grid">
                <?php foreach($portfolio as $index => $item): ?>
                <div class="col-lg-4 col-md-6 portfolio-item animate-on-scroll" 
                     data-category="<?php echo htmlspecialchars($item['category']); ?>"
                     style="transition-delay: <?php echo ($index * 0.1); ?>s;">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                         class="portfolio-image">
                    <div class="portfolio-overlay">
                        <div class="portfolio-content">
                            <div class="portfolio-category"><?php echo htmlspecialchars(ucfirst($item['category'])); ?></div>
                            <h4 class="portfolio-title"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p class="portfolio-client">Client: <?php echo htmlspecialchars($item['client']); ?></p>
                            <p class="portfolio-tech"><?php echo htmlspecialchars($item['technologies']); ?></p>
                            <a href="#" class="btn btn-premium btn-sm mt-2">View Details</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section-padding gallery-section">
        <div class="container">
            <div class="section-title">
                <h2>Our Gallery</h2>
                <p class="section-subtitle">Capturing moments that define our journey and culture</p>
            </div>
            
            <div class="gallery-filter">
                <button class="gallery-filter-btn active" data-filter="all">All Photos</button>
                <button class="gallery-filter-btn" data-filter="office">Office</button>
                <button class="gallery-filter-btn" data-filter="team">Team</button>
                <button class="gallery-filter-btn" data-filter="event">Events</button>
                <button class="gallery-filter-btn" data-filter="work">Work</button>
                <button class="gallery-filter-btn" data-filter="award">Awards</button>
                <button class="gallery-filter-btn" data-filter="meeting">Meetings</button>
            </div>
            
            <div class="row g-4 gallery-grid">
                <?php foreach($gallery as $index => $item): ?>
                <div class="col-lg-3 col-md-4 col-sm-6 gallery-item animate-on-scroll" 
                     data-category="<?php echo htmlspecialchars($item['category']); ?>"
                     style="transition-delay: <?php echo ($index * 0.05); ?>s;">
                    <img src="<?php echo htmlspecialchars($item['image']); ?>" 
                         alt="<?php echo htmlspecialchars($item['title']); ?>" 
                         class="gallery-image">
                    <div class="gallery-overlay">
                        <div class="gallery-content">
                            <div class="gallery-category"><?php echo htmlspecialchars(ucfirst($item['category'])); ?></div>
                            <h4 class="gallery-title"><?php echo htmlspecialchars($item['title']); ?></h4>
                            <p class="gallery-description"><?php echo htmlspecialchars($item['description']); ?></p>
                            <a href="#" class="btn btn-premium btn-sm">View Full</a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section-padding contact-section">
        <div class="container">
            <div class="section-title">
                <h2>Get In Touch</h2>
                <p class="section-subtitle">Ready to transform your digital vision into reality?</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="contact-card animate-on-scroll">
                        <div class="row">
                            <div class="col-lg-7">
                                <form id="contactForm" action="process/contact.php" method="POST">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                                        </div>
                                        <div class="col-md-6">
                                            <input type="email" class="form-control" name="email" placeholder="Your Email" required>
                                        </div>
                                        <div class="col-12">
                                            <input type="text" class="form-control" name="subject" placeholder="Subject" required>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form-control" name="message" placeholder="Your Message" rows="6" required></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-premium w-100">Send Message</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            
                            <div class="col-lg-5">
                                <div class="contact-info">
                                    <div class="contact-info-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Our Location</h5>
                                            <p><?php echo htmlspecialchars($companyAddress); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-info-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Phone Number</h5>
                                            <p><?php echo htmlspecialchars($companyPhone); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-info-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Email Address</h5>
                                            <p><?php echo htmlspecialchars($companyEmail); ?></p>
                                        </div>
                                    </div>
                                    
                                    <div class="contact-info-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-clock"></i>
                                        </div>
                                        <div class="contact-details">
                                            <h5>Working Hours</h5>
                                            <p>Mon - Fri: 9:00 AM - 6:00 PM</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="premium-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-logo">doit.np</a>
                    <p class="footer-tagline">Transforming digital landscapes with innovative solutions and exceptional craftsmanship.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <h5 class="footer-heading">Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="#home">Home</a></li>
                        <li><a href="#about">About Us</a></li>
                        <li><a href="#services">Services</a></li>
                        <li><a href="#portfolio">Portfolio</a></li>
                        <li><a href="#gallery">Gallery</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4 mb-5 mb-md-0">
                    <h5 class="footer-heading">Our Services</h5>
                    <ul class="footer-links">
                        <?php foreach(array_slice($services, 0, 5) as $service): ?>
                        <li><a href="#"><?php echo htmlspecialchars($service['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-4">
                    <h5 class="footer-heading">Newsletter</h5>
                    <p class="text-light mb-4">Subscribe to our newsletter for the latest updates.</p>
                    <form class="newsletter-form">
                        <div class="input-group">
                            <input type="email" class="form-control" placeholder="Your email" required>
                            <button class="btn btn-premium" type="submit">Subscribe</button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="copyright">
                <p>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($companyName); ?>. All rights reserved. | Crafted with <i class="fas fa-heart text-danger"></i> in Nepal</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
        // Initialize Swiper
        const swiper = new Swiper('.hero-swiper', {
            loop: true,
            speed: 1000,
            autoplay: {
                delay: 7000,
                disableOnInteraction: false,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
            effect: 'fade',
            fadeEffect: {
                crossFade: true
            },
        });
        
        // Header scroll effect
        window.addEventListener('scroll', function() {
            const header = document.getElementById('mainHeader');
            if (window.scrollY > 100) {
                header.classList.add('header-scrolled');
            } else {
                header.classList.remove('header-scrolled');
            }
        });
        
        // Tech Stack Filtering
        document.querySelectorAll('.tech-filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.tech-filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter tech items
                const filter = this.getAttribute('data-filter');
                const items = document.querySelectorAll('.tech-item');
                
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                            item.style.transform = 'scale(1)';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        item.style.transform = 'scale(0.8)';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Portfolio Filtering
        document.querySelectorAll('.portfolio-filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.portfolio-filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter portfolio items
                const filter = this.getAttribute('data-filter');
                const items = document.querySelectorAll('.portfolio-item');
                
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Gallery Filtering
        document.querySelectorAll('.gallery-filter-btn').forEach(button => {
            button.addEventListener('click', function() {
                // Update active button
                document.querySelectorAll('.gallery-filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                this.classList.add('active');
                
                // Filter gallery items
                const filter = this.getAttribute('data-filter');
                const items = document.querySelectorAll('.gallery-item');
                
                items.forEach(item => {
                    if (filter === 'all' || item.getAttribute('data-category') === filter) {
                        item.style.display = 'block';
                        setTimeout(() => {
                            item.style.opacity = '1';
                        }, 100);
                    } else {
                        item.style.opacity = '0';
                        setTimeout(() => {
                            item.style.display = 'none';
                        }, 300);
                    }
                });
            });
        });
        
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return;
                
                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    // Update active nav link
                    document.querySelectorAll('.nav-link').forEach(link => {
                        link.classList.remove('active');
                    });
                    this.classList.add('active');
                    
                    // Scroll to target
                    window.scrollTo({
                        top: targetElement.offsetTop - 80,
                        behavior: 'smooth'
                    });
                }
            });
        });
        
        // Animation on scroll
        const animateOnScroll = () => {
            const elements = document.querySelectorAll('.animate-on-scroll');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('visible');
                }
            });
        };
        
        // Contact form submission
        document.getElementById('contactForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simple validation
            const formData = new FormData(this);
            let isValid = true;
            
            formData.forEach((value, key) => {
                if (!value.trim()) {
                    isValid = false;
                    const input = this.querySelector(`[name="${key}"]`);
                    input.style.borderColor = '#dc3545';
                    
                    // Reset border color on focus
                    input.addEventListener('focus', function() {
                        this.style.borderColor = '';
                    });
                }
            });
            
            if (isValid) {
                // In real implementation, this would be an AJAX call
                alert('Thank you for your message! We will get back to you soon.');
                this.reset();
            } else {
                alert('Please fill in all required fields.');
            }
        });
        
        // Newsletter form
        document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const email = this.querySelector('input[type="email"]').value;
            
            if (email) {
                alert('Thank you for subscribing to our newsletter!');
                this.reset();
            }
        });
        
        // Initialize animations
        window.addEventListener('load', animateOnScroll);
        window.addEventListener('scroll', animateOnScroll);
        
        // Add video logo fallback
        const logoVideo = document.querySelector('.logo-video');
        if (logoVideo) {
            logoVideo.addEventListener('error', function() {
                // Try GIF fallback
                const gifSource = document.createElement('source');
                gifSource.src = 'assets/videos/logo-animation.gif';
                gifSource.type = 'image/gif';
                this.appendChild(gifSource);
                this.load();
            });
        }
    </script>
</body>
</html>