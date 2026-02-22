<?php
// MantraTech - Central Configuration
session_start();

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'mantratech_db');

// Admin credentials (plain password for simple auth as requested)
define('ADMIN_USER', 'admin');
define('ADMIN_PASS', 'admin123');

// Upload paths
define('UPLOAD_PATH', __DIR__ . '/assets/images/uploads/');
define('UPLOAD_URL', 'assets/images/uploads/');
define('HERO_UPLOAD_PATH', __DIR__ . '/assets/images/hero/');
define('HERO_UPLOAD_URL', 'assets/images/hero/');

// Create connection
function getDB() {
    static $conn = null;
    if ($conn === null) {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        if ($conn) {
            mysqli_set_charset($conn, "utf8mb4");
        }
    }
    return $conn;
}

$conn = getDB();

// ─── Data Retrieval Functions ─────────────────────────────────────────────────

function getSetting($conn, $key, $default = '') {
    if (!$conn) return $default;
    $key = mysqli_real_escape_string($conn, $key);
    $result = mysqli_query($conn, "SELECT setting_value FROM site_settings WHERE setting_key='$key' LIMIT 1");
    if ($result && $row = mysqli_fetch_assoc($result)) {
        return $row['setting_value'];
    }
    return $default;
}

function getServices($conn) {
    if (!$conn) {
        return [
            ['id'=>1,'title'=>'Web Development','description'=>'Custom websites and web applications built with latest technologies.','icon'=>'fas fa-code','is_active'=>1],
            ['id'=>2,'title'=>'Mobile App Development','description'=>'Native and cross-platform mobile applications for iOS and Android.','icon'=>'fas fa-mobile-alt','is_active'=>1],
            ['id'=>3,'title'=>'UI/UX Design','description'=>'User-centered design that creates exceptional digital experiences.','icon'=>'fas fa-paint-brush','is_active'=>1],
            ['id'=>4,'title'=>'E-commerce Solutions','description'=>'Complete online store setup with secure payment integration.','icon'=>'fas fa-shopping-cart','is_active'=>1],
            ['id'=>5,'title'=>'Cloud Solutions','description'=>'Scalable cloud infrastructure and migration services.','icon'=>'fas fa-cloud','is_active'=>1],
            ['id'=>6,'title'=>'Digital Marketing','description'=>'Data-driven marketing strategies to grow your online presence.','icon'=>'fas fa-chart-line','is_active'=>1],
            ['id'=>7,'title'=>'AI & ML Solutions','description'=>'Intelligent systems and machine learning algorithms.','icon'=>'fas fa-robot','is_active'=>1],
            ['id'=>8,'title'=>'Cybersecurity','description'=>'Protect your digital assets with advanced security solutions.','icon'=>'fas fa-shield-alt','is_active'=>1],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM services WHERE is_active=1 ORDER BY display_order ASC");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getServices(false);
}

function getPortfolio($conn) {
    if (!$conn) {
        return [
            ['id'=>1,'title'=>'E-commerce Platform','category'=>'ecommerce','client'=>'Fashion Store','image'=>'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&auto=format&fit=crop&q=60','technologies'=>'PHP, MySQL, JavaScript, React'],
            ['id'=>2,'title'=>'Mobile Banking App','category'=>'mobile','client'=>'Finance Bank','image'=>'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&auto=format&fit=crop&q=60','technologies'=>'React Native, Node.js, MongoDB'],
            ['id'=>3,'title'=>'Corporate Portal','category'=>'web','client'=>'Tech Corporation','image'=>'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=60','technologies'=>'Laravel, Vue.js, MySQL'],
            ['id'=>4,'title'=>'Food Delivery App','category'=>'mobile','client'=>'QuickEats','image'=>'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&auto=format&fit=crop&q=60','technologies'=>'Flutter, Firebase, Node.js'],
            ['id'=>5,'title'=>'Learning Management System','category'=>'web','client'=>'EduTech Inc.','image'=>'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60','technologies'=>'Python, Django, PostgreSQL'],
            ['id'=>6,'title'=>'Healthcare Platform','category'=>'web','client'=>'MediCare','image'=>'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&auto=format&fit=crop&q=60','technologies'=>'React, Node.js, AWS'],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM portfolio WHERE is_featured=1 ORDER BY display_order ASC, created_at DESC LIMIT 9");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getPortfolio(false);
}

function getTechnologies($conn) {
    if (!$conn) {
        return [
            ['name'=>'PHP','icon'=>'fab fa-php','color'=>'#777BB4','category'=>'backend'],
            ['name'=>'Laravel','icon'=>'fab fa-laravel','color'=>'#FF2D20','category'=>'backend'],
            ['name'=>'JavaScript','icon'=>'fab fa-js','color'=>'#F7DF1E','category'=>'frontend'],
            ['name'=>'React','icon'=>'fab fa-react','color'=>'#61DAFB','category'=>'frontend'],
            ['name'=>'Vue.js','icon'=>'fab fa-vuejs','color'=>'#4FC08D','category'=>'frontend'],
            ['name'=>'Node.js','icon'=>'fab fa-node-js','color'=>'#339933','category'=>'backend'],
            ['name'=>'Python','icon'=>'fab fa-python','color'=>'#3776AB','category'=>'backend'],
            ['name'=>'AWS','icon'=>'fab fa-aws','color'=>'#FF9900','category'=>'cloud'],
            ['name'=>'Docker','icon'=>'fab fa-docker','color'=>'#2496ED','category'=>'devops'],
            ['name'=>'MySQL','icon'=>'fas fa-database','color'=>'#4479A1','category'=>'database'],
            ['name'=>'MongoDB','icon'=>'fas fa-server','color'=>'#47A248','category'=>'database'],
            ['name'=>'Flutter','icon'=>'fas fa-mobile','color'=>'#02569B','category'=>'mobile'],
            ['name'=>'React Native','icon'=>'fab fa-react','color'=>'#61DAFB','category'=>'mobile'],
            ['name'=>'Git','icon'=>'fab fa-git-alt','color'=>'#F05032','category'=>'tools'],
            ['name'=>'WordPress','icon'=>'fab fa-wordpress','color'=>'#21759B','category'=>'cms'],
            ['name'=>'Java','icon'=>'fab fa-java','color'=>'#007396','category'=>'backend'],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM technologies WHERE is_active=1 ORDER BY category, display_order");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getTechnologies(false);
}

function getClients($conn) {
    if (!$conn) {
        return [
            ['name'=>'Global Tech','logo'=>null],
            ['name'=>'FinServe Nepal','logo'=>null],
            ['name'=>'EduNepal','logo'=>null],
            ['name'=>'HealthBridge','logo'=>null],
            ['name'=>'RetailPro','logo'=>null],
            ['name'=>'CloudFirst','logo'=>null],
            ['name'=>'StartupHub','logo'=>null],
            ['name'=>'MediaMax','logo'=>null],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM clients WHERE is_active=1 ORDER BY display_order, name");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getClients(false);
}

function getHeroSlides($conn) {
    if (!$conn) {
        return [
            ['id'=>1,'title'=>'Digital Transformation Experts','subtitle'=>'We deliver cutting-edge IT solutions that transform businesses and drive growth','type'=>'image','media'=>'hero1.jpg','button_text'=>'Get Started','button_link'=>'#contact'],
            ['id'=>2,'title'=>'Innovate. Implement. Excel.','subtitle'=>'Your vision, our expertise — creating digital solutions that exceed expectations','type'=>'image','media'=>'hero2.jpg','button_text'=>'View Portfolio','button_link'=>'#portfolio'],
            ['id'=>3,'title'=>'Future Ready Solutions','subtitle'=>"Building tomorrow's technology today with AI, Cloud & Modern Frameworks",'type'=>'image','media'=>'hero3.jpg','button_text'=>'Our Services','button_link'=>'#services'],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM hero_slides WHERE is_active=1 ORDER BY display_order");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getHeroSlides(false);
}

function getGallery($conn) {
    if (!$conn) {
        return [
            ['id'=>1,'title'=>'Office Workspace','category'=>'office','description'=>'Our creative workspace environment','image'=>'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=800&auto=format&fit=crop&q=60'],
            ['id'=>2,'title'=>'Team Collaboration','category'=>'team','description'=>'Our team brainstorming session','image'=>'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60'],
            ['id'=>3,'title'=>'Project Launch','category'=>'event','description'=>'Successful project launch celebration','image'=>'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?w=800&auto=format&fit=crop&q=60'],
            ['id'=>4,'title'=>'Development Setup','category'=>'work','description'=>'Advanced development workstation','image'=>'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=60'],
            ['id'=>5,'title'=>'Client Meeting','category'=>'meeting','description'=>'Strategic client discussion','image'=>'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&auto=format&fit=crop&q=60'],
            ['id'=>6,'title'=>'Tech Conference','category'=>'event','description'=>'Speaking at tech conference','image'=>'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60'],
            ['id'=>7,'title'=>'Award Ceremony','category'=>'award','description'=>'Receiving industry recognition award','image'=>'https://images.unsplash.com/photo-1559131397-f94da358a3d9?w=800&auto=format&fit=crop&q=60'],
            ['id'=>8,'title'=>'Training Session','category'=>'team','description'=>'Internal team training workshop','image'=>'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=60'],
        ];
    }
    $result = mysqli_query($conn, "SELECT * FROM gallery WHERE is_active=1 ORDER BY display_order ASC, created_at DESC");
    $data = [];
    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) $data[] = $row;
        return $data;
    }
    return getGallery(false);
}

// Check if admin is logged in
function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin() {
    if (!isAdminLoggedIn()) {
        header('Location: /mantratech/admin/login.php');
        exit;
    }
}
