<?php
require_once 'config.php';

$services   = getServices($conn);
$portfolio  = getPortfolio($conn);
$technologies = getTechnologies($conn);
$clients    = getClients($conn);
$heroSlides = getHeroSlides($conn);
$gallery    = getGallery($conn);

$companyName    = $conn ? getSetting($conn, 'company_name', 'MantraTech') : 'MantraTech';
$companySlogan  = $conn ? getSetting($conn, 'company_slogan', 'We deliver what you need') : 'We deliver what you need';
$companyEmail   = $conn ? getSetting($conn, 'company_email', 'info@mantratech.com') : 'info@mantratech.com';
$companyPhone   = $conn ? getSetting($conn, 'company_phone', '+977 9800000000') : '+977 9800000000';
$companyAddress = $conn ? getSetting($conn, 'company_address', 'Kathmandu, Nepal') : 'Kathmandu, Nepal';
$aboutText1     = $conn ? getSetting($conn, 'about_text_1', 'At MantraTech, we transcend conventional IT services to become your strategic innovation partner.') : 'At MantraTech, we transcend conventional IT services to become your strategic innovation partner.';
$aboutText2     = $conn ? getSetting($conn, 'about_text_2', 'We combine cutting-edge technology with deep industry insights to architect solutions that drive measurable business impact.') : 'We combine cutting-edge technology to drive measurable business impact.';
$fbLink   = $conn ? getSetting($conn, 'company_facebook', '#') : '#';
$twLink   = $conn ? getSetting($conn, 'company_twitter', '#') : '#';
$liLink   = $conn ? getSetting($conn, 'company_linkedin', '#') : '#';
$igLink   = $conn ? getSetting($conn, 'company_instagram', '#') : '#';
$ghLink   = $conn ? getSetting($conn, 'company_github', '#') : '#';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($companyName) ?> | Premium IT Solutions Nepal</title>
<meta name="description" content="MantraTech delivers premium IT solutions — web development, mobile apps, AI, and digital transformation services in Nepal.">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Syne:wght@600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
<style>
:root{
  --primary:#6366f1;
  --primary-dark:#4f46e5;
  --primary-light:#e0e7ff;
  --accent:#8b5cf6;
  --text-dark:#0f172a;
  --text-body:#374151;
  --text-muted:#6b7280;
  --bg-white:#ffffff;
  --bg-light:#f8fafc;
  --bg-section:#f1f5f9;
  --border:#e5e7eb;
  --shadow-sm:0 1px 3px rgba(0,0,0,.07);
  --shadow:0 4px 20px rgba(0,0,0,.08);
  --shadow-lg:0 20px 60px rgba(99,102,241,.12);
}
*{margin:0;padding:0;box-sizing:border-box}
html{scroll-behavior:smooth}
body{font-family:'Inter',sans-serif;background:var(--bg-white);color:var(--text-body);overflow-x:hidden}
h1,h2,h3,h4,h5{font-family:'Syne',sans-serif;color:var(--text-dark)}

