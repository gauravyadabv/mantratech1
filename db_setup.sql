-- MantraTech Database Setup
-- Run this SQL in phpMyAdmin or MySQL CLI

CREATE DATABASE IF NOT EXISTS mantratech_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mantratech_db;

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert default admin (password: admin123)
INSERT INTO admin_users (username, password, email) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@mantratech.com')
ON DUPLICATE KEY UPDATE username=username;

-- Hero Slides Table
CREATE TABLE IF NOT EXISTS hero_slides (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    subtitle TEXT,
    type ENUM('image','video') DEFAULT 'image',
    media VARCHAR(255),
    button_text VARCHAR(100) DEFAULT 'Get Started',
    button_link VARCHAR(255) DEFAULT '#contact',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO hero_slides (title, subtitle, type, media, button_text, button_link, display_order) VALUES
('Digital Transformation Experts', 'We deliver cutting-edge IT solutions that transform businesses and drive growth', 'image', 'hero1.jpg', 'Get Started', '#contact', 1),
('Innovate. Implement. Excel.', 'Your vision, our expertise — creating digital solutions that exceed expectations', 'image', 'hero2.jpg', 'View Portfolio', '#portfolio', 2),
('Future Ready Solutions', 'Building tomorrow''s technology today with AI, Cloud & Modern Frameworks', 'image', 'hero3.jpg', 'Our Services', '#services', 3);

-- Services Table
CREATE TABLE IF NOT EXISTS services (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    icon VARCHAR(100) DEFAULT 'fas fa-cog',
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO services (title, description, icon, display_order) VALUES
('Web Development', 'Custom websites and web applications built with the latest technologies for superior performance.', 'fas fa-code', 1),
('Mobile App Development', 'Native and cross-platform mobile applications for iOS and Android that users love.', 'fas fa-mobile-alt', 2),
('UI/UX Design', 'User-centered design that creates exceptional digital experiences and drives engagement.', 'fas fa-paint-brush', 3),
('E-commerce Solutions', 'Complete online store setup with secure payment integration and inventory management.', 'fas fa-shopping-cart', 4),
('Cloud Solutions', 'Scalable cloud infrastructure, migration services, and DevOps automation.', 'fas fa-cloud', 5),
('Digital Marketing', 'Data-driven marketing strategies to grow your online presence and reach target audiences.', 'fas fa-chart-line', 6),
('AI & ML Solutions', 'Intelligent systems and machine learning algorithms to automate and optimize your business.', 'fas fa-robot', 7),
('Cybersecurity', 'Protect your digital assets with advanced security solutions and vulnerability assessment.', 'fas fa-shield-alt', 8);

-- Portfolio Table
CREATE TABLE IF NOT EXISTS portfolio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    client VARCHAR(255),
    description TEXT,
    image VARCHAR(255),
    technologies VARCHAR(255),
    project_url VARCHAR(255),
    is_featured TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO portfolio (title, category, client, description, image, technologies, is_featured) VALUES
('E-commerce Platform', 'ecommerce', 'Fashion Store', 'A fully featured e-commerce platform with product management, cart, and payment gateway integration.', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=800&auto=format&fit=crop&q=60', 'PHP, MySQL, JavaScript, React', 1),
('Mobile Banking App', 'mobile', 'Finance Bank', 'A secure mobile banking application with real-time transactions, transfers, and account management.', 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=800&auto=format&fit=crop&q=60', 'React Native, Node.js, MongoDB', 1),
('Corporate Portal', 'web', 'Tech Corporation', 'A comprehensive corporate intranet portal with HR, project management, and communication tools.', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800&auto=format&fit=crop&q=60', 'Laravel, Vue.js, MySQL', 1),
('Food Delivery App', 'mobile', 'QuickEats', 'A food delivery application with real-time tracking, restaurant management, and driver dispatch.', 'https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?w=800&auto=format&fit=crop&q=60', 'Flutter, Firebase, Node.js', 1),
('Learning Management System', 'web', 'EduTech Inc.', 'A comprehensive LMS with course creation, student tracking, assessments, and video streaming.', 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?w=800&auto=format&fit=crop&q=60', 'Python, Django, PostgreSQL', 1),
('Healthcare Platform', 'web', 'MediCare', 'A telemedicine platform connecting patients with doctors for video consultations and prescriptions.', 'https://images.unsplash.com/photo-1559757148-5c350d0d3c56?w=800&auto=format&fit=crop&q=60', 'React, Node.js, AWS', 1);

-- Technologies Table
CREATE TABLE IF NOT EXISTS technologies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    icon VARCHAR(100),
    color VARCHAR(20),
    category VARCHAR(50),
    display_order INT DEFAULT 0,
    is_active TINYINT(1) DEFAULT 1
);

INSERT INTO technologies (name, icon, color, category, display_order) VALUES
('PHP', 'fab fa-php', '#777BB4', 'backend', 1),
('Laravel', 'fab fa-laravel', '#FF2D20', 'backend', 2),
('JavaScript', 'fab fa-js', '#F7DF1E', 'frontend', 3),
('React', 'fab fa-react', '#61DAFB', 'frontend', 4),
('Vue.js', 'fab fa-vuejs', '#4FC08D', 'frontend', 5),
('Node.js', 'fab fa-node-js', '#339933', 'backend', 6),
('Python', 'fab fa-python', '#3776AB', 'backend', 7),
('Java', 'fab fa-java', '#007396', 'backend', 8),
('AWS', 'fab fa-aws', '#FF9900', 'cloud', 9),
('Docker', 'fab fa-docker', '#2496ED', 'devops', 10),
('MySQL', 'fas fa-database', '#4479A1', 'database', 11),
('MongoDB', 'fas fa-server', '#47A248', 'database', 12),
('React Native', 'fab fa-react', '#61DAFB', 'mobile', 13),
('Flutter', 'fas fa-mobile', '#02569B', 'mobile', 14),
('Git', 'fab fa-git-alt', '#F05032', 'tools', 15),
('WordPress', 'fab fa-wordpress', '#21759B', 'cms', 16);

-- Clients Table
CREATE TABLE IF NOT EXISTS clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    logo VARCHAR(255),
    website VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0
);

INSERT INTO clients (name, logo, is_active) VALUES
('Global Tech', NULL, 1),
('FinServe Nepal', NULL, 1),
('EduNepal', NULL, 1),
('HealthBridge', NULL, 1),
('RetailPro', NULL, 1),
('CloudFirst', NULL, 1),
('StartupHub', NULL, 1),
('MediaMax', NULL, 1);

-- Gallery Table
CREATE TABLE IF NOT EXISTS gallery (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100),
    description TEXT,
    image VARCHAR(255),
    is_active TINYINT(1) DEFAULT 1,
    display_order INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO gallery (title, category, description, image) VALUES
('Office Workspace', 'office', 'Our creative workspace environment', 'https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=800&auto=format&fit=crop&q=60'),
('Team Collaboration', 'team', 'Our team brainstorming session', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800&auto=format&fit=crop&q=60'),
('Project Launch', 'event', 'Successful project launch celebration', 'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?w=800&auto=format&fit=crop&q=60'),
('Development Setup', 'work', 'Advanced development workstation', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=800&auto=format&fit=crop&q=60'),
('Client Meeting', 'meeting', 'Strategic client discussion', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800&auto=format&fit=crop&q=60'),
('Tech Conference', 'event', 'Speaking at international tech conference', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=800&auto=format&fit=crop&q=60'),
('Award Ceremony', 'award', 'Receiving industry recognition award', 'https://images.unsplash.com/photo-1559131397-f94da358a3d9?w=800&auto=format&fit=crop&q=60'),
('Training Session', 'team', 'Internal team training workshop', 'https://images.unsplash.com/photo-1515187029135-18ee286d815b?w=800&auto=format&fit=crop&q=60');

-- Contact Messages Table
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    subject VARCHAR(255),
    message TEXT NOT NULL,
    is_read TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Site Settings Table
CREATE TABLE IF NOT EXISTS site_settings (
    id INT AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(100) NOT NULL UNIQUE,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

INSERT INTO site_settings (setting_key, setting_value) VALUES
('company_name', 'MantraTech'),
('company_slogan', 'We deliver what you need'),
('company_email', 'info@mantratech.com'),
('company_phone', '+977 9800000000'),
('company_address', 'Kathmandu, Nepal'),
('company_facebook', '#'),
('company_twitter', '#'),
('company_linkedin', '#'),
('company_instagram', '#'),
('company_github', '#'),
('about_text_1', 'At MantraTech, we transcend conventional IT services to become your strategic innovation partner. Our philosophy is built on delivering not just solutions, but transformative digital experiences that propel businesses into the future.'),
('about_text_2', 'We combine cutting-edge technology with deep industry insights to architect solutions that are not only technologically superior but also drive measurable business impact. Our commitment is to excellence, innovation, and lasting partnerships.'),
('hero_image', '')
ON DUPLICATE KEY UPDATE setting_key=setting_key;