/* ── SCROLLBAR ── */
::-webkit-scrollbar{width:6px}
::-webkit-scrollbar-track{background:#f1f5f9}
::-webkit-scrollbar-thumb{background:var(--primary);border-radius:3px}

/* ── NAV ── */
.site-nav{position:fixed;top:0;width:100%;background:rgba(255,255,255,.92);backdrop-filter:blur(16px);border-bottom:1px solid var(--border);z-index:1000;transition:all .3s}
.site-nav.scrolled{box-shadow:var(--shadow)}
.nav-brand{display:flex;align-items:center;gap:10px;text-decoration:none}
.brand-dot{width:36px;height:36px;background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:16px;font-weight:800}
.brand-name{font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:var(--text-dark)}
.brand-name span{color:var(--primary)}
.nav-link-item{color:var(--text-body)!important;font-weight:500;font-size:14px;padding:8px 14px!important;border-radius:8px;transition:all .2s}
.nav-link-item:hover,.nav-link-item.active{color:var(--primary)!important;background:var(--primary-light)}
.nav-cta{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff!important;border-radius:10px;padding:9px 22px!important;font-weight:600!important;font-size:14px!important}
.nav-cta:hover{transform:translateY(-1px);box-shadow:0 6px 20px rgba(99,102,241,.3);background:linear-gradient(135deg,#4f46e5,#7c3aed)!important;color:#fff!important}

/* ── HERO ── */
.hero-section{height:100vh;position:relative;overflow:hidden;margin-top:65px}
.hero-swiper,.hero-slide{height:100%}
.slide-bg{position:absolute;inset:0;background-size:cover;background-position:center;transition:transform 8s ease}
.slide-overlay{position:absolute;inset:0;background:linear-gradient(135deg,rgba(99,102,241,.85) 0%,rgba(139,92,246,.7) 100%)}
.hero-content{position:relative;z-index:2;height:100%;display:flex;align-items:center;justify-content:center;text-align:center;padding:0 20px}
.hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(255,255,255,.15);border:1px solid rgba(255,255,255,.3);border-radius:50px;padding:6px 18px;color:#fff;font-size:13px;font-weight:500;margin-bottom:24px;backdrop-filter:blur(4px)}
.hero-title{font-size:clamp(2.4rem,5vw,4.2rem);font-weight:800;color:#fff;line-height:1.15;margin-bottom:20px}
.hero-title .highlight{background:linear-gradient(135deg,#fbbf24,#f59e0b);-webkit-background-clip:text;-webkit-text-fill-color:transparent}
.hero-subtitle{font-size:1.15rem;color:rgba(255,255,255,.85);max-width:580px;margin:0 auto 16px;line-height:1.7}
.hero-slogan{font-size:1rem;color:rgba(255,255,255,.7);font-style:italic;margin-bottom:36px}
.hero-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
.btn-hero-primary{background:#fff;color:var(--primary);border:none;border-radius:12px;padding:14px 32px;font-weight:700;font-size:15px;cursor:pointer;transition:all .3s;text-decoration:none;display:inline-flex;align-items:center;gap:8px}
.btn-hero-primary:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(0,0,0,.2);color:var(--primary)}
.btn-hero-secondary{background:transparent;color:#fff;border:2px solid rgba(255,255,255,.5);border-radius:12px;padding:13px 32px;font-weight:600;font-size:15px;cursor:pointer;transition:all .3s;text-decoration:none;display:inline-flex;align-items:center;gap:8px}
.btn-hero-secondary:hover{border-color:#fff;background:rgba(255,255,255,.1);color:#fff}
.hero-stats{display:flex;gap:40px;justify-content:center;margin-top:50px;flex-wrap:wrap}
.hero-stat-num{font-size:2rem;font-weight:800;color:#fff}
.hero-stat-label{font-size:12px;color:rgba(255,255,255,.7);text-transform:uppercase;letter-spacing:1px}
.swiper-button-next,.swiper-button-prev{color:#fff!important;background:rgba(255,255,255,.15);width:44px!important;height:44px!important;border-radius:50%;backdrop-filter:blur(4px)}
.swiper-button-next:after,.swiper-button-prev:after{font-size:15px!important}
.swiper-pagination-bullet{background:#fff!important;opacity:.5}
.swiper-pagination-bullet-active{opacity:1!important}

/* ── SECTION COMMON ── */
.section-pad{padding:100px 0}
.section-tag{display:inline-flex;align-items:center;gap:8px;background:var(--primary-light);color:var(--primary);border-radius:50px;padding:5px 16px;font-size:12px;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:16px}
.section-title{font-size:clamp(2rem,3vw,2.8rem);font-weight:800;color:var(--text-dark);margin-bottom:12px;line-height:1.2}
.section-sub{color:var(--text-muted);font-size:1rem;max-width:540px;line-height:1.7}
.divider{width:60px;height:4px;background:linear-gradient(90deg,#6366f1,#8b5cf6);border-radius:2px;margin:16px 0}
.divider.center{margin-left:auto;margin-right:auto}

/* ── ABOUT ── */
.about-section{background:var(--bg-white)}
.about-img-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.about-img-item{border-radius:16px;overflow:hidden;height:220px}
.about-img-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.about-img-item:hover img{transform:scale(1.05)}
.stat-pill{display:flex;align-items:center;gap:14px;background:var(--bg-light);border-radius:14px;padding:16px 20px;border:1px solid var(--border)}
.stat-pill-num{font-size:1.8rem;font-weight:800;color:var(--primary)}
.stat-pill-label{font-size:13px;color:var(--text-muted);font-weight:500}
.btn-outline-primary-custom{display:inline-flex;align-items:center;gap:8px;color:var(--primary);border:2px solid var(--primary);border-radius:10px;padding:11px 26px;font-weight:600;font-size:14px;text-decoration:none;transition:all .3s}
.btn-outline-primary-custom:hover{background:var(--primary);color:#fff;transform:translateX(4px)}

/* ── SERVICES ── */
.services-section{background:var(--bg-light)}
.service-card{background:#fff;border-radius:20px;padding:36px 28px;height:100%;border:1px solid var(--border);transition:all .35s;position:relative;overflow:hidden}
.service-card::before{content:'';position:absolute;top:0;left:0;width:100%;height:4px;background:linear-gradient(90deg,#6366f1,#8b5cf6);transform:scaleX(0);transform-origin:left;transition:transform .35s}
.service-card:hover{transform:translateY(-8px);box-shadow:var(--shadow-lg);border-color:transparent}
.service-card:hover::before{transform:scaleX(1)}
.service-icon-wrap{width:60px;height:60px;background:var(--primary-light);border-radius:16px;display:flex;align-items:center;justify-content:center;font-size:24px;color:var(--primary);margin-bottom:22px;transition:all .35s}
.service-card:hover .service-icon-wrap{background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;transform:scale(1.1)}
.service-card h4{font-size:1.15rem;font-weight:700;margin-bottom:12px}
.service-card p{color:var(--text-muted);font-size:14px;line-height:1.7;margin-bottom:18px}
.service-link{color:var(--primary);font-size:13px;font-weight:600;display:inline-flex;align-items:center;gap:6px;text-decoration:none;transition:gap .2s}
.service-link:hover{gap:10px;color:var(--accent)}

/* ── CLIENTS ── */
.clients-section{background:#fff;padding:72px 0}
.client-card{background:var(--bg-light);border-radius:16px;padding:28px;display:flex;align-items:center;justify-content:center;min-height:100px;border:1px solid var(--border);transition:all .3s}
.client-card:hover{border-color:var(--primary);box-shadow:0 4px 20px rgba(99,102,241,.1);transform:translateY(-4px)}
.client-card img{max-width:130px;max-height:45px;filter:grayscale(100%);opacity:.6;transition:all .3s}
.client-card:hover img{filter:none;opacity:1}
.client-name-only{font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:var(--text-muted);letter-spacing:.5px;transition:color .3s}
.client-card:hover .client-name-only{color:var(--primary)}

/* ── TECH STACK ── */
.tech-section{background:var(--bg-light)}
.filter-bar{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;margin-bottom:48px}
.filter-btn{background:#fff;border:1.5px solid var(--border);color:var(--text-muted);border-radius:50px;padding:8px 20px;font-size:13px;font-weight:600;cursor:pointer;transition:all .25s}
.filter-btn.active,.filter-btn:hover{background:var(--primary);border-color:var(--primary);color:#fff}
.tech-card{background:#fff;border-radius:16px;padding:24px 16px;text-align:center;border:1px solid var(--border);transition:all .3s;height:100%}
.tech-card:hover{transform:translateY(-6px);box-shadow:var(--shadow);border-color:var(--primary-light)}
.tech-card .t-icon{font-size:2.5rem;margin-bottom:10px;display:block}
.tech-card .t-name{font-size:13px;font-weight:700;color:var(--text-dark)}

/* ── PORTFOLIO ── */
.portfolio-section{background:#fff}
.portfolio-item{border-radius:20px;overflow:hidden;position:relative;height:300px}
.portfolio-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.portfolio-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(15,23,42,.95) 0%,rgba(99,102,241,.6) 100%);opacity:0;transition:opacity .35s;display:flex;align-items:flex-end;padding:24px}
.portfolio-item:hover img{transform:scale(1.08)}
.portfolio-item:hover .portfolio-overlay{opacity:1}
.portfolio-cat{font-size:11px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:4px}
.portfolio-ttl{font-size:1.1rem;font-weight:700;color:#fff;margin-bottom:6px}
.portfolio-tech{font-size:12px;color:rgba(255,255,255,.6)}

/* ── GALLERY ── */
.gallery-section{background:var(--bg-light)}
.gallery-item{border-radius:16px;overflow:hidden;position:relative;height:250px}
.gallery-item img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.gallery-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(99,102,241,.9),transparent);opacity:0;transition:opacity .3s;display:flex;flex-direction:column;justify-content:flex-end;padding:20px}
.gallery-item:hover img{transform:scale(1.08)}
.gallery-item:hover .gallery-overlay{opacity:1}
.gallery-cat{font-size:10px;text-transform:uppercase;letter-spacing:1px;color:rgba(255,255,255,.7);margin-bottom:4px}
.gallery-ttl{font-size:.95rem;font-weight:700;color:#fff}

/* ── CONTACT ── */
.contact-section{background:#fff}
.contact-form-wrap{background:var(--bg-light);border-radius:24px;padding:40px;border:1px solid var(--border)}
.contact-info-card{background:linear-gradient(135deg,#6366f1,#8b5cf6);border-radius:24px;padding:40px;color:#fff;height:100%}
.contact-info-card h3{font-size:1.6rem;font-weight:800;color:#fff;margin-bottom:10px}
.contact-info-card p{color:rgba(255,255,255,.8);margin-bottom:32px}
.c-info-item{display:flex;align-items:center;gap:16px;margin-bottom:24px}
.c-info-icon{width:44px;height:44px;background:rgba(255,255,255,.15);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.c-info-label{font-size:12px;color:rgba(255,255,255,.6);margin-bottom:2px}
.c-info-val{font-size:14px;font-weight:600;color:#fff}
.form-ctrl{background:#fff;border:1.5px solid var(--border);border-radius:10px;padding:12px 16px;font-size:14px;font-family:'Inter',sans-serif;width:100%;transition:all .2s;color:var(--text-dark)}
.form-ctrl:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(99,102,241,.1);outline:none}
.form-ctrl::placeholder{color:#9ca3af}
.btn-submit{width:100%;background:linear-gradient(135deg,#6366f1,#8b5cf6);color:#fff;border:none;border-radius:12px;padding:14px;font-size:15px;font-weight:700;font-family:'Inter',sans-serif;cursor:pointer;transition:all .3s;display:flex;align-items:center;justify-content:center;gap:10px}
.btn-submit:hover{transform:translateY(-2px);box-shadow:0 10px 30px rgba(99,102,241,.3)}
.social-row{display:flex;gap:12px;margin-top:32px}
.social-btn{width:40px;height:40px;background:rgba(255,255,255,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;font-size:16px;transition:all .3s}
.social-btn:hover{background:#fff;color:var(--primary)}

/* ── FOOTER ── */
.site-footer{background:#0f172a;padding:70px 0 28px;color:rgba(255,255,255,.65)}
.footer-brand-name{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:#fff;margin-bottom:10px}
.footer-brand-name span{color:#a5b4fc}
.footer-tagline{font-size:14px;color:rgba(255,255,255,.5);margin-bottom:22px}
.footer-social{display:flex;gap:10px}
.footer-social a{width:36px;height:36px;background:rgba(255,255,255,.08);border-radius:8px;display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.5);text-decoration:none;font-size:14px;transition:all .3s}
.footer-social a:hover{background:var(--primary);color:#fff}
.footer-heading{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:#fff;margin-bottom:18px}
.footer-links{list-style:none;padding:0}
.footer-links li{margin-bottom:10px}
.footer-links a{color:rgba(255,255,255,.5);text-decoration:none;font-size:14px;transition:color .2s;display:flex;align-items:center;gap:8px}
.footer-links a:hover{color:#fff}
.footer-links a::before{content:'›';color:var(--primary);font-weight:bold}
.footer-divider{border-top:1px solid rgba(255,255,255,.08);margin-top:50px;padding-top:24px;text-align:center;color:rgba(255,255,255,.35);font-size:13px}

/* ── ANIMATIONS ── */
.fade-up{opacity:0;transform:translateY(28px);transition:all .65s ease}
.fade-up.visible{opacity:1;transform:translateY(0)}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-12px)}}
.float{animation:float 4s ease-in-out infinite}

/* ── TOAST ── */
.toast-msg{position:fixed;bottom:28px;right:28px;background:#fff;border-radius:14px;padding:16px 22px;box-shadow:0 10px 40px rgba(0,0,0,.12);border-left:4px solid var(--primary);display:flex;align-items:center;gap:12px;font-size:14px;font-weight:500;color:var(--text-dark);z-index:9999;transform:translateY(80px);opacity:0;transition:all .4s}
.toast-msg.show{transform:translateY(0);opacity:1}
.toast-msg.success{border-color:#10b981}
.toast-msg.error{border-color:#ef4444}

/* ── SPINNER ── */
.spin-loader{display:inline-block;width:18px;height:18px;border:2px solid rgba(255,255,255,.4);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}

@media(max-width:992px){
  .about-img-grid{grid-template-columns:1fr 1fr}
  .hero-stats{gap:24px}
}
@media(max-width:768px){
  .section-pad{padding:72px 0}
  .contact-info-card{margin-top:24px}
  .hero-title{font-size:2.2rem}
}
</style>
</head>
<body>

<!-- NAV -->
<nav class="site-nav" id="siteNav">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between py-2">
      <a href="#home" class="nav-brand">
        <div class="brand-dot"><i class="fas fa-code"></i></div>
        <div class="brand-name">Mantra<span>Tech</span></div>
      </a>
      <button class="navbar-toggler d-lg-none border-0 bg-transparent" id="navToggle" style="font-size:20px; color:var(--text-dark);">
        <i class="fas fa-bars"></i>
      </button>
      <div class="d-none d-lg-flex align-items-center gap-1" id="navMenu">
        <a href="#home"      class="nav-link-item nav-link active">Home</a>
        <a href="#about"     class="nav-link-item nav-link">About</a>
        <a href="#services"  class="nav-link-item nav-link">Services</a>
        <a href="#clients"   class="nav-link-item nav-link">Clients</a>
        <a href="#tech"      class="nav-link-item nav-link">Tech Stack</a>
        <a href="#portfolio" class="nav-link-item nav-link">Portfolio</a>
        <a href="#gallery"   class="nav-link-item nav-link">Gallery</a>
        <a href="#contact"   class="nav-link-item nav-link">Contact</a>
        <a href="#contact"   class="nav-link-item nav-cta nav-link ms-2">Get Quote</a>
      </div>
    </div>
    <!-- Mobile Menu -->
    <div class="d-lg-none" id="mobileMenu" style="display:none!important; padding-bottom:16px;">
      <div class="d-flex flex-column gap-1">
        <a href="#home"      class="nav-link-item nav-link">Home</a>
        <a href="#about"     class="nav-link-item nav-link">About</a>
        <a href="#services"  class="nav-link-item nav-link">Services</a>
        <a href="#clients"   class="nav-link-item nav-link">Clients</a>
        <a href="#tech"      class="nav-link-item nav-link">Tech Stack</a>
        <a href="#portfolio" class="nav-link-item nav-link">Portfolio</a>
        <a href="#gallery"   class="nav-link-item nav-link">Gallery</a>
        <a href="#contact"   class="nav-link-item nav-link">Contact</a>
        <a href="#contact"   class="nav-cta nav-link text-center mt-1">Get Quote</a>
      </div>
    </div>
  </div>
</nav>

<!-- HERO -->
<section id="home" class="hero-section">
  <div class="swiper hero-swiper">
    <div class="swiper-wrapper">
      <?php foreach($heroSlides as $i => $slide): ?>
      <div class="swiper-slide hero-slide">
        <?php
        $bgUrl = '';
        if ($slide['type'] === 'image') {
          $media = $slide['media'];
          if (str_starts_with($media,'http')) {
            $bgUrl = $media;
          } elseif (file_exists(HERO_UPLOAD_PATH . $media)) {
            $bgUrl = HERO_UPLOAD_URL . $media;
          } else {
            $unsplashHero = [
              'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1600&fit=crop&q=80',
              'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1600&fit=crop&q=80',
              'https://images.unsplash.com/photo-1504384308090-c894fdcc538d?w=1600&fit=crop&q=80',
            ];
            $bgUrl = $unsplashHero[$i % count($unsplashHero)];
          }
        }
        ?>
        <?php if ($slide['type'] === 'video'): ?>
        <video autoplay muted loop playsinline style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:.35;">
          <source src="assets/videos/<?= htmlspecialchars($slide['media']) ?>" type="video/mp4">
        </video>
        <div class="slide-overlay"></div>
        <?php else: ?>
        <div class="slide-bg" style="background-image:url('<?= htmlspecialchars($bgUrl) ?>')"></div>
        <div class="slide-overlay"></div>
        <?php endif; ?>
        <div class="hero-content">
          <div>
            <div class="hero-badge float">
              <i class="fas fa-star"></i>
              Nepal's #1 IT Company
            </div>
            <h1 class="hero-title"><?= htmlspecialchars($slide['title']) ?></h1>
            <p class="hero-subtitle"><?= htmlspecialchars($slide['subtitle']) ?></p>
            <p class="hero-slogan">"<?= htmlspecialchars($companySlogan) ?>"</p>
            <div class="hero-btns">
              <a href="<?= htmlspecialchars($slide['button_link']) ?>" class="btn-hero-primary">
                <?= htmlspecialchars($slide['button_text']) ?> <i class="fas fa-arrow-right"></i>
              </a>
              <a href="#about" class="btn-hero-secondary">
                <i class="fas fa-play"></i> About Us
              </a>
            </div>
            <div class="hero-stats">
              <div class="text-center"><div class="hero-stat-num">150+</div><div class="hero-stat-label">Projects Done</div></div>
              <div class="text-center"><div class="hero-stat-num">50+</div><div class="hero-stat-label">Happy Clients</div></div>
              <div class="text-center"><div class="hero-stat-num">98%</div><div class="hero-stat-label">Satisfaction</div></div>
              <div class="text-center"><div class="hero-stat-num">8+</div><div class="hero-stat-label">Years</div></div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="swiper-pagination"></div>
  </div>
</section>

<!-- ABOUT -->
<section id="about" class="section-pad about-section">
  <div class="container">
    <div class="row align-items-center g-5">
      <div class="col-lg-5">
        <div class="about-img-grid">
          <?php
          $aboutImgs = [
            'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600&fit=crop&q=80',
            'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600&fit=crop&q=80',
            'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600&fit=crop&q=80',
            'https://images.unsplash.com/photo-1542744095-fcf48d80b0fd?w=600&fit=crop&q=80',
          ];
          foreach ($aboutImgs as $img): ?>
          <div class="about-img-item fade-up"><img src="<?= $img ?>" alt="MantraTech Team"></div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-lg-7">
        <div class="section-tag"><i class="fas fa-info-circle"></i> About MantraTech</div>
        <h2 class="section-title">Building the Future,<br>One Solution at a Time</h2>
        <div class="divider"></div>
        <p style="color:var(--text-body);line-height:1.85;margin-bottom:16px;"><?= htmlspecialchars($aboutText1) ?></p>
        <p style="color:var(--text-muted);line-height:1.85;margin-bottom:32px;"><?= htmlspecialchars($aboutText2) ?></p>
        <div class="row g-3 mb-4">
          <div class="col-6"><div class="stat-pill fade-up"><div class="stat-pill-num">150+</div><div class="stat-pill-label">Projects Completed</div></div></div>
          <div class="col-6"><div class="stat-pill fade-up"><div class="stat-pill-num">50+</div><div class="stat-pill-label">Happy Clients</div></div></div>
          <div class="col-6"><div class="stat-pill fade-up"><div class="stat-pill-num">98%</div><div class="stat-pill-label">Success Rate</div></div></div>
          <div class="col-6"><div class="stat-pill fade-up"><div class="stat-pill-num">8+</div><div class="stat-pill-label">Years of Excellence</div></div></div>
        </div>
        <a href="#contact" class="btn-outline-primary-custom">Start a Project <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section id="services" class="section-pad services-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-cogs"></i> What We Do</div>
      <h2 class="section-title">Our Services</h2>
      <div class="divider center"></div>
      <p class="section-sub mx-auto">Comprehensive IT solutions engineered for your business success</p>
    </div>
    <div class="row g-4">
      <?php foreach($services as $i => $svc): ?>
      <div class="col-lg-3 col-md-6 fade-up" style="transition-delay:<?= $i*0.07 ?>s">
        <div class="service-card">
          <div class="service-icon-wrap"><i class="<?= htmlspecialchars($svc['icon']) ?>"></i></div>
          <h4><?= htmlspecialchars($svc['title']) ?></h4>
          <p><?= htmlspecialchars($svc['description']) ?></p>
          <a href="#contact" class="service-link">Learn More <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CLIENTS -->
<section id="clients" class="clients-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-handshake"></i> Trusted By</div>
      <h2 class="section-title">Our Clients</h2>
      <div class="divider center"></div>
    </div>
    <div class="row g-4">
      <?php foreach($clients as $i => $client): ?>
      <div class="col-lg-3 col-md-4 col-6 fade-up" style="transition-delay:<?= $i*0.05 ?>s">
        <div class="client-card">
          <?php if ($client['logo']): ?>
            <?php $src = str_starts_with($client['logo'],'http') ? $client['logo'] : 'assets/images/'.$client['logo']; ?>
            <img src="<?= htmlspecialchars($src) ?>" alt="<?= htmlspecialchars($client['name']) ?>" onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
            <div class="client-name-only" style="display:none"><?= htmlspecialchars($client['name']) ?></div>
          <?php else: ?>
            <div class="client-name-only"><?= htmlspecialchars($client['name']) ?></div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- TECH STACK -->
<section id="tech" class="section-pad tech-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-microchip"></i> Tech Stack</div>
      <h2 class="section-title">Technologies We Master</h2>
      <div class="divider center"></div>
    </div>
    <div class="filter-bar">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="frontend">Frontend</button>
      <button class="filter-btn" data-filter="backend">Backend</button>
      <button class="filter-btn" data-filter="mobile">Mobile</button>
      <button class="filter-btn" data-filter="database">Database</button>
      <button class="filter-btn" data-filter="cloud">Cloud</button>
    </div>
    <div class="row g-3 tech-grid">
      <?php foreach($technologies as $i => $tech): ?>
      <div class="col-lg-2 col-md-3 col-4 tech-item fade-up" data-category="<?= htmlspecialchars($tech['category']) ?>" style="transition-delay:<?= $i*0.04 ?>s">
        <div class="tech-card">
          <span class="t-icon"><i class="<?= htmlspecialchars($tech['icon']) ?>" style="color:<?= htmlspecialchars($tech['color']) ?>"></i></span>
          <div class="t-name"><?= htmlspecialchars($tech['name']) ?></div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PORTFOLIO -->
<section id="portfolio" class="section-pad portfolio-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-briefcase"></i> Our Work</div>
      <h2 class="section-title">Portfolio</h2>
      <div class="divider center"></div>
      <p class="section-sub mx-auto">Showcasing excellence in digital craftsmanship</p>
    </div>
    <div class="filter-bar mb-5">
      <button class="filter-btn active" data-filter="all">All Projects</button>
      <button class="filter-btn" data-filter="web">Web</button>
      <button class="filter-btn" data-filter="mobile">Mobile</button>
      <button class="filter-btn" data-filter="ecommerce">E-commerce</button>
      <button class="filter-btn" data-filter="design">Design</button>
    </div>
    <div class="row g-4 portfolio-grid">
      <?php foreach($portfolio as $i => $item): ?>
      <div class="col-lg-4 col-md-6 portfolio-item-wrap fade-up" data-category="<?= htmlspecialchars($item['category']) ?>" style="transition-delay:<?= $i*0.08 ?>s">
        <div class="portfolio-item">
          <?php $imgSrc = str_starts_with($item['image'],'http') ? $item['image'] : 'assets/images/'.$item['image']; ?>
          <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($item['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=600&fit=crop&q=60'">
          <div class="portfolio-overlay">
            <div>
              <div class="portfolio-cat"><?= htmlspecialchars(ucfirst($item['category'])) ?></div>
              <div class="portfolio-ttl"><?= htmlspecialchars($item['title']) ?></div>
              <div class="portfolio-tech"><?= htmlspecialchars($item['technologies'] ?? '') ?></div>
            </div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- GALLERY -->
<section id="gallery" class="section-pad gallery-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-images"></i> Gallery</div>
      <h2 class="section-title">Our Gallery</h2>
      <div class="divider center"></div>
      <p class="section-sub mx-auto">Moments that define our journey and culture</p>
    </div>
    <div class="filter-bar mb-5">
      <button class="filter-btn active" data-filter="all">All</button>
      <button class="filter-btn" data-filter="office">Office</button>
      <button class="filter-btn" data-filter="team">Team</button>
      <button class="filter-btn" data-filter="event">Events</button>
      <button class="filter-btn" data-filter="work">Work</button>
      <button class="filter-btn" data-filter="award">Awards</button>
    </div>
    <div class="row g-3 gallery-grid">
      <?php foreach($gallery as $i => $item): ?>
      <div class="col-lg-3 col-md-4 col-6 gallery-item-wrap fade-up" data-category="<?= htmlspecialchars($item['category']) ?>" style="transition-delay:<?= $i*0.05 ?>s">
        <div class="gallery-item">
          <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['title']) ?>" onerror="this.src='https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=400&fit=crop&q=60'">
          <div class="gallery-overlay">
            <div class="gallery-cat"><?= htmlspecialchars(ucfirst($item['category'])) ?></div>
            <div class="gallery-ttl"><?= htmlspecialchars($item['title']) ?></div>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section-pad contact-section">
  <div class="container">
    <div class="text-center mb-5">
      <div class="section-tag d-inline-flex"><i class="fas fa-paper-plane"></i> Get In Touch</div>
      <h2 class="section-title">Contact Us</h2>
      <div class="divider center"></div>
      <p class="section-sub mx-auto">Ready to transform your digital vision into reality? Let's talk.</p>
    </div>
    <div class="row g-4 align-items-stretch">
      <div class="col-lg-7">
        <div class="contact-form-wrap h-100">
          <h3 style="font-size:1.4rem;font-weight:800;margin-bottom:24px;">Send a Message</h3>
          <form id="contactForm">
            <div class="row g-3">
              <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:6px;display:block;">Full Name *</label>
                <input type="text" name="name" class="form-ctrl" placeholder="Your full name" required>
              </div>
              <div class="col-md-6">
                <label style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:6px;display:block;">Email Address *</label>
                <input type="email" name="email" class="form-ctrl" placeholder="your@email.com" required>
              </div>
              <div class="col-12">
                <label style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:6px;display:block;">Subject *</label>
                <input type="text" name="subject" class="form-ctrl" placeholder="How can we help you?" required>
              </div>
              <div class="col-12">
                <label style="font-size:13px;font-weight:600;color:var(--text-dark);margin-bottom:6px;display:block;">Message *</label>
                <textarea name="message" class="form-ctrl" rows="6" placeholder="Tell us about your project..." required style="resize:none;"></textarea>
              </div>
              <div class="col-12">
                <button type="submit" class="btn-submit" id="submitBtn">
                  <i class="fas fa-paper-plane"></i> Send Message
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="contact-info-card">
          <h3>Let's Build Together</h3>
          <p>We're ready to help transform your ideas into powerful digital solutions.</p>
          <div class="c-info-item">
            <div class="c-info-icon"><i class="fas fa-map-marker-alt"></i></div>
            <div><div class="c-info-label">Location</div><div class="c-info-val"><?= htmlspecialchars($companyAddress) ?></div></div>
          </div>
          <div class="c-info-item">
            <div class="c-info-icon"><i class="fas fa-phone"></i></div>
            <div><div class="c-info-label">Phone</div><div class="c-info-val"><?= htmlspecialchars($companyPhone) ?></div></div>
          </div>
          <div class="c-info-item">
            <div class="c-info-icon"><i class="fas fa-envelope"></i></div>
            <div><div class="c-info-label">Email</div><div class="c-info-val"><?= htmlspecialchars($companyEmail) ?></div></div>
          </div>
          <div class="c-info-item">
            <div class="c-info-icon"><i class="fas fa-clock"></i></div>
            <div><div class="c-info-label">Working Hours</div><div class="c-info-val">Mon – Fri: 9AM – 6PM</div></div>
          </div>
          <div class="social-row">
            <a href="<?= htmlspecialchars($fbLink) ?>" class="social-btn"><i class="fab fa-facebook-f"></i></a>
            <a href="<?= htmlspecialchars($twLink) ?>" class="social-btn"><i class="fab fa-twitter"></i></a>
            <a href="<?= htmlspecialchars($liLink) ?>" class="social-btn"><i class="fab fa-linkedin-in"></i></a>
            <a href="<?= htmlspecialchars($igLink) ?>" class="social-btn"><i class="fab fa-instagram"></i></a>
            <a href="<?= htmlspecialchars($ghLink) ?>" class="social-btn"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FOOTER -->
<footer class="site-footer">
  <div class="container">
    <div class="row g-5">
      <div class="col-lg-4">
        <div class="footer-brand-name">Mantra<span>Tech</span></div>
        <p class="footer-tagline">Transforming digital landscapes with innovative solutions and exceptional craftsmanship since 2015.</p>
        <div class="footer-social">
          <a href="<?= htmlspecialchars($fbLink) ?>"><i class="fab fa-facebook-f"></i></a>
          <a href="<?= htmlspecialchars($twLink) ?>"><i class="fab fa-twitter"></i></a>
          <a href="<?= htmlspecialchars($liLink) ?>"><i class="fab fa-linkedin-in"></i></a>
          <a href="<?= htmlspecialchars($igLink) ?>"><i class="fab fa-instagram"></i></a>
          <a href="<?= htmlspecialchars($ghLink) ?>"><i class="fab fa-github"></i></a>
        </div>
      </div>
      <div class="col-lg-2 col-md-4">
        <div class="footer-heading">Quick Links</div>
        <ul class="footer-links">
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About Us</a></li>
          <li><a href="#services">Services</a></li>
          <li><a href="#portfolio">Portfolio</a></li>
          <li><a href="#gallery">Gallery</a></li>
          <li><a href="#contact">Contact</a></li>
        </ul>
      </div>
      <div class="col-lg-3 col-md-4">
        <div class="footer-heading">Our Services</div>
        <ul class="footer-links">
          <?php foreach(array_slice($services, 0, 5) as $svc): ?>
          <li><a href="#services"><?= htmlspecialchars($svc['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <div class="col-lg-3 col-md-4">
        <div class="footer-heading">Contact Info</div>
        <div style="font-size:14px; line-height:2;">
          <div style="color:rgba(255,255,255,.5);"><i class="fas fa-map-marker-alt me-2" style="color:#a5b4fc;"></i><?= htmlspecialchars($companyAddress) ?></div>
          <div style="color:rgba(255,255,255,.5);"><i class="fas fa-phone me-2" style="color:#a5b4fc;"></i><?= htmlspecialchars($companyPhone) ?></div>
          <div style="color:rgba(255,255,255,.5);"><i class="fas fa-envelope me-2" style="color:#a5b4fc;"></i><?= htmlspecialchars($companyEmail) ?></div>
        </div>
        <div style="margin-top:20px;">
          <a href="admin/login.php" style="font-size:12px; color:rgba(255,255,255,.25); text-decoration:none;">
            <i class="fas fa-lock me-1"></i> Admin Panel
          </a>
        </div>
      </div>
    </div>
    <div class="footer-divider">
      &copy; <?= date('Y') ?> <?= htmlspecialchars($companyName) ?>. All rights reserved. | Crafted with <i class="fas fa-heart" style="color:#f87171;"></i> in Nepal
    </div>
  </div>
</footer>

<!-- Toast -->
<div class="toast-msg" id="toastMsg">
  <i class="fas fa-check-circle" id="toastIcon"></i>
  <span id="toastText"></span>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<script>
// Swiper
new Swiper('.hero-swiper', {
  loop: true, speed: 900,
  autoplay: { delay: 7000, disableOnInteraction: false },
  navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
  pagination: { el: '.swiper-pagination', clickable: true },
  effect: 'fade', fadeEffect: { crossFade: true }
});

// Sticky nav
window.addEventListener('scroll', () => {
  document.getElementById('siteNav').classList.toggle('scrolled', scrollY > 60);
  // Active nav
  const sections = ['home','about','services','clients','tech','portfolio','gallery','contact'];
  sections.forEach(id => {
    const el = document.getElementById(id);
    if (!el) return;
    const top = el.offsetTop - 80, bot = top + el.offsetHeight;
    document.querySelectorAll('.nav-link-item').forEach(a => {
      if (a.getAttribute('href') === '#' + id) a.classList.toggle('active', scrollY >= top && scrollY < bot);
    });
  });
});

// Mobile nav
document.getElementById('navToggle').addEventListener('click', () => {
  const m = document.getElementById('mobileMenu');
  m.style.display = m.style.display === 'none' ? 'block' : 'none';
});

// Close mobile nav on link click
document.querySelectorAll('#mobileMenu a').forEach(a => {
  a.addEventListener('click', () => document.getElementById('mobileMenu').style.display = 'none');
});

// Smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(a => {
  a.addEventListener('click', e => {
    const target = document.querySelector(a.getAttribute('href'));
    if (target) { e.preventDefault(); window.scrollTo({ top: target.offsetTop - 70, behavior: 'smooth' }); }
  });
});

// Filter logic (generic)
function makeFilter(btnSel, itemSel, catAttr) {
  document.querySelectorAll(btnSel).forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll(btnSel).forEach(b => b.classList.remove('active'));
      this.classList.add('active');
      const f = this.dataset.filter;
      document.querySelectorAll(itemSel).forEach(item => {
        const cat = item.dataset.category;
        const show = f === 'all' || cat === f;
        item.style.display = show ? '' : 'none';
        if (show) item.classList.add('visible');
      });
    });
  });
}
// Tech grid uses .tech-item; Portfolio uses .portfolio-item-wrap; Gallery uses .gallery-item-wrap
document.querySelectorAll('.tech-section .filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.tech-section .filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const f = this.dataset.filter;
    document.querySelectorAll('.tech-item').forEach(item => {
      item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
    });
  });
});
document.querySelectorAll('.portfolio-section .filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.portfolio-section .filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const f = this.dataset.filter;
    document.querySelectorAll('.portfolio-item-wrap').forEach(item => {
      item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
    });
  });
});
document.querySelectorAll('.gallery-section .filter-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    document.querySelectorAll('.gallery-section .filter-btn').forEach(b => b.classList.remove('active'));
    this.classList.add('active');
    const f = this.dataset.filter;
    document.querySelectorAll('.gallery-item-wrap').forEach(item => {
      item.style.display = (f === 'all' || item.dataset.category === f) ? '' : 'none';
    });
  });
});

// Scroll animations
const obs = new IntersectionObserver(entries => {
  entries.forEach(e => { if (e.isIntersecting) e.target.classList.add('visible'); });
}, { threshold: 0.12 });
document.querySelectorAll('.fade-up').forEach(el => obs.observe(el));

// Toast
function showToast(msg, type = 'success') {
  const t = document.getElementById('toastMsg');
  const icon = document.getElementById('toastIcon');
  document.getElementById('toastText').textContent = msg;
  t.className = 'toast-msg ' + type;
  icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
  icon.style.color = type === 'success' ? '#10b981' : '#ef4444';
  t.classList.add('show');
  setTimeout(() => t.classList.remove('show'), 5000);
}

// Contact Form
document.getElementById('contactForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  const btn = document.getElementById('submitBtn');
  btn.innerHTML = '<div class="spin-loader"></div> Sending...';
  btn.disabled = true;
  try {
    const res = await fetch('process/contact.php', { method: 'POST', body: new FormData(this) });
    const data = await res.json();
    if (data.success) {
      showToast(data.message, 'success');
      this.reset();
    } else {
      showToast(data.message, 'error');
    }
  } catch {
    showToast('Something went wrong. Please try again.', 'error');
  }
  btn.innerHTML = '<i class="fas fa-paper-plane"></i> Send Message';
  btn.disabled = false;
});
</script>
</body>
</html>